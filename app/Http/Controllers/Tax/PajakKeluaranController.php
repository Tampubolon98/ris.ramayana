<?php

namespace App\Http\Controllers\Tax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PajakKeluaranController extends Controller {

  public function indexTaxOut() {
    return view('tax.indexTaxOut');
  }

}

?>