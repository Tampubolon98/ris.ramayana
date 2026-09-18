<?php
namespace App\Http\Services\Tax;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\UtilHelper;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Excel;
use Carbon\Carbon;
use App\Http\Repositories\Tax\PajakMasukanRepository as PajakMasukanRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PDF;

class PajakMasukanService{
  private $pajakMasukanRepository;
  public function __construct(PajakMasukanRepository $pajakMasukanRepository)
  {
    $this->pajakMasukanRepository = $pajakMasukanRepository;
  }

  public function generateStatus($params) {
    try {
      $arrParams = [
        'startDate' => date('d-m-Y', strtotime($params->startDate)),
        'endDate' => date('d-m-Y', strtotime($params->endDate))
      ];

      return $this->pajakMasukanRepository->generatedStatusBahan($arrParams);
    } catch (\Exception $e) {
      return response()->json([
        "status" => false,
        "message" => "Gagal mendapatkan data: " . $e->getMessage()
      ], 500);
    }
  }

  public function getSummaryBahan($params) {
    try {
      return $this->pajakMasukanRepository->getSummaryBahan(date('ym', strtotime($params->startDate)))[0];
    } catch (\Exception $e) {
      return response()->json([
        "status" => false,
        "message" => "Gagal mendapatkan data: " . $e->getMessage()
      ], 500);
    }
  }

  public function getDataBahan($params) {
    try {
      $arrParams = [
        'startDate' => date('d-m-Y', strtotime($params->startDate)),
        'endDate' => date('d-m-Y', strtotime($params->endDate))
      ];

      return $this->pajakMasukanRepository->getDataBahan($arrParams);
    } catch (\Exception $e) {
      return response()->json([
        "status" => false,
        "message" => "Gagal mendapatkan data: " . $e->getMessage()
      ], 500);
    }
  }
}
?>