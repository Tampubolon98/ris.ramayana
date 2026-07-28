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
}

?>