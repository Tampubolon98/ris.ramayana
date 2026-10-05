<?php
namespace App\Http\Services\Idcash;
use Illuminate\Support\Facades\Log;
use App\Http\Repositories\Idcash\IdcashRepository as IdcashRepository;

class IdcashService{
  private $idcashRepository;

  public function __construct(IdcashRepository $idcashRepository)
  {
    $this->idcashRepository = $idcashRepository;
  }

  public function listTransaksiMember($params) {
    try {
      return $this->idcashRepository->listTransaksiMember($params);
    } catch (\Exception $e) {
      return response()->json([
        "status" => false,
        "message" => "Gagal mendapatkan data: " . $e->getMessage()
      ], 500);
    }
  }
}

?>