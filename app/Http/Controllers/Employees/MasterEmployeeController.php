<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Employees\MasterEmployeeService;

class MasterEmployeeController extends Controller {
  private $masterEmployeeService;

  public function __construct(MasterEmployeeService $masterEmployeeService)
  {
    $this->masterEmployeeService = $masterEmployeeService;
  }
  public function indexEmployee() {
    $access_create = false;
    $arrParam = array(
        'emp_usr_id' => 'SYSTEM',
        'emp_department_id' => '725'
    );

    $data_user = $this->masterEmployeeService->validate_user($arrParam);
    if(count($data_user) > 0) {
        $access_create = true;
    }
    return view('employees.indexMasterEmployee', compact('access_create'));
  }
  public function downloadTemplate(Request $params) {
    return $this->masterEmployeeService->downloadTemplate($params);
  }
  public function newEmployee(Request $params){
    return $this->masterEmployeeService->addNewEmployee($params);
  }

  public function newUploadEmployee(Request $params) {
    return $this->masterEmployeeService->addNewUploadEmployee($params);
  }
  public function getToko(Request $params){
    $result = $this->masterEmployeeService->getTokoEmp($params);
    return $result;
  }
  public function getEmployees() {
    return $this->masterEmployeeService->getEmployees();
  }
  public function getSupplier(Request $params){
    return $this->masterEmployeeService->getSupplierEmp($params);
  }

  public function getHistoryData(Request $noKtp)
  {
    $params = [
        'no_ktp' => $noKtp
    ];
    
    $result = $this->masterEmployeeService->getHistoryData($params);
    return $result;
  }

  public function editData(Request $params)
  {
      $result = $this->masterEmployeeService->editData($params);
      return $result;
  }

  public function terminateData(Request $params)
  {
      $result = $this->masterEmployeeService->terminateData($params);
      return $result;
  }

  public function get_search_data(Request $params)
  {
      $result = $this->masterEmployeeService->get_search_data($params);
      return $result;
  }

  public function indexRehire() {
    return view('employees.indexRehireEmployee');
  }

  public function getRehire(Request $params)
  {
    $no_ktp = (object) [
        'no_ktp' => $params->no_ktp
    ];
    
    $data = $this->masterEmployeeService->getRehire($no_ktp);
    return response()->json($data);
  }

  public function tambahRehire(Request $params)
  {
    $result = $this->masterEmployeeService->tambahRehire($params);
    return $result;
  }

  public function indexTerminate() {
    return view('employees.indexTerminateEmployee');
  }

  public function get_list_terminate()
  {
      $result = $this->masterEmployeeService->get_list_terminate();
      return $result;
  }

  public function indexReportSPG() {
    return view('employees.indexReportEmployeeSPG');
  }

  public function downloadPDF(Request $params)
  {
    $result = $this->masterEmployeeService->downloadPDF($params);
    return $result;
  }

  public function downloadXLS(Request $params)
  {
    $result = $this->masterEmployeeService->downloadXLS($params);
    return $result;
  }

  public function indexBrand() {
    return view('employees.indexMasterBrand');
  }

  public function getData()
  {
    $result = $this->masterEmployeeService->getBrand();
    return $result;
  }

  public function tambahDataBrand(Request $params){
    $result = $this->masterEmployeeService->tambahDataBrand($params);
    return $result;
  }

  public function editDataBrand(Request $params)
  {
    return $this->masterEmployeeService->editDataBrand($params);
  }

  public function getDataBrand(){
    $result = $this->masterEmployeeService->getDataBrand();
    return $result;
  }
  public function indexReportCV() {
    return view('employees.indexReportEmployeeCV');
  }

  public function downloadPDFCV(Request $params)
  {
    $result = $this->masterEmployeeService->downloadPDFCV($params);
    return $result;
  }

  public function indexMutasi() {
    return view('employees.indexMutasiEmployee');
  }
}

?>