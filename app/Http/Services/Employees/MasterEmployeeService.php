<?php
namespace App\Http\Services\Employees;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\UtilHelper;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Excel;
use Carbon\Carbon;
use App\Http\Repositories\Employees\MasterEmployeeRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MasterEmployeeService{
  private $masterEmployeeRepository;

  public function __construct(MasterEmployeeRepository $masterEmployeeRepository)
  {
    $this->masterEmployeeRepository = $masterEmployeeRepository;
  }

  public function tambahDataBrand($params){
    try {
      $validator = Validator::make($params->all(), [
        'md' => 'required|string',
        'brand' => 'required|string',
        'supplier' => 'required|string'
      ]);

      if ($validator->fails()){
        return response()->json([
          'success' => false,
          'message' => $validator->errors()
        ], 422);
      }

      $current_date = date('Ym');
      $last_data = $this->masterEmployeeRepository->getLastData($current_date);

      if ($last_data){
        $last_number = (int) substr($last_data->id_brand_emp, -3);
        $new_number = str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);
      } else{
        $new_number = '001';
      }

      $id_brand = $current_date . $new_number;
      $new_data = [
        'user_create' => 'system',
        'date_create' => now(),
        'md' => $params->md,
        'detail_brand' => $params->brand,
        'nama_supplier' => $params->supplier,
        'id_brand_emp' => $id_brand
      ];
      $this->masterEmployeeRepository->tambahDataBrand($new_data);

      return response()->json([
        'success' => true,
        'message' => 'Data berhasil ditambahkan',
        'data' => $id_brand
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Gagal menambahkan data: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getDataBrand(){
    try {
      $result = $this->masterEmployeeRepository->getDataBrand();
      return $result;
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Gagal menampilkan data: ' . $e->getMessage()
      ], 500);
    }
  }

  public function downloadTemplate(){
    $spreadsheet = new Spreadsheet();

    $sheet1 = $spreadsheet->getActiveSheet();
    $sheet1->setTitle('Sheet1');

    $formatHeader = ['Nama', 'Tanggal Lahir', 'Alamat', 'Kode Toko', 'MD', 'Brand', 'Nama Supplier', 'No Handphone', 'Tanggal Masuk', 'No Kartu Keluarga', 'No KTP', 'Jenis Kelamin', 'Status', 'Kategori'];

    $formatData = ['John', '31-05-2025', 'Jl. Mawar, Jakarta', 'R128', 'M2D', 'LEE CONTI JEANS', 'MAXINDO CV', '082222222222', '31-05-2025', '0989384738272192', '0989384738272192', 'L', '1', 'SPG'];

    $note = ['Note: * BARIS DIATAS HANYA CONTOH, JANGAN DIHAPUS', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Keterangan:'];
    $ket1 = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '1. Laki-Laki: L'];
    $ket2 = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '2. Perempuan: P'];
    $ket3 = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '3. Belum Menikah: 1'];
    $ket4 = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '4. Menikah: 2'];
    $ket5 = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '5. Duda: 3'];
    $ket6 = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '6. Janda: 4'];


    $headers1 = ['Nama', 'Tanggal Lahir', 'Alamat', 'Kode Toko', 'MD', 'Brand', 'Nama Supplier', 'No Handphone', 'Tanggal Masuk', 'No Kartu Keluarga', 'No KTP', 'Jenis Kelamin', 'Status', 'Kategori'];

    $sheet2 = $spreadsheet->createSheet();
    $sheet2->setTitle('Master Brand');

    $headers2 = ['MD', 'Brand', 'Nama Supplier'];

    // Set header sheet1
    foreach ($formatHeader as $index => $header) {
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
        $sheet1->setCellValue($col . '1', $header);
        $sheet1->getStyle($col . '1')->getFont()->setBold(true);
        $sheet1->getColumnDimension($col)->setWidth(20);
    }

    foreach ($headers1 as $index => $header) {
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
        $sheet1->setCellValue($col . '10', $header);
        $sheet1->getStyle($col . '10')->getFont()->setBold(true);
        $sheet1->getColumnDimension($col)->setWidth(20);
    }

    // Set header sheet2
    foreach ($headers2 as $index => $header) {
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
        $sheet2->setCellValue($col . '1', $header);
        $sheet2->getStyle($col . '1')->getFont()->setBold(true);
        $sheet2->getColumnDimension($col)->setWidth(10);
        $sheet2->getColumnDimension('B')->setWidth(25);
        $sheet2->getColumnDimension('C')->setWidth(40);
        $sheet2->getStyle('B')->getAlignment()->setWrapText(true);
    }

    foreach ($formatData as $index => $value) {
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
        $sheet1->setCellValue($col . '2', $value);
        
        if ($index + 1 == 2 || $index + 1 == 7) {
            $sheet1->getStyle($col . '2')->getNumberFormat()->setFormatCode('dd-mm-yyyy');
        }
    }

    $sheet1->getStyle('B:B')->getNumberFormat()->setFormatCode('dd-mm-yyyy');
    $sheet1->getStyle('G:G')->getNumberFormat()->setFormatCode('dd-mm-yyyy');

    foreach ($note as $index => $value) {
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
        $sheet1->setCellValue($col . '3', $value);
        $sheet1->getStyle($col . '3')->getFont()->setBold(true);
    }
    foreach ($ket1 as $index => $value) {
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
        $sheet1->setCellValue($col . '4', $value);
    }
    foreach ($ket2 as $index => $value) {
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
        $sheet1->setCellValue($col . '5', $value);
    }
    foreach ($ket3 as $index => $value) {
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
        $sheet1->setCellValue($col . '6', $value);
    }
    foreach ($ket4 as $index => $value) {
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
        $sheet1->setCellValue($col . '7', $value);
    }
    foreach ($ket5 as $index => $value) {
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
        $sheet1->setCellValue($col . '8', $value);
    }
    foreach ($ket6 as $index => $value) {
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
        $sheet1->setCellValue($col . '9', $value);
    }

    $params = new \Illuminate\Http\Request();
    $params->merge(['searchTerm' => '']);

    // $allData = $this->masterEmployeesInterface->detailData();

    // $row = 2;
    // foreach ($allData as $data) {
    //     $sheet2->setCellValue('A' . $row, $data->md);
    //     $sheet2->setCellValue('B' . $row, $data->detail_brand);
    //     $sheet2->setCellValue('C' . $row, $data->nama_supplier);
    //     $row++;
    // }


    $response = new StreamedResponse(function () use ($spreadsheet) {
        if (ob_get_contents()) {
            ob_end_clean();
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
    });

    $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $response->headers->set('Content-Disposition', 'attachment; filename="template.xlsx"');
    $response->headers->set('Cache-Control', 'max-age=0');

    return $response;
  }

  public function getEmployees(){
    try {
      // $store_code = [];

      // $params = [
      //   'store_code' => $store_code
      // ];

      $result = $this->masterEmployeeRepository->getDataEmployees();

      return response()->json([
        'success' => true,
        'data' => $result
      ], 200);
      
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Gagal mendapatkan data: ' . $e
      ], 500);
    }
  }
  public function addNewEmployee($request)
  {
      try {
          // 1. Validasi Input (Sesuaikan 'image' dengan field JS)
          $validator = Validator::make($request->all(), [
              'name'          => 'required|string|max:255',
              'address'       => 'required|string',
              'birthday'      => 'required',
              'store'         => 'required|string',
              'noHandphone'   => 'required|string|max:20',
              'joinDate'      => 'required',
              'kk'            => 'required|string|max:20',
              'ktp'           => 'required|string|max:20|unique:master_employee_spg,no_ktp',
              'gender'        => 'required|in:L,P',
              'status'        => 'required|in:1,2,3,4',
              'md'            => 'required|string',
              'detail_brand'  => 'required|string',
              'nama_supplier' => 'required|string',
              'category'      => 'required|string',
              'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
          ]);

          if ($validator->fails()) {
              return response()->json([
                  'success' => false,
                  'errors'  => $validator->errors()
              ], 422);
          }

          // 2. Ambil Kategori & Generate ID Employee
          $category = $request->category;
          
          $data_kategori = $this->masterEmployeeRepository->categoryEmployee($request->category);

          $lastId = $data_kategori ? $data_kategori->id_employee : null;

          if ($category === 'SPG') {
              $id_employee = empty($lastId) ? '9000001' : (string)((int)$lastId + 1);
          } else {
              $id_employee = empty($lastId) ? '8000001' : (string)((int)$lastId + 1);
          }

          // 3. Upload Gambar
          $imagePath = null;
          if ($request->hasFile('image')) {
              $image = $request->file('image');
              $imageName = 'employee_' . $id_employee . '.' . $image->getClientOriginalExtension();
              $image->move(public_path('images'), $imageName);
              $imagePath = 'images/' . $imageName;
          }

          // Helper untuk parse tanggal (mencegah error format d-m-Y vs Y-m-d)
          $parseDate = function($dateString) {
              try {
                  return Carbon::createFromFormat('d-m-Y', $dateString)->format('Y-m-d');
              } catch (\Exception $e) {
                  return Carbon::parse($dateString)->format('Y-m-d');
              }
          };

          // 4. Buat Payload Data Employee
          $newData = [
              'user_create'       => Auth::user()->username ?? 'system',
              'date_create'       => now(),
              'nama'              => $request->input('name'),
              'alamat'            => $request->input('address'),
              'kategori_karyawan' => $request->input('category'),
              'tanggal_lahir'     => $parseDate($request->input('birthday')),
              'kode_toko'         => $request->input('store'),
              'no_handphone'      => $request->input('noHandphone'),
              'tanggal_masuk'     => $parseDate($request->input('joinDate')),
              'no_kk'             => $request->input('kk'),
              'no_ktp'            => $request->input('ktp'),
              'jenis_kelamin'     => $request->input('gender'),
              'status'            => $request->input('status'),
              'md_emp'            => $request->input('md'),
              'brand_emp'         => $request->input('detail_brand'),
              'supplier'          => $request->input('nama_supplier'),
              'id_employee'       => $id_employee,
              'status_aktif'      => '0',
              'image_employee'    => $imagePath
          ];

          $new_employee = $this->masterEmployeeRepository->addNewEmployee($newData);

          // 5. Buat Data Mutasi
          $newMutasi = [
              'user_create'       => Auth::user()->username ?? 'system',
              'date_create'       => now(),
              'nama'              => $request->input('name'),
              'tanggal_masuk'     => $parseDate($request->input('joinDate')),
              'kategori_karyawan' => $category,
              'kode_toko'         => $request->input('store'),
              'md_emp'            => $request->input('md'),
              'brand_emp'         => $request->input('detail_brand'),
              'supplier'          => $request->input('nama_supplier'),
              'no_kk'             => $request->input('kk'),
              'no_ktp'            => $request->input('ktp'),
              'id_employee'       => $id_employee
          ];

          $this->masterEmployeeRepository->addNewMutasi($newMutasi);

          return response()->json([
              'success' => true,
              'message' => 'Data berhasil disimpan',
              'data' => $new_employee
          ], 200);

      } catch (\Exception $e) {
          return response()->json([
              'success' => false,
              'message' => 'Gagal menambahkan data: ' . $e->getMessage()
          ], 500);
      }
  }
  public function excelToArrayWithMapping($path, $fieldMaps) {
    $spreadsheet = IOFactory::load($path);
    $data = [];

    foreach($fieldMaps as $sheetName => $fieldMap) {
      if (!$spreadsheet->sheetNameExists($sheetName)) {
        continue;
      }

      $sheet = $spreadsheet->getSheetByName($sheetName);
      $highestRow = $sheet->getHighestDataRow();
      $highestCol = $sheet->getHighestDataColumn();

      $headers = [];
      for($col = 'A'; $col <= $highestCol; $col++) {
        $headerValue = $sheet->getCell($col . '10')->getValue();
        $headers[$col] = trim($headerValue ?? '');
      }

      for($row = 11; $row <= $highestRow; $row++) {
        $rowData = [];

        foreach($headers as $col => $headerName) {
          if (!empty($headerName) && isset($fieldMap[$headerName])) {
            $cell = $sheet->getCell($col . $row);
            $cellValue = $cell->getValue();

            if ($cell->getDataType() === \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_FORMULA) {
              $cellValue = $cell->getCalculatedValue();
            }
            
            if (in_array($headerName, ['Tanggal Lahir', 'Tanggal Masuk']) && $cellValue !== null) {
              if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($cell)) {
                  $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($cellValue);
                  $cellValue = date('Y-m-d', $timestamp); 
              } elseif (is_string($cellValue)) {
                  $parsedDate = date_create_from_format('d-m-Y', $cellValue);
                  if ($parsedDate !== false) {
                      $cellValue = $parsedDate->format('Y-m-d'); 
                  } else {
                      $cellValue = $cellValue;
                  }
              }
            }

            $rowData[$fieldMap[$headerName]] = $cellValue;
          }
        }
        if (!empty($rowData)) {
          $data[] = $rowData;
        }
      }
    }
    return $data;
  }
  private function parseDatabaseError($message)
  {
    // Jika terlalu panjang untuk kolom
    if (str_contains($message, 'value too long for type character varying')) {
        preg_match('/character varying\((\d+)\)/', $message, $matches);
        $maxLength = $matches[1] ?? null;
        return $maxLength 
            ? "Data terlalu panjang (maksimal {$maxLength} karakter)"
            : "Data terlalu panjang";
    }

    // Tambahkan pengecekan lain sesuai kebutuhan
    if (str_contains(strtolower($message), 'not null')) {
        return "Ada kolom yang wajib diisi namun kosong";
    }

    // Fallback: pesan umum
    return "Terjadi kesalahan pada data";
  }
  public function addNewUploadEmployee($request) {
    try {
      $fieldMaps = [
        'Sheet1' => [
          'Nama' => 'nama',
          'Tanggal Lahir' => 'tanggal_lahir', 
          'Alamat' => 'alamat', 
          'Kode Toko' => 'kode_toko', 
          'MD' => 'md_emp', 
          'Brand' => 'brand_emp',
          'Nama Supplier' => 'supplier',
          'No Handphone' => 'no_handphone', 
          'Tanggal Masuk' => 'tanggal_masuk', 
          'No Kartu Keluarga' => 'no_kk',
          'No KTP' => 'no_ktp', 
          'Jenis Kelamin' => 'jenis_kelamin', 
          'Status' => 'status',
          'Kategori' => 'kategori_karyawan'
        ]
      ];

      $data = $this->excelToArrayWithMapping($request->file('file_excel')->getRealPath(), $fieldMaps);

      $successCount = 0;
      $errorMessages = [];
      $existingKtpNumbers = [];
      
      $ktpInFile = [];
      foreach ($data as $index => $row) {
          if (!empty($row['no_ktp'])) {
              $ktp = trim($row['no_ktp']);
              if (in_array($ktp, $ktpInFile)) {
                  $errorMessages[] = "No KTP {$ktp} duplikat dalam file Excel";
                  continue;
              }
              $ktpInFile[] = $ktp;
          }
      }

      if (!empty($errorMessages)) {
        return response()->json([
            'success' => false,
            'message' => $errorMessages,
        ], 400);
      }

      $masterBrands = $this->masterEmployeeRepository->detailData();
      $validBrandMap = [];
      foreach ($masterBrands as $mb) {
          $validBrandMap[] = [
              'md' => $mb->md,
              'brand' => $mb->detail_brand,
              'supplier' => $mb->nama_supplier,
          ];
      }

      foreach ($data as $index => $row) {
        try {
            $row['kategori_karyawan'] = strtoupper(trim($row['kategori_karyawan']));
            
            foreach (['tanggal_lahir', 'tanggal_masuk'] as $dateField) {
                if (!empty($row[$dateField])) {
                    if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $row[$dateField])) {
                        $date = \DateTime::createFromFormat('d-m-Y', $row[$dateField]);
                        if ($date) {
                            $row[$dateField] = $date->format('Y-m-d');
                        }
                    }
                }
            }

            if(strlen($row['no_ktp']) == 16) {
                if(strlen($row['no_kk']) == 16) {
                    if (in_array($row['kategori_karyawan'], ['SPG', 'PKL'])) {
                        $existsKtp = $this->masterEmployeeRepository->checkDuplicate('no_ktp', $row['no_ktp']);
                        if (!$existsKtp) {
                            $foundValid = false;
                            foreach ($validBrandMap as $valid) {
                                if ($row['md_emp'] === '021') {
                                    if (
                                        $row['md_emp'] === $valid['md'] ||
                                        $row['brand_emp'] === $valid['brand'] &&
                                        $row['supplier'] === $valid['supplier']
                                    ) {
                                        $foundValid = true;
                                        break;
                                    }
                                } else {
                                    if (
                                    $row['md_emp'] === $valid['md'] &&
                                    $row['brand_emp'] === $valid['brand'] &&
                                    $row['supplier'] === $valid['supplier']
                                    ) {
                                        $foundValid = true;
                                        break;
                                    }
                                }
                            }

                            if ($foundValid) {
                                $lastEmployee = $this->masterEmployeeRepository->idemployee($row['kategori_karyawan']);
        
                                if($row['kategori_karyawan'] === 'SPG') {
                                    $id_employee = empty($lastEmployee) ? 9000001 : $lastEmployee->id_employee + 1;
                                } else {
                                    $id_employee = empty($lastEmployee) ? 8000001 : $lastEmployee->id_employee + 1;
                                }
            
                                $row['id_employee'] = $id_employee;
                                $row['status_aktif'] = '0';
                                $row['user_create'] = Auth::user()->username ?? 'SYSTEM';
                                $row['date_create'] = now();
                                
                                $this->masterEmployeeRepository->uploadData($row);
                                $successCount++;
                            } else {
                                $errorMessages[] = "MD: {$row['md_emp']}, Brand: {$row['brand_emp']}, Supplier: {$row['supplier']} tidak sesuai dengan Master Brand";
                                continue;
                            }
                        } else {
                            $errorMessages[] = "No KTP {$row['no_ktp']} sudah terdaftar di database";
                            continue;
                        }
                    } else {
                        $errorMessages[] = "Kategori karyawan {$row['kategori_karyawan']} tidak valid";
                        continue;
                    }
                } else {
                    $errorMessages[] = "No KK tidak 16 digit.";
                    continue;
                }
            } else {
                $errorMessages[] = "No KTP tidak 16 digit.";
                continue;
            }
        } catch (\Exception $e) {
            $userMessage = $this->parseDatabaseError($e->getMessage());
            $errorMessages[] = $userMessage;
        }
      }

      if ($successCount > 0) {
        $response = [
            'success' => true,
            'message' => 'Berhasil mengupload ' . $successCount . ' data',
            'total_data' => count($data),
            'success_count' => $successCount,
            'errors' => $errorMessages
        ];
        
        if (!empty($errorMessages)) {
            $response['warning'] = 'Beberapa data gagal diupload';
        }
        
        return response()->json($response);
      } else {
        return response()->json([
            'success' => false,
            'message' => $errorMessages,
            'errors' => $errorMessages
        ], 500);
      }
    } catch (\Exception $e) {
      return response()->json([
        "success" => false,
        "message" => 'Gagal memproses data: ' . $e->getMessage()
      ], 500);
    }
  }
  public function getSupplierEmp($params){
    $params['limit'] = 50;
    return $this->masterEmployeeRepository->getSupplierEmp($params);
  }
  public function getTokoEmp($params){
    $params['limit'] = 50;
    return $this->masterEmployeeRepository->getTokoEmployee($params);
  }

  public function getHistoryData($params)
  {
      $result = $this->masterEmployeeRepository->getHistoryData($params);
      return $result;
  }

  public function editData($params)
  {
    try {
      $id_employee = $params->id_employee;
      $imagePath = null;

      if ($params->hasFile('image')) {
          $image = $params->file('image');
          $imageName = 'employee_' . $id_employee . '.' . $image->getClientOriginalExtension();
          $image->move(public_path('images'), $imageName);
          $imagePath = 'images/' . $imageName;
      }

      $dataArray = [
          'tanggal_masuk' => \Carbon\Carbon::createFromFormat('d-m-Y', $params->tanggal_masuk)->format('Y-m-d'),
          'tanggal_lahir' => \Carbon\Carbon::createFromFormat('d-m-Y', $params->tanggal_lahir)->format('Y-m-d'),
          'nama' => $params->nama,
          'alamat' => $params->alamat,
          'kode_toko' => $params->homebase,
          'md_emp' => $params->md,
          'brand_emp' => $params->detail_brand,
          'supplier' => $params->nama_supplier,
          'no_handphone' => $params->no_handphone,
          'no_kk' => $params->no_kk,
          'no_ktp' => $params->no_ktp,
          'jenis_kelamin' => $params->jenis_kelamin,
          'status' => $params->status,
          'user_updated' => Auth::user()->username,
          'date_updated' => now(),
      ];

      $data_mutasi = $this->masterEmployeeRepository->get_mutasi_tbl();
      $kode_toko = $data_mutasi[0]->kode_toko;

      $updateData = [
          'tanggal_masuk' => \Carbon\Carbon::createFromFormat('d-m-Y', $params->tanggal_masuk)->format('Y-m-d'),
          'kode_toko' => $params->homebase,
          'nama_toko' => $params->homebase_terminal_id,
          'md_emp' => $params->md,
          'brand_emp' => $params->detail_brand,
          'supplier' => $params->nama_supplier,
          'no_kk' => $params->no_kk,
          'no_ktp' => $params->no_ktp,
          'user_updated' => Auth::user()->username,
          'date_updated' => now(),
      ];

      if ($imagePath) {
          $dataArray['image_employee'] = $imagePath;
      }

      $this->masterEmployeeRepository->editDataEmp($id_employee, $dataArray);

      $this->masterEmployeeRepository->editDataMutasi($id_employee, $kode_toko, $updateData);

      return response()->json([
          'success' => true,
          'message' => 'Data berhasil diperbaharui'
      ]);
    } catch (\Exception $e) {
      return response()->json([
          'success' => false,
          'message' => 'Gagal memperbarui data: ' . $e->getMessage()
      ], 500);
    }
  }

  public function terminateData($params)
  {
    try {
      $dataArray = [
          'tanggal_selesai' => \Carbon\Carbon::createFromFormat('d-m-Y', $params->tanggal_keluar)->format('Y-m-d'),
          'keterangan' => $params->note,
          'status_aktif' => '1',
          'user_terminate' => 'SYSTEM',
          'date_terminate' => now(),
      ];

      $this->masterEmployeeRepository->terminateData($params->id_employee, $dataArray);

      return response()->json([
          'success' => true,
          'message' => 'Data berhasil diterminate'
      ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal melakukan terminate data: ' . $e->getMessage()
        ], 500);
    }
  }

  public function get_search_data($params)
  {
    try {
      $arrParams = array(
        'emp_usr_id' => 'SYSTEM'
      );
      $data_user = $this->masterEmployeeRepository->validate_user($arrParams);
      $params['store_code'] = array_column($data_user, 'store_code');
      
      $result = $this->masterEmployeeRepository->get_search_data($params);
      return $result;
    } catch (\Exception $e) {
      return response()->json([
        "status" => false,
        "message" => "Gagal mendapatkan data: " . $e->getMessage()
      ], 500);
    }
  }
  public function validate_user($params) {
    return $this->masterEmployeeRepository->validate_user($params);
  }
  public function getRehire($params)
  {
    try {
      $result = $this->masterEmployeeRepository->getRehire($params);
      return $result;
    } catch (\Exception $e) {
      return response()->json([
        "status" => false,
        "message" => "Gagal mendapatkan data: " . $e->getMessage()
      ], 500);
    }
  }

  public function tambahRehire($params)
  {
    try {
      $category = $params->category;
      $data = $this->masterEmployeeRepository->get_category($category);

      if($category === 'SPG') {
          $id_employee = $data->id_employee == '' ? '9000000' + 1 : $data->id_employee + 1;
      } else {
          $id_employee = $data->id_employee == '' ? '8000000' + 1 : $data->id_employee + 1;
      }

      $insertData = [
          'user_create' => Auth::user()->username ?? 'SYSTEM',
          'date_create' => now(),
          'status_aktif' => '0',
          'nama' => $params->name,
          'alamat' => $params->address,
          'tanggal_lahir' => Carbon::createFromFormat('d-m-Y', $params->birthday)->format('Y-m-d'),
          'kode_toko' => $params->store,
          'no_handphone' => $params->noHandphone,
          'tanggal_masuk' => Carbon::createFromFormat('d-m-Y', $params->joinDate)->format('Y-m-d'),
          'no_kk' => $params->kk,
          'no_ktp' => $params->ktp,
          'jenis_kelamin' => $params->gender,
          'status' => $params->status,
          'md_emp' => $params->md,
          'brand_emp' => $params->detail_brand,
          'supplier' => $params->nama_supplier,
          'id_employee' => $id_employee,
          'kategori_karyawan' => $params->category
      ];

      $query = $this->masterEmployeeRepository->addRehire($insertData);

      return response()->json([
          "success" =>true,
          "data" => $query
      ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menambah data: ' . $e->getMessage()
        ], 500);
    }
  }
}
?>