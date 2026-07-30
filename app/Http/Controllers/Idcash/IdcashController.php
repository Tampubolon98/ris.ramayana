<?php

namespace App\Http\Controllers\Idcash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IdcashController extends Controller {

  public function indexListTransaksiMember() {
    return view('idcash.indexListTransaksiMember');
  }
}

?>