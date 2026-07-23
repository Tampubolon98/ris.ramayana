<?php
namespace App\Http\Services\Employees;
use Auth;
use Validator;
use App\Http\Repositories\Employees\MasterEmployeeRepository;

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
}
?>