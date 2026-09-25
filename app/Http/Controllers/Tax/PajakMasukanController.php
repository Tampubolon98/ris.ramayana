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
    $generate_status = 'NEW';
    $generate_params = [];
    $data = [];

    return view('tax.indexTaxBahan', compact('arrParams', 'generate_status', 'generate_params', 'data'));
  }

  public function searchTaxBahan(Request $params) {
    $arrParams = [
      'startDate' => date('d-m-Y', strtotime($params->startDate)),
      'endDate' => date('d-m-Y', strtotime($params->endDate))
    ];

    $generate_status = $this->pajakMasukanService->generateStatus($arrParams);

    $generate_params = $generate_status == 'NEW' ? [] : $this->pajakMasukanService->getSummaryBahan($arrParams);

    $data = $this->pajakMasukanService->getDataBahan($arrParams);

    return view('tax.indexTaxBahan', compact('arrParams', 'generate_status', 'generate_params', 'data'));
  }

  public function indexTaxNonap() {
    $arrParams = ['startDate' => date("d-m-Y"), 'endDate' => date("d-m-Y")];
    $generatedStatusNonap = 'NEW';
    $generatedParams = [];
    $arrData = [];

    return view('tax.indexTaxNonap', compact('arrParams', 'generatedStatusNonap', 'generatedParams', 'arrData'));
  }

  public function searchTaxNonap(Request $params) {
    $arrParams = [
      'startDate' => date('d-m-Y', strtotime($params->startDate)),
      'endDate' => date('d-m-Y', strtotime($params->endDate))
    ];

    $generatedStatusNonap = $this->pajakMasukanService->generateStatusNonap($arrParams);

    $generatedParams = $generatedStatusNonap == 'NEW' ? [] : $this->pajakMasukanService->getSummaryNonap($arrParams);

    $arrData = $this->pajakMasukanService->getDataNonap($arrParams);

    return view('tax.indexTaxNonap', compact('arrParams', 'generatedStatusNonap', 'generatedParams', 'arrData'));
  }

}

?>