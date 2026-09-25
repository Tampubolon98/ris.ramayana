<?php
namespace App\Http\Repositories\Tax;

use Auth;
use DB;
use Carbon\Carbon;

class PajakMasukanRepository{
  protected $connRis;

  public function __construct()
  {
    $this->connRis = DB::connection('mysql');
  }

  private function extractMonthYear($date)
  {
    $time = strtotime($date);
    return [
      'month' => (int) date('m', $time),
      'year' => (int) date('Y', $time)
    ];
  }

  public function generatedStatusBahan($params) {
    $startDate = is_array($params) ? $params['startDate'] : $params;
    $dateInfo = $this->extractMonthYear($startDate);

    $result = $this->connRis
      ->table('taxentry as a')
      ->leftJoin('supplier as b', 'a.supplier_code', '=', 'b.supplier_code')
      ->select(
        'a.kode', 'a.pay_date', 'a.supplier_code', 'b.supplier_name',
        'a.faktur_rmy', 'a.dpp', 'a.ppn', 'a.no_seri', 'a.tax_date',
        'a.npwp', 'a.release', 'a.user_modified', 'a.date_modified'
      )
      ->whereRaw('EXTRACT(MONTH FROM a.pay_date) = ?', [$dateInfo['month']])
      ->whereRaw('EXTRACT(YEAR FROM a.pay_date) = ?', [$dateInfo['year']])
      ->whereIn('a.kode', ['B'])
      ->get();

    return $result;
  }

  public function getSummaryBahan($params) {
    $startDate = is_array($params) ? ($params['startDate'] ?? reset($params)) : $params;
    $dateInfo = $this->extractMonthYear($startDate);

    $result = $this->connRis
      ->table('taxentry as a')
      ->leftJoin('supplier as b', 'a.supplier_code', '=', 'b.supplier_code')
      ->select(
        'a.kode', 'a.pay_date', 'a.supplier_code', 'b.supplier_name',
        'a.faktur_rmy', 'a.dpp', 'a.ppn', 'a.no_seri', 'a.tax_date',
        'a.npwp', 'a.release', 'a.user_modified', 'a.date_modified'
      )
      ->whereRaw('EXTRACT(MONTH FROM a.pay_date) = ?', [$dateInfo['month']])
      ->whereRaw('EXTRACT(YEAR FROM a.pay_date) = ?', [$dateInfo['year']])
      ->whereIn('a.kode', ['B', 'N'])
      ->get();

    return $result;
  }

  public function getDataBahan($params)
  {
    $startDate = is_array($params) ? $params['startDate'] : $params;
    $dateInfo = $this->extractMonthYear($startDate);
    
    $result = $this->connRis
      ->table('taxentry as a')
      ->leftJoin('supplier as b', 'a.supplier_code', '=', 'b.supplier_code')
      ->select(
        'a.kode', 'a.pay_date', 'a.supplier_code', 'b.supplier_name', 'a.tgl_faktur',
        'a.faktur_rmy', 'a.dpp', 'a.ppn', 'a.no_seri', 'a.tax_date',
        'a.npwp', 'a.release', 'a.status_ap', 'a.user_modified', 'a.date_modified', 'a.user_create', 'a.date_create'
      )
      ->whereRaw('EXTRACT(MONTH FROM a.pay_date) = ?', [$dateInfo['month']])
      ->whereRaw('EXTRACT(YEAR FROM a.pay_date) = ?', [$dateInfo['year']])
      ->whereIn('a.kode', ['B'])
      ->orderBy('a.supplier_code', 'asc')
      ->get();

    return $result;
  }

  public function generateStatusNonap($params) {
    $startDate = is_array($params) ? $params['startDate'] : $params;
    $dateInfo = $this->extractMonthYear($startDate);

    $result = $this->connRis
      ->table('taxentry as a')
      ->leftJoin('supplier as b', 'a.supplier_code', '=', 'b.supplier_code')
      ->select(
        'a.kode', 'a.pay_date', 'a.supplier_code', 'b.supplier_name',
        'a.faktur_rmy', 'a.dpp', 'a.ppn', 'a.no_seri', 'a.tax_date',
        'a.npwp', 'a.release', 'a.user_modified', 'a.date_modified'
      )
      ->whereRaw('EXTRACT(MONTH FROM a.pay_date) = ?', [$dateInfo['month']])
      ->whereRaw('EXTRACT(YEAR FROM a.pay_date) = ?', [$dateInfo['year']])
      ->whereIn('a.kode', ['N'])
      ->get();

    return $result;
  }

  public function getSummaryNonap($params) {
    $startDate = is_array($params) ? ($params['startDate'] ?? reset($params)) : $params;
    $dateInfo = $this->extractMonthYear($startDate);

    $result = $this->connRis
      ->table('taxentry as a')
      ->leftJoin('supplier as b', 'a.supplier_code', '=', 'b.supplier_code')
      ->select(
        'a.kode', 'a.pay_date', 'a.supplier_code', 'b.supplier_name',
        'a.faktur_rmy', 'a.dpp', 'a.ppn', 'a.no_seri', 'a.tax_date',
        'a.npwp', 'a.release', 'a.user_modified', 'a.date_modified'
      )
      ->whereRaw('EXTRACT(MONTH FROM a.pay_date) = ?', [$dateInfo['month']])
      ->whereRaw('EXTRACT(YEAR FROM a.pay_date) = ?', [$dateInfo['year']])
      ->whereIn('a.kode', ['B', 'N'])
      ->get();

    return $result;
  }

  public function getDataNonap($params) {
    $startDate = is_array($params) ? $params['startDate'] : $params;
    $dateInfo = $this->extractMonthYear($startDate);
    
    $result = $this->connRis
      ->table('taxentry as a')
      ->leftJoin('supplier as b', 'a.supplier_code', '=', 'b.supplier_code')
      ->select(
        'a.kode', 'a.pay_date', 'a.supplier_code', 'b.supplier_name', 'a.tgl_faktur',
        'a.faktur_rmy', 'a.dpp', 'a.ppn', 'a.no_seri', 'a.tax_date',
        'a.npwp', 'a.release', 'a.status_ap', 'a.user_modified', 'a.date_modified', 'a.user_create', 'a.date_create'
      )
      ->whereRaw('EXTRACT(MONTH FROM a.pay_date) = ?', [$dateInfo['month']])
      ->whereRaw('EXTRACT(YEAR FROM a.pay_date) = ?', [$dateInfo['year']])
      ->whereIn('a.kode', ['N'])
      ->orderBy('a.date_create', 'desc')
      ->get();

    return $result;
  }
}
?>