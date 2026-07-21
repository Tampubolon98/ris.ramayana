<?php

namespace App\Http\Controllers\Nontrade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TTDNonTradeController extends Controller {

  public function indexTTDNontrade() {
    return view('nontrade.indexTTDNontrade');
  }
}

?>