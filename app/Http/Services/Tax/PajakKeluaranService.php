<?php
namespace App\Http\Services\Tax;
use Illuminate\Support\Facades\Log;
use App\Http\Repositories\Tax\PajakKeluaranRepository as PajakKeluaranRepository;

class PajakKeluaranService{
  private $pajakKeluaranRepository;

  public function __construct(PajakKeluaranRepository $pajakKeluaranRepository)
  {
    $this->pajakKeluaranRepository = $pajakKeluaranRepository;
  }

  public function getPajakKeluaran($params) {
    try {
      return $this->pajakKeluaranRepository->getPajakKeluaran($params);
    } catch (\Exception $e) {
      return response()->json([
        "status" => false,
        "message" => "Gagal mendapatkan data: " . $e->getMessage()
      ], 500);
    }
  }

  public function savePajakKeluaran($params) {
    try {
      return $this->pajakKeluaranRepository->savePajakKeluaran($params);
    } catch (\Exception $e) {
      return response()->json([
        "status" => false,
        "message" => "Gagal mendapatkan data: " . $e->getMessage()
      ], 500);
    }
  }
}


?>