<?php
namespace App\Http\Repositories\Tax;
use Auth;
use DB;
use Carbon\Carbon;

class PajakKeluaranRepository{
  protected $connRis;

  public function __construct()
  {
    $this->connRis = DB::connection('mysql');
  }

  public function 
}
?>