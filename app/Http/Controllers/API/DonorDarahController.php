<?php

namespace App\Http\Controllers\API;

use App\Models\DonorDarah;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class DonorDarahController extends Controller
{
    public function fetch(Request $request)
    {
        $limit = $request->input('limit', 10);

        $donorDarahList = DonorDarah::orderByDesc('id')->paginate($limit);

        return ResponseFormatter::success(
            $donorDarahList,
            'Data daftar donor darah berhasil diambil'
        );
    }
}
