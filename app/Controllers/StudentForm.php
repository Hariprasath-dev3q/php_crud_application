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
    protected StudentFormModel $database;
    protected $smarty;
    protected $message;
    protected $redis;


    public function __construct()
    {
        $this->database = new StudentFormModel();
        $this->smarty = new Smarty();
        $this->message = new stdClass();
        $this->message->status = 0;
        $this->smarty->assign('base_url', base_url());
        $this->smarty->assign('no_data', "No Data Found!");
        $this->redis = new RedisManager();
        //dd(is_file(APPPATH . 'Views/Pager/custom_pager.php'));

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

    // public function importExcel()
    // {
    //     $file = $this->request->getFile('excelFile');
    //     if (!$file || !$file->isValid() || $file->getName() === '') {
    //         return redirect()->back()->with('error', 'No file uploaded or file is invalid');
    //     }
    //     $extension = $file->getClientExtension();
    //     $data = [];
    //     try {
    //         $spreadsheet = IOFactory::load($file->getTempName());
    //     } catch (\Exception $e) {
    //         if (!in_array($extension, ['xls', 'xlsx'])) {
    //             return redirect()->back()->with('error', 'Invalid file format: ' . $e->getMessage());
    //         }
    //     }
    //     $sheetData = $spreadsheet->getActiveSheet()->toArray();
    //     foreach ($sheetData as $key => $row) {
    //         if ($key == 0) continue;
    //         //if (empty($row[0])) continue;
    //         $data[] = [
    //             'rollNo' => $row[0],
    //             'fname' => $row[1],
    //             'lname' => $row[2],
    //             'father_name' => $row[3],
    //             'dob' => $row[4],
    //             'mobile' => $row[5],
    //             'email' => $row[6],
    //             'password' => $this->encryptText($row[7]),
    //             'gender' => $row[8],
    //             'department' => $row[9],
    //             'course' => $row[10],
    //             'city' => $row[11],
    //             'address' => $row[12],
    //         ];
    //     }
    //     // print_r($data);
    //     // exit;
    //     $page = $this->request->getGet('page') ?? 1;
    //     if (!empty($data)) {
    //         $this->redis->flushAll();
    //         $this->redis->delete('user', 'page_' . $page);
    //         $this->redis->clearNamespace('user');
    //         $this->database->insertBatch($data);
    //     }
    //     return redirect()->to('studentform/display')->with('success', 'Data imported successfully');
    // }

    // public function deleteMultiple()
    // {
    //     $ids = $this->request->getVar('ids');
    //     if (empty($ids) || !is_array($ids)) {
    //         return $this->response->setJSON([
    //             'status' => 0,
    //             'message' => 'No IDs provided'
    //         ]);
    //     }

    //     foreach ($ids as $id) {
    //         $this->database->deleteItemById($id);
    //     }

    //     return $this->response->setJSON([
    //         'status' => 1,
    //         'message' => 'Selected records deleted successfully'
    //     ]);
    // }

    public function importJson()
    {
        $service = new \App\Services\ImportService();
        $path = ROOTPATH . 'public/generated_data.json';

        if (! file_exists($path)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'JSON file not found'
            ]);
        }

        $service->importFromJson($path);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data imported successfully'
        ]);
    }


    public function deleteItem()
    {
        $id = $this->request->getVar('id');
        $photo = $this->request->getVar('photoUrl');

        $imagePath = FCPATH . $photo;
        if (!empty($photo) && file_exists($imagePath)) {
            unlink($imagePath);
        }
        $this->database->deleteItemById($id);
        return $this->response->setJSON([
            'status' => 1,
            'message' => 'Record deleted successfully'
        ]);
    }

    public function getItems()
    {
        $this->smarty->assign('addUserUrl', url_to('StudentForm::index'));
        $this->smarty->assign('editUrl', url_to('StudentForm::index'));
        // $page = $this->request->getGet('page') ?? 1;

        // $data = $this->redis->get('user', 'page_' . $page);
        // if (!$data) {
        //     $data = $this->database->getAllItems();
        //     $this->redis->set('user', 'page_' . $page, $data);
            
        // }
         $data = $this->database->getAllItems();


        $this->smarty->assign('items', $data['items']);
        $this->smarty->assign('pager', $data['pager']);

        // $this->smarty->assign('total', $total);  
        return $this->smarty->display('studentDetails.tpl');
    }

    public function editItem($id)
    {
        $item = $this->database->getItemById($id);

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
            //echo $fileName;
            $oldFile = $this->old_file ?? null;
            //echo $oldFile;

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

                $this->database->updateItemById($json->editId, $updateData);

                return $this->response->setJSON([
                    'status' => 1,
                    'message' => 'Record updated successfully'
                ]);
            } else {
                // Insert new record
                $this->database->insertItem([
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
