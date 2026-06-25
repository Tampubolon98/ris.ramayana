<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterEmployeeController extends Controller {

  public function indexEmployee() {
    return view('employees.indexMasterEmployee');
  }
}

?>