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
    return $this->connRis->table('master_employee_spg')
          ->where('id_employee', $id_employee)
          ->update($dataArray);
  }

  public function editDataMutasi($id_employee, $kode_toko, $updateData)
  {
    return $this->connRis->table('mutasi_emp as a')
                  ->where('a.id_employee', $id_employee)
                  ->where('a.kode_toko', $kode_toko)
                  ->update($updateData);
  }

  public function terminateData($id_employee, $dataArray)
  {
    return $this->connRis->table('master_employee_spg')
    ->where('id_employee', $id_employee)
    ->update($dataArray);
  }

  public function validate_user($params)
  {
    $sql = "SELECT " .
			"m_approval_emp.*, " .
			"departement.department_name, " .
			"master_store.ms_location_code, " .
			"master_store.ms_type " .
			"FROM m_approval_emp " .
			"LEFT JOIN ntd.departement ON departement.department_code = m_approval_emp.emp_department_id " .
			"LEFT JOIN ntd.master_store ON master_store.ms_code = m_approval_emp.store_code";
		$where = "";

    if (isset($params['emp_department_id'])) {
			if (!empty($where)) $where = $where . " AND ";
			$where = $where . " emp_department_id = '" . $params['emp_department_id'] . "' ";
		}

    if (isset($params['emp_usr_id'])) {
			if (!empty($where)) $where = $where . " AND ";
			$where = $where . " emp_usr_id = '" . $params['emp_usr_id'] . "' ";
		}

    if (isset($params['store_code'])) {
			if (!empty($where)) $where = $where . " AND ";
			$where = $where . "m_approval_emp.store_code = '" . $params['store_code'] . "' ";
		}

    if (!empty($where)) $sql = $sql . ' WHERE ' . $where;
    $sql .= " ORDER BY m_approval_emp.emp_date_create DESC";
		$data = $this->connRis->select($sql);
		return $data;
  }

  public function get_search_data($params)
  {
    $kode_toko = isset($params['kode_toko']) ? $params['kode_toko'] : null;
    $kategori = isset($params['kategori_karyawan']) ? $params['kategori_karyawan'] : null;
    $storeCodes = isset($params['store_code']) ? $params['store_code'] : [];

    $query = $this->connRis->table('master_employee_spg as a')
                            ->leftJoin('master_brand_emp as b', 'a.supplier', '=', 'b.nama_supplier')
                            ->select('a.*', 'b.*')
                            ->whereIn('a.kategori_karyawan', ['SPG', 'PKL'])
                            ->where('a.status_aktif', '0')
                            ->orderBy('a.id_employee', 'desc')
                            ->distinct();

    if($kategori && $kategori !== 'ALL') {
        $query->where('a.kategori_karyawan', $kategori);
    }

    if($kode_toko) {
        $query->where('a.kode_toko', $kode_toko);
    } else {
        if(!empty($storeCodes) && !in_array('RHO', (array) $storeCodes)) {
            $query->whereIn('a.kode_toko', $storeCodes);
        }
    }

    $employees = $query->get();

    $toko = $this->connRis->table('p_c_x_homebase_tbl as a')
            ->select([
                    DB::raw("substr(a.homebase,5) as homebase"), 
                    DB::raw("substr(a.homebase,1,4) as homebase_terminal_id")
                    ])
            ->distinct()
            ->get()
            ->keyBy('homebase_terminal_id');

    $mutasi = $this->connRis->table('mutasi_emp as a')
            ->select('a.kode_toko as store', 'a.tanggal_masuk as join_date', 'a.id_employee', 'a.nama_toko as store_name', 'a.tanggal_keluar as out_date')
            ->get()
            ->keyBy('id_employee');

    foreach($employees as $data) {
        $data->homebase = isset($toko[$data->kode_toko]) 
            ? $toko[$data->kode_toko]->homebase 
            : null;

        $data->store = isset($mutasi[$data->id_employee]) 
            ? $mutasi[$data->id_employee]->store
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
    }

    return $employees;
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

  public function getRehire($params)
  {
    $sql = $this->connRis->table('master_employee_spg as a')
            ->select('a.*')
            ->where('no_ktp', $params->no_ktp)
            ->distinct();

    return $sql->get();
  }

  public function get_category($category) {
    $data = $this->connRis->table('master_employee_spg')
                  ->where('kategori_karyawan', $category)
                  ->orderBy('id_employee', 'desc')
                  ->first();
    return $data;
  }

  public function addRehire($insertData) {
    $query = $this->connRis->table('master_employee_spg')
                  ->insert($insertData);
    return $query;
  }

  public function get_list_terminate()
  {
    $employees = $this->connRis->table('master_employee_spg as a')
                ->select('a.*')
                ->where('status_aktif', '1')
                ->orderBy('a.id_employee', 'desc')
                ->distinct()
                ->get();

    $toko = $this->connRis->table('p_c_x_homebase_tbl as a')
            ->select([
                    DB::raw("substr(a.homebase,5) as homebase"), 
                    DB::raw("substr(a.homebase,1,4) as homebase_terminal_id")
                    ])
            ->distinct()
            ->get()
            ->keyBy('homebase_terminal_id');

    // Gabungkan data
    foreach($employees as $data) {
        $data->homebase = isset($toko[$data->kode_toko]) 
            ? $toko[$data->kode_toko]->homebase 
            : null;
    }

    return $employees;
  }

  public function downloadPDF($params)
  {
    $kode_toko = $params['kode_toko'];
    $kategori = $params['kategori_karyawan'];

    $query = $this->connRis->table('master_employee_spg as a')
                ->select('a.*')
                ->whereIn('a.kategori_karyawan', ['SPG', 'PKL'])
                ->orderBy('a.id_employee', 'desc');

    // Jika kategori bukan ALL, filter berdasarkan kategori
    if ($kategori !== 'ALL') {
        $query->where('a.kategori_karyawan', $kategori);
    }

    if ($kode_toko !== 'ALL') {
        $query->where('a.kode_toko', $kode_toko);
    }

    return $query->get();
  }

  public function downloadXLS($params)
  {
    $kode_toko = $params['kode_toko'];
    $kategori = $params['kategori_karyawan'];

    $query = $this->connRis->table('master_employee_spg as a')
                ->select('a.*')
                ->whereIn('a.kategori_karyawan', ['SPG', 'PKL'])
                ->orderBy('a.id_employee', 'desc');

    // Jika kategori bukan ALL, filter berdasarkan kategori
    if ($kategori !== 'ALL') {
        $query->where('a.kategori_karyawan', $kategori);
    }

    if ($kode_toko !== 'ALL') {
        $query->where('a.kode_toko', $kode_toko);
    }

    return $query->get();
  }

  public function downloadPDFCV($params)
  {
    $id_employee = $params['id_employee'];

    $query = $this->connRis->table('master_employee_spg as a')
                ->select('a.*')
                ->where('a.id_employee', $id_employee)
                ->whereIn('a.kategori_karyawan', ['SPG', 'PKL'])
                ->orderBy('a.id_employee', 'desc');

    return $query->get();
  }

  public function getBrand() {
    $query = $this->connRis->table('master_brand_emp as a')
        ->select('a.*')
        ->orderBy('a.id_brand_emp', 'desc')
        ->distinct()
        ->get();

    return $query;
  }

  public function editDataBrand($id_brand, $dataArray) {
    return $this->connRis->table('master_brand_emp')
        ->where('id_brand_emp', $id_brand)
        ->update($dataArray);
  }
}

?>