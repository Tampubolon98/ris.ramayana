<?php

namespace App\Http\Controllers\Tax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PajakMasukanController extends Controller {

  public function indexTaxBahan() {
    return view('tax.indexTaxBahan');
  }

}

?>