<?php

namespace App\Helpers;

use Carbon\Carbon;
use \Cache;
use Auth;
use Storage;
use App\Models\PajakModel;
use App\Models\FaqDashboardModel;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use GuzzleHttp\Client;


class UtilHelper
{


   public static function bytesToHuman($params)
   {
       $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

       for ($i = 0; $params > 1024; $i++) {
           $params /= 1024;
       }

       return round($params, 2) . ' ' . $units[$i];
   }

   public static function convertToIdr($params)
   {
     $hasilIdr = "Rp ".number_format($params,0,',','.');
     return $hasilIdr;
   }

   public static function convertToIdrAll($params)
   {
     $hasilIdr = "Rp ".number_format($params,2,',','.');
     return $hasilIdr;
   }

   function numerik($nomor) {
		return (int)$nomor;
	 }

   public static function Rupiah($angka,$decimal=0){
	   $hasil = number_format($angka,$decimal,',','.');
	   return $hasil;
	 }

   public static function redisGet($keys=''){
     $value = Cache::get($keys);
     return $value;
   }



   public static function convertToIdr2($params)
   {
   $hasilIdr = number_format($params,0,',','.');
   return $hasilIdr;
   }

   public static function convertToQty($params)
   {
   $hasilIdr = number_format($params,0);
   return $hasilIdr;
   }

   public static function cogsCalculate($QCS, $CCS, $QTRX, $PPTRX)
   {

   $calculateQty = $QCS + $QTRX;
   if ($calculateQty <= 0 || $QTRX <= 0) {
     $resultCogs = $CCS;
   } else {
     $resultCogs = (($QCS * $CCS) + ($QTRX * $PPTRX)) / ($QCS + $QTRX);
   }
   // dd($resultCogs);
   return $resultCogs;
   }

   public static function stockValueCalculate($QCS, $CCS, $QTRX, $PPTRX)
   {
   //QCS = QTY current stock
   //CCS = COGS current stock
   //QTRX = QTY transaksi
   //PPTRX = PP transaksi
   $resultStockValue = ($QCS * $CCS) + ($QTRX * $PPTRX);
   return $resultStockValue;
   }

   public static function MasaPajak()
  {
    $toDay = date('Y-m-d');
    $masaPajak=null;
    $masterMasaPajak = PajakModel::MasterMasaPajak();
    for ($x=0; $x < count($masterMasaPajak); $x++) {
      if(($toDay >= $masterMasaPajak[$x]->start_date_masa) && ($toDay<=$masterMasaPajak[$x]->end_date_masa)){
        $masaPajak = $masterMasaPajak[$x]->masa_pajak;
      }
      // echo '('.$toDay.'>='.$masterMasaPajak[$x]->start_date_masa.') && ('.$toDay.'<='.$masterMasaPajak[$x]->end_date_masa.')<br>';
    }

    return $masaPajak;
  }

  public static function validationDPP($receive)
  {
  $data = PajakModel::DataStgByReceive($receive);
  $newData = 0;
  if(count($data)!=0){
    for ($i=0; $i < count($data) ; $i++) {
    if($data[$i]->dpp >=0 && $data[$i]->ppn >=0){
      $newData = 1;
    }
    }
  }
  return $newData;
  }

  public static function convertchrascii($text) {
    return str_replace(
    // return str_replace(
       ["128", "129", "130", "131", "132", "133", "134", "135", "136", "137", "138", "139", "140", "141", "142", "143", "144", "145", "146", "147", "148", "149", "150", "151", "152", "153", "154", "155", "156", "157", "158", "159", "160", "161", "162", "163", "164", "165", "166", "167", "168", "169", "170", "171", "172", "173", "174", "175", "176", "177", "178", "179", "180", "181", "182", "183", "184", "185", "186", "187", "188", "189", "190", "191", "192", "193", "194", "195", "196", "197",  "198", "199", "200", "201", "202", "203", "204", "205", "206", "207", "208", "209", "210", "211", "212", "213", "214", "215", "216", "217", "218", "219", "220", "221", "222", "223", "224", "225", "226", "227", "228", "229", "230", "231", "232", "233", "234", "235", "236", "237", "238", "239", "240", "241", "242",
        "243", "244", "245", "246", "247", "248", "249", "250", "251", "252", "253", "254", "255"],
        ["Ç","ü","é","â","ä","à","å","ç","ê","ë","è","ï","î","ì","Ä","Å","É","æ","Æ","ô","ö","ò","û","ù","ÿ",
        "Ö","Ü","¢","£","¥","₧","ƒ","á","í","ó","ú","ñ","Ñ","ª","º","¿","⌐","¬","½","¼","¡","«","»","░","▒",
        "▓","│","┤","╡","╢","╖","╕","╣","║","╗","╝","╜","╛","┐","└","┴","┬","├","─","┼","╞","╟","╚","╔","╩",
        "╦","╠","═","╬","╧","╨","╤","╥","╙","╘","╒","╓","╫","╪","┘","┌","█","▄","▌","▐","▀","α","ß","Γ","π",
        "Σ","σ","µ","τ","Φ","Θ","Ω","δ","∞","φ","ε","∩","≡","±","≥","≤","⌠","⌡","÷","≈","°","∙","·","√","ⁿ",
        "²","■"," " ],
        $text);

    //if(strlen($passnya>1)){
      //  return iconv("UTF-8","Windows-1252", $passnya);
    //}
     //   return $passnya;

  }


  public static function tulis_log($path,$txtnya,$datas){
    $poslog = new Logger('userkasir');
    $poslogset = new StreamHandler(storage_path($path), Logger::INFO);
    $poslogset->setFormatter(new LineFormatter("# %message% %context% \n"));
    $poslog->pushHandler($poslogset);
    if($datas==""){
      $datas=[];
    }
    $poslog->info($txtnya, $datas);
  }

  public static function txt_log($path,$txt){
     $file_log = fopen(storage_path($path),"a");
     fwrite($file_log,  $txt."\r\n");
     fclose($file_log);
  }

  public static function getRandomStr()
  {
      $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < 12; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }

      $timeNow = Carbon::now()->format('dmYHis');

      return $randomString.'_'.$timeNow;
  }

  public static function getCodeOrDesc($params, $status) {
      $code = explode("-", $params);
      if ($status == 0) {
        return $code[0];
      } else {
        return $code[1];
      }
  }

  public static function spelling($number)
  {
      $number = abs($number);
      $spell  = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", 'sembilan', "sepuluh", "sebelas");
      $__temp = "";
      if ($number < 12) {
          $__temp = " " .$spell[$number];
      } else if ($number < 20) {
          $__temp = UtilHelper::spelling($number - 10). " belas";
      } else if ($number < 100) {
          $__temp = UtilHelper::spelling($number / 10). " puluh" .UtilHelper::spelling($number % 10);
      } else if ($number < 200) {
          $__temp = " seratus" .UtilHelper::spelling($number - 100);
      } else if ($number < 1000) {
          $__temp = UtilHelper::spelling($number / 100). " ratus" .UtilHelper::spelling($number % 100);
      } else if ($number < 2000) {
          $__temp = "seribu" .UtilHelper::spelling($number - 1000);
      } else if ($number < 1000000) {
          $__temp = UtilHelper::spelling($number / 1000). " ribu" .UtilHelper::spelling($number % 1000);
      } else if ($number < 1000000000) {
          $__temp = UtilHelper::spelling($number / 1000000). " juta" .UtilHelper::spelling($number % 1000000);
      } else if ($number < 1000000000000) {
          $__temp = UtilHelper::spelling($number / 100000000). " milyar" .UtilHelper::spelling(fmod($number, 100000000));
      } else if ($number < 1000000000000000) {
          $__temp = UtilHelper::spelling($number / 100000000000). " trilyun" .UtilHelper::spelling(fmod($number, 100000000000));
      }
      return $__temp;
  }

  public static function spells($number) {
      if ($number < 0) {
          $response = "minus " .trim(ucwords(UtilHelper::spelling($number)));
      } else {
          $response = trim(ucwords(UtilHelper::spelling($number)));
      }
      return $response;
  }
  public static function convertMonthToChar($str)
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

  public static function convertNumericToAlphabet($n)
  {
    $r = '';
    for ($i = 1; $n >= 0 && $i < 10; $i++) {
      $r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . " " .$r;
      $n -= pow(26, $i);
    }

    $rExplode = explode(" ", trim($r));
    if(count($rExplode) == 2){
      $r = $rExplode[1].$rExplode[0];
    }else{
      $r = trim($r);
    }
    // dump($r);
    return $r;
  }

  public static function getDataFaq(){
    $getDataFaq = FaqDashboardModel::getDataFaq();
    // dd($getDataFaq);
     return $getDataFaq;
   }

   public static function MonasMobilePassword($path ,$id, $pass){
      $url = 'http://myactivity.ramayana.co.id'; //env('APP_MOBILE_URL');
      $port = '8765'; //env('APP_MOBILE_PORT');
      $endPoint = $url.':'.$port.'/portal/api/auth/'.$path;
      
      $keyBase64Encode = 'QG1vbmFz';
      $strEncode = base64_encode($pass);
      $keyEncode = base64_encode($keyBase64Encode);
      $passwordMobile = $strEncode.$keyEncode;

          if(strlen($id)>6){
            $id=substr($id,1);
          }

      $paramsApi=[
        //'roleId' => "5",
        'nik' => $id,
        'username' => $id,
        'password' => $passwordMobile
      ];

      $client = new Client([
        'headers' => [ 'Content-Type' => 'application/json' ]
      ]);
      
      $response = $client->post($endPoint, ['json' => $paramsApi]);

   }

   public static function GenJwt($secret) {
    $headers = array('alg'=>'HS256','typ'=>'JWT');
    $payload = array('user_id'=>'ris');

    $headers_encoded = UtilHelper::Base64urlEncode(json_encode($headers));
    
    $payload_encoded = UtilHelper::Base64urlEncode(json_encode($payload));
    
    $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
    $signature_encoded = UtilHelper::Base64urlEncode($signature);
    
    $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
    // $jwt =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6InRlc3RAbWFpbC5jb20iLCJsZXZlbCI6ImFwcGxpY2F0aW9uIn0.T0Qc8dKIljonzgEEXxjLAOvAGGyCftFFtj5XZdSkg_k';
        
    return $jwt;
  }

  public static function GenerateJWTCust($payload, $headers, $secret)
  {

    
    $headers_encoded = UtilHelper::Base64urlEncode(json_encode($headers));
    
    $payload_encoded = UtilHelper::Base64urlEncode(json_encode($payload));
    
    $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
    $signature_encoded = UtilHelper::Base64urlEncode($signature);
    
    $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
    // $jwt =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6InRlc3RAbWFpbC5jb20iLCJsZXZlbCI6ImFwcGxpY2F0aW9uIn0.T0Qc8dKIljonzgEEXxjLAOvAGGyCftFFtj5XZdSkg_k';
        
    return $jwt;
  }
  
  public static function Base64urlEncode($str) {
      return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
  }


   public static function ApiDocsB64($pdf,$idtype,$note,$description,$nmfile,$iddoc){
    $tokenz = UtilHelper::GenJwt('r4l5-G0-d0cS');

    $b64Doc = chunk_split(base64_encode(file_get_contents($pdf->output())));

    $url ="http://dev-api-digitaldocs.ramayana.co.id:8989/api/v1/upload-arsip-raw";
    $url  =    config('config_digital.url_arsip')."upload-arsip-raw";

    $ch = curl_init( $url );

    $payload = json_encode( array( "user_create"=> Auth::user()->username,
                "id_type" =>  $idtype,
                "note" => $note,
                "description" =>  $description,
                "name_file" => $nmfile,
                "file" =>  $b64Doc,
                "id_real_doc" => $iddoc,
            ) );


    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
 
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $tokenz ,'Content-Type:application/json'));
    
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    
    $result = curl_exec($ch);
    curl_close($ch);
    return  $result ;

   }

   public static function ApiDocsFile($path,$idtype,$note,$description,$nmfile,$tgldoc,$iddoc){

      $tokenz = UtilHelper::GenJwt('r4l5-G0-d0cS');

	    $url ="http://dev-api-digitaldocs.ramayana.co.id:8989/api/v1/upload-arsip";

     $url = config('config_digital.url_arsip')."upload-arsip";

	    $curl = curl_init();


        $cfile = curl_file_create($path,'application/pdf',$nmfile);


        $payload = array( "user_create"=>  Auth::user()->username,
                         "id_type" =>  $idtype,
                          "note" => $note,
                          "description" => $description,
                          "name_file" =>$nmfile,
                          "id_real_doc" => $iddoc,
                          "tanggal_doc" => $tgldoc,
                           "file"=>$cfile
                ) ;



	curl_setopt_array($curl, array(
          CURLOPT_URL =>  $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
         CURLOPT_POSTFIELDS => $payload,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$tokenz
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

   }

  static function integerToRoman($num) {
    $romanNumerals = [
        1000 => 'M',
        900 => 'CM',
        500 => 'D',
        400 => 'CD',
        100 => 'C',
        90 => 'XC',
        50 => 'L',
        40 => 'XL',
        10 => 'X',
        9 => 'IX',
        5 => 'V',
        4 => 'IV',
        1 => 'I'
    ];

    $result = '';

    foreach ($romanNumerals as $value => $numeral) {
        while ($num >= $value) {
            $result .= $numeral;
            $num -= $value;
        }
    }

    return $result;
  }

  private function penyebut($nilai)
  {
      $nilai = abs($nilai);
      $huruf = [
          '',
          'Satu',
          'Dua',
          'Tiga',
          'Empat',
          'Lima',
          'Enam',
          'Tujuh',
          'Delapan',
          'Sembilan',
          'Sepuluh',
          'Sebelas',
      ];
      $temp = '';
      if ($nilai < 12) {
          $temp = ' ' . $huruf[$nilai];
      } elseif ($nilai < 20) {
          $temp = $this->penyebut($nilai - 10) . ' Belas';
      } elseif ($nilai < 100) {
          $temp = $this->penyebut($nilai / 10) . ' Puluh' . $this->penyebut($nilai % 10);
      } elseif ($nilai < 200) {
          $temp = ' Seratus' . $this->penyebut($nilai - 100);
      } elseif ($nilai < 1000) {
          $temp = $this->penyebut($nilai / 100) . ' Ratus' . $this->penyebut($nilai % 100);
      } elseif ($nilai < 2000) {
          $temp = ' Seribu' . $this->penyebut($nilai - 1000);
      } elseif ($nilai < 1000000) {
          $temp = $this->penyebut($nilai / 1000) . ' Ribu' . $this->penyebut($nilai % 1000);
      } elseif ($nilai < 1000000000) {
          $temp = $this->penyebut($nilai / 1000000) . ' Juta' . $this->penyebut($nilai % 1000000);
      } elseif ($nilai < 1000000000000) {
          $temp = $this->penyebut($nilai / 1000000000) . ' Milyar' . $this->penyebut(fmod($nilai, 1000000000));
      } elseif ($nilai < 1000000000000000) {
          $temp = $this->penyebut($nilai / 1000000000000) . ' Trilyun' . $this->penyebut(fmod($nilai, 1000000000000));
      }
      return $temp;
  }

  public function terbilang($nilai)
  {
      if ($nilai < 0) {
          $hasil = 'Minus ' . trim($this->penyebut($nilai));
      } else {
          $hasil = trim($this->penyebut($nilai));
      }
      return $hasil;
  }

}
