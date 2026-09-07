<?php
namespace App\Http\Repositories\Employees;
use Auth;
use DB;
use Carbon\Carbon;

class MasterEmployeeRepository{
  protected $connRis;

  public function __construct()
  {
    $this->connRis = DB::connection('mysql');
  }

  public function tambahDataBrand($params){
    $query = $this->connRis->table('master_brand_emp')
              ->insert($params);

    return $query;
  }

  public function getDataBrand(){
    $query = $this->connRis->table('master_brand_emp as mbe')
              ->select('mbe.*')
              ->distinct()
              ->orderBy('mbe.id_brand_emp', 'desc')
              ->get();

    return $query;
  }

  public function getLastData($id_brand){
    $query = $this->connRis->table('master_brand_emp as mbe')
              ->where('mbe.id_brand_emp', 'like', $id_brand . '%')
              ->orderBy('mbe.id_brand_emp', 'desc')
              ->first();

    return $query;
  }

  public function getDataEmployees(){
    $query = $this->connRis->table('master_employee_spg as mes')
      ->select('mes.*')
      ->where('mes.status_aktif', '0')
      ->whereIn('mes.kategori_karyawan', ['SPG', 'PKL'])
      ->orderBy('mes.id_employee', 'desc')
      ->distinct();

    // if(!in_array('RHO', (array) $params['store_code'])){
    //   $query->whereIn('mes.kode_toko', (array) $params['store_code']);
    // }

    $employees = $query->get();

    $store = $this->connRis->table('p_c_x_homebase_tbl as pcx')
      ->select(DB::raw("substr(pcx.homebase, 5) as homebase"), DB::raw("substr(pcx.homebase, 1,4) as homebase_terminal_id"))
      ->distinct()
      ->get()
      ->keyBy('homebase_terminal_id');

    $mutasi = $this->connRis->table('mutasi_emp as mue')
      ->select('mue.kode_toko', 'mue.tanggal_masuk as join_date', 'mue.id_employee', 'mue.nama_toko as store_name', 'mue.tanggal_keluar as out_date', 'mue.date_create', 'mue.kategori_karyawan', 'mue.md_emp', 'mue.brand_emp', 'mue.supplier', 'mue.no_kk', 'mue.no_ktp')
      ->where('mue.tanggal_keluar', null)
      ->get()
      ->keyBy('id_employee');

    foreach($employees as $data){
      $data->homebase = isset($store[$data->kode_toko]) 
                ? $store[$data->kode_toko]->homebase 
                : null;

      $data->store = isset($mutasi[$data->id_employee]) 
          ? $mutasi[$data->id_employee]->kode_toko
          : null;

      $data->join_date = isset($mutasi[$data->id_employee]) 
          ? $mutasi[$data->id_employee]->join_date
          : null;

      $data->store_name = isset($mutasi[$data->id_employee]) 
          ? $mutasi[$data->id_employee]->store_name
          : null;

      $data->out_date = isset($mutasi[$data->id_employee]) 
          ? $mutasi[$data->id_employee]->out_date
          : null;

      $data->md = isset($mutasi[$data->id_employee]) 
          ? $mutasi[$data->id_employee]->md_emp
          : null;

      $data->brand = isset($mutasi[$data->id_employee]) 
          ? $mutasi[$data->id_employee]->brand_emp
          : null;

      $data->detail_brand = isset($mutasi[$data->id_employee]) 
          ? $mutasi[$data->id_employee]->supplier
          : null;

      $data->kk = isset($mutasi[$data->id_employee]) 
          ? $mutasi[$data->id_employee]->no_kk
          : null;

      $data->ktp = isset($mutasi[$data->id_employee]) 
          ? $mutasi[$data->id_employee]->no_ktp
          : null;
    }

    return $employees;
  }

  public function addNewEmployee($params){
    return $this->connRis->table('master_employee_spg')->insert($params);
  }

  public function detailData()
  {
    $query = $this->connRis->table('master_brand_emp as a')
                ->select('a.md', 'a.detail_brand', 'a.nama_supplier')
                ->distinct()
                ->get();

    return $query;
  }

  public function checkDuplicate($field, $value)
  {
    return $this->connRis->table('master_employee_spg')
            ->where($field, $value)
            ->exists();
  }

  public function idemployee($kategori)
  {
    return $this->connRis->table('master_employee_spg')
        ->where('kategori_karyawan', $kategori)
        ->orderByDesc('id_employee')
        ->first();
  }

  public function uploadData($params)
  {
    return $this->connRis->table('master_employee_spg')
            ->insert($params);
  }

  public function categoryEmployee($category){
    return $this->connRis->table('master_employee_spg')
            ->where('kategori_karyawan', $category)
            ->orderBy('id_employee', 'desc')
            ->first();
  }

  public function getHistoryData($params)
  {
    $query = $this->connRis->table('master_employee_spg as a')
            ->select('a.*')
            ->where('a.no_ktp', $params['no_ktp'])
            ->whereIn('a.kategori_karyawan', ['SPG', 'PKL'])
            ->orderBy('a.date_create', 'asc')
            ->get();

    $suppliers = $this->connRis->table('supplier as a')
            ->select('a.supplier_code', 'a.supplier_name')
            ->where('a.supplier_type', 2)
            ->get()
            ->keyBy('supplier_code');

    $mutasi = $this->connRis->table('mutasi_emp as a')
            ->select('a.*')
            ->where('a.no_ktp', $params['no_ktp'])
            ->orderBy('a.date_create', 'desc')
            ->get();

    // Gabungkan data
    foreach ($query as $employee) {
        $employee->supplier_name = $suppliers[$employee->supplier]->supplier_name ?? null;
    }

    $combine = $mutasi->merge($query);
    return $combine;
  }

  public function get_mutasi_tbl()
  {
    return $this->connRis->table('mutasi_emp as a') 
                    ->select('a.*')
                    ->orderBy('a.id_employee', 'desc')
                    ->get();
  }

  public function editDataEmp($id_employee, $dataArray)
  {
    $this->connRis->table('master_employee_spg')
          ->where('id_employee', $id_employee)
          ->update($dataArray);
  }

  public function editDataMutasi($id_employee, $kode_toko, $updateData)
  {
    $this->connRis->table('mutasi_emp as a')
                  ->where('a.id_employee', $id_employee)
                  ->where('a.kode_toko', $kode_toko)
                  ->update($updateData);
  }

  public function addNewMutasi($params){
    return $this->connRis->table('mutasi_emp')->insert($params);
  }

  public function getSupplierEmp($params){
    $searchTerm = $params->input('searchTerm');

    $query = $this->connRis->table('master_brand_emp as a')
                        ->select('a.md', 'a.detail_brand', 'a.nama_supplier')
                        ->where(function ($q) use ($searchTerm) {
                            $q->whereRaw('LOWER(a.md) LIKE ?', ['%' . strtolower($searchTerm) . '%'])
                            ->orWhereRaw('LOWER(a.detail_brand) LIKE ?', ['%' . strtolower($searchTerm) . '%'])
                            ->orWhereRaw('LOWER(a.nama_supplier) LIKE ?', ['%' . strtolower($searchTerm) . '%']);
                        })
                        ->orderBy('md', 'asc')
                        ->distinct();

    if ($params->has('limit')) {
        $query->limit($params->input('limit'));
    }
    return $query->get();
  }

  public function getTokoEmployee($params)
  {
    $searchTerm = $params->input('searchTerm');
    // $storeCodes = $params['store_code'];

    $query = $this->connRis->table('p_c_x_homebase_tbl as a')
                ->select([
                    DB::raw("substr(a.homebase,5) as homebase"), 
                    DB::raw("substr(a.homebase,1,4) as homebase_terminal_id")
                ])
                ->where(function ($q) use ($searchTerm) {
                    $q->whereRaw('LOWER(a.homebase) LIKE ?', ['%' . strtolower($searchTerm) . '%'])
                    ->orWhereRaw('UPPER(a.homebase) LIKE ?', ['%' . strtoupper($searchTerm) . '%']);
                })
                ->orderBy(DB::raw("substr(a.homebase,1,4)"), 'asc')
                ->distinct();

    if ($params->has('limit')) {
        $query->limit($params->input('limit')); 
    }

    // if(!in_array('RHO', (array) $storeCodes)) {
    //     $query->where(function($q) use ($storeCodes) {
    //         foreach($storeCodes as $code) {
    //             $q->orWhere('a.homebase', 'like', trim($code) . ' %');
    //         }
    //     });
    // }

    return $query->get();
  }
}

?>