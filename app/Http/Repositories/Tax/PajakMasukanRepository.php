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

  public function generatedStatusBahan($params) {
    $startDate = $params['startDate'];
    $endDate = $params['endDate'];
    $result = $this->connRis->table('taxentry')->select("
      SELECT a.kode,a.pay_date,a.supplier_code,b.supplier_name,
      a.faktur_rmy,a.dpp,a.ppn,a.no_seri,a.tax_date,
      a.npwp,a.release,a.user_modified,a.date_modified
      FROM taxentry a 
      INNER JOIN supplier b on a.supplier_code = b.supplier_code
      WHERE EXTRACT(MONTH FROM a.pay_date) = '$startDate' and 
      EXTRACT(year from a.pay_date) = '$endDate'
      AND a.KODE IN('B')
    ");

    return $result;
  }

  public function getSummaryBahan($params) {
    $startDate = $params['startDate'];
    $endDate = $params['endDate'];

    $result = $this->connRis->table('taxentry')->select("
      SELECT a.kode,a.pay_date,a.supplier_code,b.supplier_name,
      a.faktur_rmy,a.dpp,a.ppn,a.no_seri,a.tax_date,
      a.npwp,a.release,a.user_modified,a.date_modified
      FROM taxentry a 
      INNER JOIN supplier b on a.supplier_code = b.supplier_code
      WHERE EXTRACT(MONTH FROM a.pay_date) =$startDate and 
      EXTRACT(year from a.pay_date) = $endDate
      AND a.KODE IN('B','N')
    ");
    return $result;
  }

  public function getDataBahan($params)
  {
    // Mengambil start date dan end date
    $startDate = $params['startDate'];
    $endDate = $params['endDate'];

    // Ekstrak bulan dan tahun dari tanggal start
    $startMonth = date('m', strtotime($startDate));
    $startYear = date('Y', strtotime($startDate));
    
    // Query dengan menggunakan query builder Laravel
    $result = $this->connRis
      ->table('taxentry as a')
      ->join('supplier as b', 'a.supplier_code', '=', 'b.supplier_code')
      ->select(
          'a.kode', 'a.pay_date', 'a.supplier_code', 'b.supplier_name', 'a.tgl_faktur',
          'a.faktur_rmy', 'a.dpp', 'a.ppn', 'a.no_seri', 'a.tax_date',
          'a.npwp', 'a.release', 'a.status_ap', 'a.user_modified', 'a.date_modified', 'a.user_create', 'a.date_create'
      )
      ->whereRaw('EXTRACT(MONTH FROM a.pay_date) = ?', [$startMonth])
      ->whereRaw('EXTRACT(YEAR FROM a.pay_date) = ?', [$startYear])
      ->whereIn('a.kode', ['B'])
      ->orderBy('a.supplier_code', 'asc')
      ->get();

    return $result;
  }
}
?>