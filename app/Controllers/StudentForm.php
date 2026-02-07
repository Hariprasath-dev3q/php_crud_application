<?php

namespace App\Controllers;

use App\Libraries\Smarty;
use App\Models\StudentFormModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use stdClass;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Libraries\RedisManager;

class StudentForm extends BaseController
{
    protected StudentFormModel $StudentFormModel;
    protected $smarty;
    protected $message;
    protected $redis;


    public function __construct()
    {
        $this->StudentFormModel = new StudentFormModel();
        $this->smarty = new Smarty();
        $this->message = new stdClass();
        $this->message->status = 0;
        $this->smarty->assign('base_url', base_url());
        $this->smarty->assign('no_data', "No Data Found!");
    }

    public function index()
    {
        $item = new \stdClass();
        $item->rollNo = '';
        $item->fname = '';
        $item->lname = '';
        $item->father_name = '';
        $item->dob = '';
        $item->mobile = '';
        $item->email = '';
        $item->password = '';
        $item->gender = '';
        $item->department = '';
        $item->course = '';
        $item->file = '';
        $item->city = '';
        $item->address = '';
        $item->id = '';

        $this->smarty->assign('item', (array)$item);
        return $this->smarty->display('studentForm.tpl');
    }

    


    public function deleteItem()
    {
        $id = $this->request->getVar('id');
        $photo = $this->request->getVar('photoUrl');

        $imagePath = FCPATH . $photo;
        if (!empty($photo) && file_exists($imagePath)) {
            unlink($imagePath);
        }
        $this->StudentFormModel->deleteItemById($id);

        $this->fileCache->delete('student_list');

        return $this->response->setJSON([
            'status' => 1,
            'message' => 'Record deleted successfully'
        ]);
    }

    public function getItems()
    {
        $this->smarty->assign('addUserUrl', url_to('StudentForm::index'));
        $this->smarty->assign('editUrl', url_to('StudentForm::index'));

        $data = $this->fileCache->get('student_list');

        if ($data === null) {

            $data = $this->StudentFormModel->getAllItems();
            $this->fileCache->save('student_list', $data, 3600);
        }

        $this->smarty->assign('items', $data['items']);
        $this->smarty->assign('pager', $data['pager']);

        return $this->smarty->display('studentDetails.tpl');
    }

    public function editItem($id)
    {
        $item = $this->StudentFormModel->getItemById($id);

        if (!$item) {
            throw PageNotFoundException::forPageNotFound();
        }
        $item['password'] = $this->decryptText($item['password']);

        $this->smarty->assign('item', $item);
        return $this->smarty->display('studentForm.tpl');
    }

    private $encryptionKey = 'hnZs6%aExcFrSyMM';

    public function encryptText(string $text): string
    {
        $cipher = 'aes-256-cbc';
        $hashLength = substr(hash('sha256', $this->encryptionKey), 0, 16);

        $encrypted = openssl_encrypt($text, $cipher, $this->encryptionKey, OPENSSL_RAW_DATA, $hashLength);

        return base64_encode($encrypted);
    }

    public function decryptText(string $encryptedText): string|false
    {
        $cipher = 'aes-256-cbc';
        $hashLength = substr(hash('sha256', $this->encryptionKey), 0, 16);

        $decoded = base64_decode($encryptedText);

        return openssl_decrypt($decoded, $cipher, $this->encryptionKey, OPENSSL_RAW_DATA, $hashLength);
    }

    public function saveItems()
    {

        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 0,
                'message' => 'Invalid request'
            ]);
        }

        try {

            $json = $this->request->getJSON();

            if (!$json) {
                return $this->response->setJSON([
                    'status' => 0,
                    'message' => 'No data received'
                ]);
            }

            $rules = [
                'studentRollNo' => 'required|max_length[25]|trim',
                'studentFirstName' => 'required|max_length[35]|trim',
                'studentLastName' => 'required|max_length[25]|trim',
                'fatherName' => 'required|max_length[35]|trim',
                'dateOfBirth' => 'required|valid_date',
                'mobileNumber' => 'required|numeric|exact_length[10]|trim',
                'email' => 'required|valid_email|max_length[50]|trim',
                'password' => 'required|min_length[6]|max_length[8]|trim',
                'gender' => 'required|in_list[male,female]|trim',
                'department' => 'required',
                'course' => 'required',
                'city' => 'required|max_length[35]|trim',
                'address' => 'required|max_length[70]|trim',
            ];

            $data = [
                'studentRollNo' => $json->studentRollNo ?? '',
                'studentFirstName' => $json->studentFirstName ?? '',
                'studentLastName' => $json->studentLastName ?? '',
                'fatherName' => $json->fatherName ?? '',
                'dateOfBirth' => $json->dateOfBirth ?? '',
                'mobileNumber' => $json->mobileNumber ?? '',
                'email' => $json->email ?? '',
                'password' => $json->password ?? '',
                'gender' => $json->gender ?? '',
                'department' => $json->department ?? '',
                'course' => $json->course ?? '',
                'city' => $json->city ?? '',
                'address' => $json->address ?? '',
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 0,
                    'message' => 'Validation failed',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $fileName = null;
            if (!empty($json->studentPic)) {
                $base64Image = $json->studentPic;

                if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                    $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                    $type = strtolower($type[1]);

                    $base64Image = base64_decode($base64Image);

                    if ($base64Image !== false) {

                        $uploadPath = '../public/uploads/';
                        $fileName = $uploadPath . uniqid() . '.' . $type;

                        if (!is_dir($uploadPath)) {
                            mkdir($uploadPath, 0755, true);
                        }
                        file_put_contents($fileName, $base64Image);
                    }
                }
            }

            $oldFile = $this->old_file ?? null;

            // Check if it's an update or insert
            if (!empty($json->editId)) {
                // Update existing record
                $updateData = [
                    'rollNo'      => $data['studentRollNo'],
                    'fname'       => $data['studentFirstName'],
                    'lname'       => $data['studentLastName'],
                    'father_name' => $data['fatherName'],
                    'dob'         => $data['dateOfBirth'],
                    'mobile'      => $data['mobileNumber'],
                    'email'       => $data['email'],
                    'password'    => $this->encryptText($data['password']),
                    'gender'      => $data['gender'],
                    'department'  => $data['department'],
                    'course'      => $data['course'],
                    'city'        => $data['city'],
                    'address'     => $data['address'],
                ];

                if (!empty($fileName)) {
                    $updateData['file'] = $fileName;
                }
                if (!empty($oldFile)) {

                    if (!empty($fileName) && is_file(FCPATH . $fileName)) {
                        unlink(FCPATH . $fileName);
                    }
                    $updateData['file'] = $oldFile;
                }

                $this->StudentFormModel->updateItemById($json->editId, $updateData);
                $this->fileCache->delete('student_list');
                return $this->response->setJSON([
                    'status' => 1,
                    'message' => 'Record updated successfully'
                ]);
            } else {
                // Insert new record
                $this->StudentFormModel->insertItem([
                    'rollNo'      => $data['studentRollNo'],
                    'fname'       => $data['studentFirstName'],
                    'lname'       => $data['studentLastName'],
                    'father_name' => $data['fatherName'],
                    'dob'         => $data['dateOfBirth'],
                    'mobile'      => $data['mobileNumber'],
                    'email'       => $data['email'],
                    'password'    => $this->encryptText($data['password']),
                    'gender'      => $data['gender'],
                    'department'  => $data['department'],
                    'course'      => $data['course'],
                    'file'        => $fileName,
                    'city'        => $data['city'],
                    'address'     => $data['address'],
                ]);

                $this->fileCache->delete('student_list');
                return $this->response->setJSON([
                    'status' => 1,
                    'message' => 'Student registered successfully'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 0,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }
}
