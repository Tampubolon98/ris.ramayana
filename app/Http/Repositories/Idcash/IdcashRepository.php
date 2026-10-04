<?php
namespace App\Http\Repositories\Idcash;

use Auth;
use DB;
use DataTables;
use Carbon\Carbon;

class IdcashRepository{
  protected $connRis;

  public function __construct()
  {
    $this->connRis = DB::connection('mysql');
  }

  public function listTransaksiMember($params)
  {
    if(request()->ajax()) 
    {
      $status = $params->status;
      $start_date = $params->startDate;
      $end_date = $params->endDate;
      $whereTanggal = "";

      if (!empty($start_date)) {
          $whereTanggal = "WHERE a.tanggal >= '$start_date'";
      }

      if (!empty($end_date)) {
          $whereTanggal .= " AND a.tanggal <= '$end_date'";
      }

      $query = $this->connRis
        ->table('v_rcv_supp_cr881s as a')
        ->leftJoin(DB::raw("(
          SELECT 
            a.tanggal,
            a.toko,
            a.nokartu,
            a.nostruk, 
            a.nilai,
            b.tanggal AS tgl_petty_cash,
            ABS(b.nilai) AS petty_cash,
            a.nilai + b.nilai AS selisih
          FROM report.trx_saldo_karyawan_membercard a
          JOIN report.customer_membercard c1 ON a.nokartu = c1.nokartu AND c1.type_mc = 8
          LEFT JOIN report.trx_saldo_karyawan_membercard b ON a.nostruk = b.nostruk AND b.status = '7'
          LEFT JOIN report.customer_membercard c2 ON b.nokartu = c2.nokartu AND c2.type_mc = 8
          $whereTanggal
          AND a.status = '1'
        ) as b"), DB::raw('a.invoice_no::text'), '=', DB::raw('b.nostruk::text'))
        ->select([
          'a.store_code as toko',
          'a.po_no',
          'a.invoice_no',
          'a.rcv_no as no_rcv',
          'a.rcv_date as Tgl_rcv',
          'b.tanggal as tgl_struk',
          'b.tgl_petty_cash',
          'a.net_rcv as receiving',
          'b.nilai as struk',
          'b.petty_cash',
          DB::raw("
            CASE WHEN (a.net_rcv = b.nilai) AND ABS(b.nilai) > 1 THEN 'MATCH'
            WHEN ABS(a.net_rcv - b.nilai) < 10 AND ABS(b.nilai) > 1 THEN 'MATCH'
            WHEN tgl_petty_cash IS NULL THEN 'WAITING PAID'
            ELSE 'UNMATCH'
            END as status
          ")
        ]);

      if (isset($status)) {
        $query->whereRaw("
          CASE WHEN (a.net_rcv = b.nilai) AND ABS(b.nilai) > 1 THEN 'MATCH'
          WHEN ABS(a.net_rcv - b.nilai) < 10 AND ABS(b.nilai) > 1 THEN 'MATCH'
          WHEN tgl_petty_cash IS NULL THEN 'WAITING PAID'
          ELSE 'UNMATCH'
          END = ?
          ", [$status]);
      }

      $data = $query->get();
        
      return DataTables::of($data)->filter(function ($q) use ($params) 
      {
        if ($params->search['value'] !=null) 
        {
          $search = strtoupper($params->search['value']);
          $q->where('po_no', 'like', "%{$search}%")
            ->orWhere('receiving', 'like', "%{$search}%");
        } 
      })->make(true);
    }
  }
}

?>