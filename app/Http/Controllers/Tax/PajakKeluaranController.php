<?php

namespace App\Http\Controllers\Tax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Tax\PajakKeluaranService as PajakKeluaranService;

class PajakKeluaranController extends Controller {
  private $pajakKeluaranService;

  public function __construct(PajakKeluaranService $pajakKeluaranService)
  {
    $this->pajakKeluaranService = $pajakKeluaranService;
  }

  public function indexTaxOut() {
    return view('tax.indexTaxOut');
  }

  public function getPajakKeluaran(Request $params) {
    return $this->pajakKeluaranService->getPajakKeluaran($params);
  }

  public function savePajakKeluaran($params) {
    return $this->pajakKeluaranService->savePajakKeluaran($params);
  }

}

?>