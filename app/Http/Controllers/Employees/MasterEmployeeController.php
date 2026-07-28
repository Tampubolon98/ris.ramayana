<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Employees\MasterEmployeeService;

class MasterEmployeeController extends Controller {
  private $masterEmployeeService;

  public function __construct(MasterEmployeeService $masterEmployeeService)
  {
    $this->masterEmployeeService = $masterEmployeeService
  }
  public function indexEmployee() {
    return view('employees.indexMasterEmployee');
  }

  public function indexRehire() {
    return view('employees.indexRehireEmployee');
  }

  public function indexTerminate() {
    return view('employees.indexTerminateEmployee');
  }

  public function indexReportSPG() {
    return view('employees.indexReportEmployeeSPG');
  }

  public function indexBrand() {
    return view('employees.indexMasterBrand');
  }

  public function tambahDataBrand(Request $params){
    $result = $this->masterEmployeeService->tambahDataBrand($params);
    return $result;
  }

  public function getDataBrand(){
    $result = $this->masterEmployeeService->getDataBrand();
    return $result;
  }

  public function indexReportCV() {
    return view('employees.indexReportEmployeeCV');
  }

  public function indexMutasi() {
    return view('employees.indexMutasiEmployee');
  }
}

?>