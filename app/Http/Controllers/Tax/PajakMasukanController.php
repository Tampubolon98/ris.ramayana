<?php

namespace App\Http\Controllers\Tax;

use App\Http\Controllers\Controller;
use App\Http\Services\Tax\PajakMasukanService as PajakMasukanService;
use Illuminate\Http\Request;


class PajakMasukanController extends Controller {
  private $pajakMasukanService;

  public function __construct(PajakMasukanService $pajakMasukanService)
  {
    $this->pajakMasukanService = $pajakMasukanService;
  }

  public function indexTaxBahan() {
    $arrParams = ['startDate' => date("d-m-Y"), 'endDate' => date("d-m-Y")];
    $generate_status = [];
    $generate_params = [];
    $data = [];

    return view('tax.indexTaxBahan', compact('arrParams', 'generate_status', 'generate_params', 'data'));
  }

  public function searchTaxBahan(Request $params) {
    $arrParams = [
      'startDate' => date('d-m-Y', strtotime($params->startDate)),
      'endDate' => date('d-m-Y', strtotime($params->endDate))
    ];

    $generate_status = $this->pajakMasukanService->generateStatus($params);

    $generate_params = $generate_status == 'NEW' ? [] : $this->pajakMasukanService->getSummaryBahan($params);

    $data = $this->pajakMasukanService->getDataBahan($params);

    return view('tax.indexTaxBahan', compact('arrParams', 'generate_status', 'generate_params', 'data'));
  }

  public function indexTaxNonap() {
    return view('tax.indexTaxNonap');
  }

}

?>