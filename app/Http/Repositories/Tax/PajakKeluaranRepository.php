<?php
namespace App\Http\Repositories\Tax;
use Auth;
use DB;
use Carbon\Carbon;

class PajakKeluaranRepository{
  protected $connRis;

  public function __construct()
  {
    $this->connRis = DB::connection('mysql');
  }

  public function getPajakKeluaran($params) {
    $customerId = $params->customer_id;

    $supplier = $this->connRis
      ->table("ardueinv as a")
      ->leftJoin("supplier as s", 'a.customer_code', '=', 's.supplier_code')
      ->leftJoin("schdinvd as sc", 'a.invoice_no', '=', 'sc.invoice_no')
      ->leftJoin("k_promosih as kp", 'a.invoice_no', '=', 'kp.invoice_no')
      ->leftJoin("distcust as d", function ($join) {
        $join->on('kp.distcustnum', '=', 'd.distcustnum')
          ->on('kp.supplier', '=', 'd.customer_code');
      })
      ->where('d.customer_code', $customerId)
      ->select([
          'a.customer_code',
          'a.outlet_code',
          's.pkp_nonpkp',
          'd.name_tax as supplier_name',
          's.supplier_code'
      ])
      ->first();

    if ($supplier) {
      return response()->json(['supplier_name' => $supplier->supplier_name]);
    } else {
      return response()->json([
        'supplier_name' => 'Supplier tidak ditemukan',
        'debug' => 'Data tidak ditemukan di kedua schema'
      ], 404);
    }
  }

  public function getTax($params)
  {
    $start_date = $params->start_date;
    $end_date = $params->end_date;
    $customer_id = $params->customer_id;
    $outlet_code = $params->outlet_code;
    $tr_code = $params->tr_code;
    $invoice_no = $params->invoice_no;
    $operating_unit = $params->operating_unit_list; 
    $schema = ($operating_unit == 95) ? 'fashion2016' : 'test';

    $query = $this->connRis->table("$schema.arpjko as a")
      ->select(
        'a.*',
        DB::raw("TO_CHAR(a.date_create, 'DD-MM-YYYY HH24:MI:SS') AS date_create"),
        DB::raw("TO_CHAR(a.date_modified, 'DD-MM-YYYY HH24:MI:SS') AS date_modified")
      )
      ->whereBetween('a.invoice_date', [
        DB::raw("TO_DATE('$start_date', 'YYYY-MM-DD')"),
        DB::raw("TO_DATE('$end_date', 'YYYY-MM-DD')")
      ]);

    if ($invoice_no) {
      $query->where('a.invoice_no', $invoice_no);
    }

    if ($customer_id) {
      $query->where('a.customer_id', $customer_id);
    }

    if ($tr_code) {
      $query->where('a.tr_code', $tr_code);
    }

    if ($outlet_code) {
      $query->where('a.outlet_code', $outlet_code);
    }

    if ($tr_code == 'DOUT' || $outlet_code == 'RDC1' || $customer_id == 'RB21') {
      $query->where('a.tr_code', 'DOUT');
    } elseif ($tr_code == 'DOUT' || $outlet_code == 'RDC1' || $customer_id == 'RB30') {
      $query->where('a.tr_code', 'DOUT');
    } elseif ($tr_code == 'LFEE') {
      $query->where('a.tr_code', 'LFEE');
    }

    return $query->distinct()->get();
  }

  public function savePajakKeluaran($params) {
    $outlet_code = $params->outlet_code;
    $start_date = $params->start_date;
    $end_date = $params->end_date;
    $invoice_no = $params->invoice_no;
    $customer_id = $params->customer_id;
    $tr_code = $params->tr_code;
    $operating_unit = $params->operating_unit_list; 

    if (!$start_date || !$end_date) {
      return response()->json(["message" => "Start date dan end date harus diisi"], 400);
    }

    $query = $this->connRis
      ->table("ardueinv as a")
      ->leftJoin("supplier as sp", 'a.customer_code', '=', 'sp.supplier_code')
      ->leftJoin("arinvdt as ar1", 'a.invoice_no', '=', 'ar1.invoice_no')
      ->leftJoin("agreemst as g", 'ar1.agreement_no', '=', 'g.agreement_no')
      ->leftJoin("listfeem as ar2", 'a.invoice_no', '=', 'ar2.transaksi_no')
      ->leftJoin("m_gcm as mg", function($join) {
        $join->on('ar2.trx_code', '=', 'mg.gcm_id')
          ->where('mg.condition', 'PPH23');
      })
      ->leftJoin("k_promosih as ar3", function ($join) {
        $join->on('a.invoice_no', '=', 'ar3.invoice_no')
          ->whereNotIn('a.trx_code', ['ARGD', 'LFEE']);
      })
      ->leftJoin("schdinvd as sc", 'a.invoice_no', '=', 'sc.invoice_no')
      ->leftJoin("distcust as d", function ($join) {
        $join->on(DB::raw(
          "CASE WHEN a.trx_code = 'ARGD' THEN g.customer_id
            WHEN a.trx_code = 'LFEE' THEN ar2.supplier_code
            ELSE ar3.supplier
          END"), '=', 'd.customer_code')
          ->on(DB::raw(
          "CASE WHEN a.trx_code = 'ARGD' THEN g.no_of_invoice
            WHEN a.trx_code = 'LFEE' THEN ar2.distcust_no
            ELSE ar3.distcustnum
          END"), '=', 'd.distcustnum');
        })
      ->where('a.outlet_code', $outlet_code)
      ->whereBetween('a.invoice_date', [
        DB::raw("TO_DATE('$start_date', 'YYYY-MM-DD')"),
        DB::raw("TO_DATE('$end_date', 'YYYY-MM-DD')")
      ])
      ->select(
        'a.company_code',
        'a.customer_code',
        'a.invoice_no',
        'a.invoice_date',
        'a.outlet_code',
        DB::raw("a.amount_curr / 1.11 as dpp"),
        DB::raw("a.amount_curr - (a.amount_curr / 1.11) as ppn"),
        'mg.gcm_num as pph23',
        'a.kwitansi_no',
        'a.trx_code',
        'a.peyment_type',
        'a.currency_code',
        'a.currency_rate',
        'a.periode',
        'sp.pkp_nonpkp',
        'sc.agreement_no',
        'd.name_tax',
        'd.address_tax',
        'd.city_tax',
        'd.postcode_tax',
        'd.npwp_tax'
      )
      ->distinct();

    $query2 = $this->connRis
      ->table("kubexphd as a")
      ->leftJoin("kubexpdt as b", 'a.no_kubikasi', '=', 'b.no_kubikasi')
      ->leftJoin("tttexpms as c", 'b.no_ttt', '=', 'c.no_ttt')
      ->leftJoin("tttexpdt as d", 'c.no_ttt', '=', 'd.no_ttt')
      ->leftJoin("store as h", 'c.toko_tujuan', '=', 'h.store_code')
      ->where('c.store_code', $outlet_code)
      ->where('c.invoice_no', $invoice_no)
      ->whereBetween('c.tgl_kirim', [
        DB::raw("TO_DATE('$start_date', 'YYYY-MM-DD')"),
        DB::raw("TO_DATE('$end_date', 'YYYY-MM-DD')")
      ])
      ->select([
        'c.store_code',
        'h.npwp',
        'a.no_kubikasi',
        'a.no_mobil',
        'c.tgl_kirim',
        'c.toko_tujuan',
        'c.alamat_tujuan',
        'h.city',
        'h.post_code',
        'c.invoice_no',
        'c.status',
        'c.total_hj as DPP'
      ])
      ->distinct();

    if ($invoice_no) {
      $query->where('a.invoice_no', $invoice_no);
      $query2->where('c.invoice_no', $invoice_no);
    }
    if ($customer_id) {
      $query->where('a.customer_code', $customer_id);
      $query2->where('c.toko_tujuan', $customer_id);
    }
    if ($tr_code) {
      $query->where('a.trx_code', $tr_code);
    }

    $dataFromJoin = $query->get();
    $dataFromJoin2 = $query2->get();

    if ($dataFromJoin->isEmpty() && $dataFromJoin2->isEmpty()) {
      return response()->json(["message" => "Data tidak ditemukan."], 404);
    }

    $insertedData = [];
    if($tr_code == 'DOUT' || $outlet_code == 'RDC1'){
      foreach ($dataFromJoin2 as $data) {
        $invoiceDate = Carbon::parse($data->invoice_date)->format('Y-m-d');

        $existingData = $this->connRis
          ->table("arpjko")
          ->where('invoice_no', $data->invoice_no)
          ->where('invoice_date', DB::raw("TO_DATE('".date('Y-m-d', strtotime($data->tgl_kirim))."', 'YYYY-MM-DD')"))
          ->where('customer_id', $data->toko_tujuan)
          ->distinct()
          ->first();

        if ($existingData) {
          $insertedData[] = $existingData;
          continue;
        }      
            
        $kwitansi_no = str_replace('IVBT', 'KWBT', $data->invoice_no);
        $customerName = $data->toko_tujuan == 'RB21' ? 'RB21 - Ramayana Batam' : 'RB30 - Ramayana Batam';

        $dataImportHd = [
          "company_code" => '01',
          "outlet_code" => $data->store_code,
          "invoice_date" => DB::raw("TO_DATE('".date('Y-m-d', strtotime($data->tgl_kirim))."', 'YYYY-MM-DD')"),
          "invoice_no" => $data->invoice_no,
          "customer_id" => $data->toko_tujuan,
          "tr_code" => 'DOUT',
          "name" => $customerName,
          "address" => $data->alamat_tujuan,
          "city_nm" => $data->city,
          "postcode" => $data->post_code,
          "npwp" => $data->npwp ?? '-',  
          "status_ap" => $data->status,
          "kwitansi_no" => $kwitansi_no,
          "agreement_no" => $data->no_kubikasi,
          "dpp" => $data->dpp,
          "ppn" => (int)round($data->dpp * 11/100),
          'type_date' => '1',
          'pph23' => '0',
          'after_tax' => (int)round($data->dpp + ($data->dpp * 11/100)),
          'curr_code' => 'IDR',
          'kurs_rate' => '1',
          'remark' => $data->no_mobil,
          'pph23_auto' => '0',
          'npwp_potong' => $data->npwp ?? '-',
          'user_create' => Auth::user()->username,
          'date_create' =>DB::raw("CURRENT_DATE"),
          'date_modified' =>DB::raw("CURRENT_DATE")
        ];

        $this->connRis->table("arpjko")->insert($dataImportHd);

        $newData = $this->connRis
          ->table("arpjko")
          ->where('invoice_no', $data->invoice_no)
          ->where('invoice_date', DB::raw("TO_DATE('".date('Y-m-d', strtotime($data->tgl_kirim))."', 'YYYY-MM-DD')"))
          ->where('customer_id', $data->toko_tujuan)
          ->distinct()
          ->first();

        if ($newData) {
          $insertedData[] = $newData;
        }
      }
    } else if($tr_code == 'LFEE') {
      foreach ($dataFromJoin as $data) {
        $invoiceDate = Carbon::parse($data->invoice_date)->format('Y-m-d');

        $existingData = $this->connRis
          ->table("arpjko")
          ->where('invoice_no', $data->invoice_no)
          ->where('invoice_date', DB::raw("TO_DATE('".date('Y-m-d', strtotime($data->invoice_date))."', 'YYYY-MM-DD')"))
          ->where('customer_id', $data->customer_code)
          ->where('tr_code', $data->trx_code)
          ->distinct()
          ->first();

        if ($existingData) {
          $insertedData[] = $existingData;
          continue;
        }  

        $dataImportHd = [
          "company_code" => $data->company_code,
          "outlet_code" => $data->outlet_code,
          "invoice_date" => DB::raw("TO_DATE('".date('Y-m-d', strtotime($data->invoice_date))."', 'YYYY-MM-DD')"),
          "invoice_no" => $data->invoice_no,
          "customer_id" => $data->customer_code,
          "tr_code" => $data->trx_code,
          "name" => $data->name_tax,
          "address" => $data->address_tax,
          "city_nm" => $data->city_tax,
          "postcode" => $data->postcode_tax,
          "npwp" => $data->npwp_tax ?? '-',
          "status_ap" => $data->pkp_nonpkp,
          "kwitansi_no" => $data->kwitansi_no,
          "agreement_no" => $data->kwitansi_no ?? '-',
          "dpp" => is_numeric($data->dpp) ? (int)round($data->dpp) : 0,
          "ppn" => is_numeric($data->ppn) ? (int)round($data->ppn) : 0,
          'type_date' => $data->peyment_type,
          'pph23' => '0',
          'after_tax' => (int)round($data->dpp + $data->ppn),
          'curr_code' => $data->currency_code,
          'kurs_rate' => $data->currency_rate,
          'remark' => $data->periode,
          'pph23_auto' => '0',
          'npwp_potong' => $data->npwp_tax ?? '-',
          'user_create' => Auth::user()->username,
          'date_create' =>DB::raw("CURRENT_DATE"),
          'date_modified' =>DB::raw("CURRENT_DATE")
        ];

        $this->connRis->table("arpjko")->insert($dataImportHd);

        $newData = $this->connRis
          ->table("arpjko")
          ->where('invoice_no', $data->invoice_no)
          ->where('invoice_date', DB::raw("TO_DATE('".date('Y-m-d', strtotime($data->invoice_date))."', 'YYYY-MM-DD')"))
          ->where('customer_id', $data->customer_code)
          ->where('tr_code', $data->trx_code)
          ->distinct()
          ->first();

        if ($newData) {
          $insertedData[] = $newData;
        }
      }
    } else{
      foreach ($dataFromJoin as $data) {
        $invoiceDate = Carbon::parse($data->invoice_date)->format('Y-m-d');
        
        $existingData = $this->connRis
          ->table("arpjko")
          ->where('invoice_no', $data->invoice_no)
          ->where('invoice_date', DB::raw("TO_DATE('".date('Y-m-d', strtotime($data->invoice_date))."', 'YYYY-MM-DD')"))
          ->where('customer_id', $data->customer_code)
          ->where('tr_code', $data->trx_code)
          ->distinct()
          ->first();

        if ($existingData) {
          $insertedData[] = $existingData;
          continue;
        }  

        $dataImportHd = [
          "company_code" => $data->company_code,
          "outlet_code" => $data->outlet_code,
          "invoice_date" => DB::raw("TO_DATE('".date('Y-m-d', strtotime($data->invoice_date))."', 'YYYY-MM-DD')"),
          "invoice_no" => $data->invoice_no,
          "customer_id" => $data->customer_code,
          "tr_code" => $data->trx_code,
          "name" => $data->name_tax,
          "address" => $data->address_tax,
          "city_nm" => $data->city_tax,
          "postcode" => $data->postcode_tax,
          "npwp" => $data->npwp_tax ?? '-',
          "status_ap" => $data->pkp_nonpkp,
          "kwitansi_no" => $data->kwitansi_no,
          "agreement_no" => $data->agreement_no ?? '-',
          "dpp" => is_numeric($data->dpp) ? (int)round($data->dpp) : 0,
          "ppn" => is_numeric($data->ppn) ? (int)round($data->ppn) : 0,
          'type_date' => $data->peyment_type,
          'pph23' => '0',
          'after_tax' => (int)round($data->dpp + $data->ppn),
          'curr_code' => $data->currency_code,
          'kurs_rate' => $data->currency_rate,
          'remark' => $data->periode,
          'pph23_auto' => '0',
          'npwp_potong' => $data->npwp_tax ?? '-',
          'user_create' => Auth::user()->username,
          'date_create' =>DB::raw("CURRENT_DATE"),
          'date_modified' =>DB::raw("CURRENT_DATE")
        ];

        $this->connRis->table("arpjko")->insert($dataImportHd);

        $newData = $this->connRis
          ->table("arpjko")
          ->where('invoice_no', $data->invoice_no)
          ->where('invoice_date', DB::raw("TO_DATE('".date('Y-m-d', strtotime($data->invoice_date))."', 'YYYY-MM-DD')"))
          ->where('customer_id', $data->customer_code)
          ->where('tr_code', $data->trx_code)
          ->distinct()
          ->first();

        if ($newData) {
          $insertedData[] = $newData;
        }
      }
    }

    $getData = $this->getTax($params);

    return response()->json([
      "message" => "Data berhasil disimpan",
      "data" => $insertedData,
      "getData" => $getData
    ], 200);
  }
}
?>