<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Libraries\RedisManager;
use App\Models\StudentDetailsModel;
use App\Controllers\StudentForm;
use App\Libraries\Smarty;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class InsertData extends BaseController
{
  protected $redis;
  protected $model;
  protected $studentForm;
  protected $smarty;
  public function __construct()
  {
    $this->redis = new RedisManager();
    $this->model = new StudentDetailsModel();
    $this->studentForm = new StudentForm();
    $this->smarty = new Smarty();
    $this->smarty->assign('base_url', base_url());
    $this->smarty->assign('no_data', "No Data Found!");
    // echo get_class(\Config\Services::cache());
    // die;
  }
  public function validateDob($dob)
  {

    if ($dob === null || $dob === '') {
      return null;
    }


    if (is_numeric($dob)) {
      try {
        $date = ExcelDate::excelToDateTimeObject($dob);
        return $date->format('Y-m-d');
      } catch (\Exception $e) {
        return false;
      }
    }

    $dob = trim((string)$dob);

    $formats = [
      'Y-m-d',
      'd-m-Y',
      'Y-m-d H:i:s',
      'd/m/Y',
      'm/d/Y',
      'n/j/Y'
    ];


    foreach ($formats as $format) {
      $date = \DateTime::createFromFormat($format, $dob);
      if ($date && $date->format($format) === $dob) {
        return $date->format('Y-m-d');
      }
    }

    return false;
  }

  public function importExcel()
  {
    $file = $this->request->getFile('excelFile');

    if (!$file || !$file->isValid()) {
      return redirect()->to('insertData/display')->with('error', 'Invalid file upload');
    }

    $extension = strtolower($file->getClientExtension());

    if (!in_array($extension, ['xls', 'xlsx'])) {
      return redirect()->to('insertData/display')->with('error', 'Only .xls or .xlsx allowed');
    }

    try {
      $spreadsheet = IOFactory::load($file->getTempName());
    } catch (\Exception $e) {
      return redirect()->to('insertData/display')->with('error', 'Error reading Excel file');
    }

    $sheetData = $spreadsheet->getActiveSheet()->toArray();

    if (count($sheetData) <= 1) {
      return redirect()->to('insertData/display')->with('error', 'Excel file is empty');
    }


    $header = array_map(function ($value) {
      return trim($value);
    }, $sheetData[0]);

    unset($sheetData[0]);

    $data = [];
    $page = $this->request->getVar('page') ?? 1;

    $requiredFields = [
      'ROLL NO',
      'FIRST NAME',
      'LAST NAME',
      'FATHER NAME',
      'DOB',
      'MOBILE',
      'EMAIL',
      'PASSWORD',
      'GENDER',
      'DEPARTMENT',
      'COURSE',
      'CITY',
      'ADDRESS'
    ];

    $missingHeaders = array_diff($requiredFields, $header);

    if (!empty($missingHeaders)) {
      return redirect()->to('insertData/display')->with(
        'error',
        'Missing columns: ' . implode(', ', $missingHeaders)
      );
    }

    $errors = [];

    $mobilePattern = "/^[6-9]\d{9}$/";
    $emailPattern  = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    $rowNumber = 2;
    foreach ($sheetData as $row) {

      $rowData = array_combine($header, $row);
      $rowDataLower = array_change_key_case($rowData, CASE_LOWER);
      $missing = false;

      foreach ($requiredFields as $field) {
        if (!isset($rowData[$field]) || trim($rowData[$field]) === '') {
          $errors[] = "Row {$rowNumber}: {$field} is required";
          $missing = true;
          break;
        }
      }

      if ($missing) continue;

      $mobile = preg_replace('/\D/', '', $rowDataLower['mobile']);
      if (!preg_match($mobilePattern, $mobile)) {
        $errors[] = "Row {$rowNumber}: Invalid mobile number";
        continue;
      }

      if (!preg_match($emailPattern, $rowDataLower['email'])) {
        $errors[] = "Row {$rowNumber}: Invalid email";
        continue;
      }

      $dob = $this->validateDob($rowData['DOB']);

      if ($dob === false) {
        $dob = null;
      }

      $data[] = [
        'rollNo'      => trim($rowData['ROLL NO']),
        'fname'       => trim($rowData['FIRST NAME']),
        'lname'       => trim($rowData['LAST NAME']),
        'father_name' => trim($rowData['FATHER NAME']),
        'dob' => $dob,
        'mobile'      => $mobile,
        'email'       => trim($rowData['EMAIL']),
        'password'    => $this->studentForm->encryptText($rowData['PASSWORD']),
        'gender'      => trim($rowData['GENDER']),
        'department'  => trim($rowData['DEPARTMENT']),
        'course'      => trim($rowData['COURSE']),
        'city'        => trim($rowData['CITY']),
        'address'     => trim($rowData['ADDRESS']),
      ];
      $rowNumber++;
    }

    if (empty($data)) {
      return redirect()->to('insertData/display')->with('error', implode(', ', $errors));
    }

    try {
      $this->redis->flushAll();
      $this->redis->delete('user', 'page_' . $page);
      $this->model->insertItem($data);
      $this->redis->clearNamespace('user_');

      return redirect()->to('insertData/display')
        ->with('success', count($data) . ' record(s) imported successfully');
    } catch (\Exception $e) {
      return redirect()->to('insertData/display')->with('error', 'Database error: ' . $e->getMessage());
    }
  }

  public function sampleExcel()
  {
    $fileName = 'sample-excel-' . date('Ymd_His') . '.xlsx';

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();


    $headers = [
      'ROLL NO',
      'FIRST NAME',
      'LAST NAME',
      'FATHER NAME',
      'DOB',
      'MOBILE',
      'EMAIL',
      'PASSWORD',
      'GENDER',
      'DEPARTMENT',
      'COURSE',
      'CITY',
      'ADDRESS'
    ];

    $sheet->fromArray($headers, null, 'A1');


    $lastColumn = $sheet->getHighestColumn();


    $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
      'font' => [
        'bold' => true
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
          'rgb' => 'C6EFCE'
        ]
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
          'color' => ['rgb' => '000000']
        ]
      ]
    ]);


    foreach (range('A', $lastColumn) as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
    }


    $writer = new Xlsx($spreadsheet);
    $tempFile = WRITEPATH . 'exports/' . $fileName;
    $writer->save($tempFile);

    return $this->response->download($tempFile, null)
      ->setFileName($fileName);
  }

  public function exportData()
  {
    $items = $this->model->findAllItems();

    if (empty($items)) {
      return $this->response->setJSON([
        'status' => 0,
        'message' => 'No data found'
      ]);
    }

    $fileName = 'students-export-' . date('Ymd_His') . '.xlsx';

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
      "S.NO",
      'ROLL NO',
      'FIRST NAME',
      'LAST NAME',
      'FATHER NAME',
      'DOB',
      'MOBILE',
      'EMAIL',
      'PASSWORD',
      'GENDER',
      'DEPARTMENT',
      'COURSE',
      'CITY',
      'ADDRESS'
    ];

    $sheet->fromArray($headers, null, 'A1');

    // Data
    $row = 2;
    foreach ($items as $item) {
      unset($item['file']);
      $column = 'A';
      foreach ($item as $value) {
        $sheet->setCellValue($column . $row, $value);
        $column++;
      }
      $row++;
    }

    $lastColumn = $sheet->getHighestColumn();


    $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
      'font' => [
        'bold' => true
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
          'rgb' => 'C6EFCE'
        ]
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
          'color' => ['rgb' => '000000']
        ]
      ]
    ]);

    foreach (range('A', $sheet->getHighestColumn()) as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $writer = new Xlsx($spreadsheet);
    $writer->setPreCalculateFormulas(false);

    $tempFile = WRITEPATH . 'exports/' . $fileName;
    $writer->save($tempFile);

    $fileContent = file_get_contents($tempFile);
    unlink($tempFile);

    return $this->response
      ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
      ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
      ->setBody($fileContent);
  }

  public function deleteMultiple()
  {
    $ids = $this->request->getVar('ids');

    if (empty($ids) || !is_array($ids)) {
      return $this->response->setJSON([
        'status' => 0,
        'message' => 'No IDs provided'
      ]);
    }

    $this->model->deleteByIds($ids);

    $this->redis->clearNamespace('user');

    return $this->response->setJSON([
      'status' => 1,
      'message' => 'Selected records deleted successfully'
    ]);
  }

  public function displayStudentDetails()
  {
    $page = $this->request->getGet('page') ?? 1;

    $data = $this->redis->get('user', 'page_' . $page);
    if (!$data) {
      $data = $this->model->getAllItems();
      $this->redis->set('user', 'page_' . $page, $data);
    }

    $this->smarty->assign('items', $data['items']);
    $this->smarty->assign('pager', $data['pager']);
    
    $session = session();
    $this->smarty->assign('error', $session->getFlashdata('error'));
    $this->smarty->assign('success', $session->getFlashdata('success'));

    return $this->smarty->display('studentFormDetails.tpl');
  }
}
