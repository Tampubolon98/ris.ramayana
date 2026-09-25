<?php
namespace App\Http\Services\Tax;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
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

  private function parseParams($params)
  {
    $startDate = is_array($params) ? ($params['startDate'] ?? date('d-m-Y')) : ($params->startDate ?? date('d-m-Y'));
    $endDate = is_array($params) ? ($params['endDate'] ?? date('d-m-Y')) : ($params->endDate ?? date('d-m-Y'));

    return [
      'startDate' => date('d-m-Y', strtotime($startDate)),
      'endDate' => date('d-m-Y', strtotime($endDate))
    ];
  }

  public function generateStatus($params) {
    try {
      $arrParams = $this->parseParams($params);
      $result = $this->pajakMasukanRepository->generatedStatusBahan($arrParams);
      $count = count($result);

      if ($count == 0) {
        return 'NEW';
      }

      $releaseCount = 0;
      foreach ($result as $row) {
        if (!empty($row->release) && $row->release >= 1) {
          $releaseCount++;
        }
      }

      return $releaseCount == $count ? 'GENERATED' : 'REVISION';
    } catch (\Exception $e) {
      Log::error("Error in generateStatus: " . $e->getMessage());
      return 'NEW';
    }
  }

  public function getSummaryBahan($params) {
    try {
      $arrParams = $this->parseParams($params);
      $result = $this->pajakMasukanRepository->getSummaryBahan($arrParams);

      if (!empty($result) && count($result) > 0) {
        $first = $result[0];
        $month = date('m', strtotime($first->pay_date));
        $first->pay_date_char = $this->convertMonthToChar($month);
        return $first;
      }

      return [];
    } catch (\Exception $e) {
      Log::error("Error in getSummaryBahan: " . $e->getMessage());
      return [];
    }
  }

  public function getDataBahan($params) {
    try {
      $arrParams = $this->parseParams($params);
      $list_data = $this->pajakMasukanRepository->getDataBahan($arrParams);
      $array = [];

      foreach ($list_data as $data) {
        $array[] = [
          'supplier' => $data->supplier_code ?? '',
          'supplier_name' => $data->supplier_name ?? '',
          'ms_pjk' => $data->pay_date ?? '',
          'rcv_date' => $data->tgl_faktur ?? '',
          'faktur' => $data->faktur_rmy ?? '',
          'tax_series' => $data->no_seri ?? '',
          'tax_date' => $data->tax_date ?? '',
          'dpp' => $data->dpp ?? 0,
          'ppn' => $data->ppn ?? 0,
          'checkbox' => $data->release ?? 0,
          'npwp' =>  $data->npwp ?? '',
          'kode' => $data->kode ?? 'B',
          'status_ap' => $data->status_ap ?? '',
          'user_create' => $data->user_create ?? '',
          'date_create' => $data->date_create ?? '',
          'user_modified' => $data->user_modified ?? '',
          'date_modified' => $data->date_modified ?? '',
        ];
      }

      return $array;
    } catch (\Exception $e) {
      Log::error("Error in getDataBahan: " . $e->getMessage());
      return [];
    }
  }

  public function generateStatusNonap($params) {
    try {
      $arrParams = $this->parseParams($params);
      $result = $this->pajakMasukanRepository->generateStatusNonap($arrParams);
      $count = count($result);

      if ($count == 0) {
        return 'NEW';
      }

      $releaseCount = 0;
      foreach ($result as $row) {
        if (!empty($row->release) && $row->release >= 1) {
          $releaseCount++;
        }
      }

      return $releaseCount == $count ? 'GENERATED' : 'REVISION';
    } catch (\Exception $e) {
      Log::error("Error in generateStatusNonap: " . $e->getMessage());
      return 'NEW';
    }
  }

  public function convertMonthToChar($str)
  {
    switch ($str) {
        case '01': $month = 'Januari'; break;
        case '02': $month = 'Februari'; break;
        case '03': $month = 'Maret'; break;
        case '04': $month = 'April'; break;
        case '05': $month = 'Mei'; break;
        case '06': $month = 'Juni'; break;
        case '07': $month = 'Juli'; break;
        case '08': $month = 'Agustus'; break;
        case '09': $month = 'September'; break;
        case '10': $month = 'Oktober'; break;
        case '11': $month = 'November'; break;
        case '12': $month = 'Desember'; break;
        default: $month = 'Bulan'; break;
    }
    return $month;
  }

  public function getSummaryNonap($params) {
    try {
      $arrParams = $this->parseParams($params);
      $result = $this->pajakMasukanRepository->getSummaryNonap($arrParams);

      if (!empty($result) && count($result) > 0) {
        $first = $result[0];
        $month = date('m', strtotime($first->pay_date));
        $first->pay_date_char = $this->convertMonthToChar($month);
        return $first;
      }

      return [];
    } catch (\Exception $e) {
      Log::error("Error in getSummaryNonap: " . $e->getMessage());
      return [];
    }
  }

  public function getDataNonap($params) {
    try {
      $arrParams = $this->parseParams($params);
      $list_data = $this->pajakMasukanRepository->getDataNonap($arrParams);
      $array = [];

      foreach ($list_data as $data) {
        $dppNilaiLain = round(($data->dpp ?? 0) * (11 / 12));

        $array[] = [
          'supplier' => $data->supplier_code ?? '',
          'supplier_name' => $data->supplier_name ?? '',
          'ms_pjk' => $data->pay_date ?? '',
          'rcv_date' => $data->tgl_faktur ?? '',
          'faktur' => $data->faktur_rmy ?? '',
          'tax_series' => $data->no_seri ?? '',
          'tax_date' => $data->tax_date ?? '',
          'dpp' => $data->dpp ?? 0,
          'dpp_nilai_lain' => $dppNilaiLain,
          'ppn' => $data->ppn ?? 0,
          'checkbox' => $data->release ?? 0,
          'npwp' =>  $data->npwp ?? '',
          'kode' => $data->kode ?? 'N',
          'status_ap' => $data->status_ap ?? '',
          'user_create' => $data->user_create ?? '',
          'date_create' => $data->date_create ?? '',
          'user_modified' => $data->user_modified ?? '',
          'date_modified' => $data->date_modified ?? '',
        ];
      }

      return $array;
    } catch (\Exception $e) {
      Log::error("Error in getDataNonap: " . $e->getMessage());
      return [];
    }
  }
}
?>