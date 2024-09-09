<?php

namespace App\Http\Controllers\API;

use App\Models\ZakatInfaq;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class ZakatInfaqController extends Controller
{
    public function fetch(Request $request)
    {
        $limit = $request->input('limit', 10);

        $zakatInfaqList = ZakatInfaq::orderByDesc('id')->paginate($limit);

        return ResponseFormatter::success(
            $zakatInfaqList,
            'Data daftar zakat dan infaq berhasil diambil'
        );
    }
}
