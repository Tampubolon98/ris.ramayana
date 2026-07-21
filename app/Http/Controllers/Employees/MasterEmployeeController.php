<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterEmployeeController extends Controller {

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

  public function indexReportCV() {
    return view('employees.indexReportEmployeeCV');
  }

  public function indexMutasi() {
    return view('employees.indexMutasiEmployee');
  }
}

?>