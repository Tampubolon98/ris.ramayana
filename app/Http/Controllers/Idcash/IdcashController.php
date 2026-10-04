<?php

namespace App\Http\Controllers\Idcash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Idcash\IdcashService as IdcashService;

class IdcashController extends Controller {
  private $idcashService;

  public function __construct(IdcashService $idcashService)
  {
    $this->idcashService = $idcashService;
  }

  public function indexListTransaksiMember() {
    return view('idcash.indexListTransaksiMember');
  }

  public function listTransaksiMember(Request $params) {
    return $this->idcashService->listTransaksiMember($params);
  }

  
}

?>