<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\HubungiKami;

class HubungiKamiController extends Controller
{
    public function fetch(Request $request)
    {
        $limit = $request->input('limit', 10);

        $hubungiKamiList = HubungiKami::orderByDesc('id')->paginate($limit);

        return ResponseFormatter::success(
            $hubungiKamiList,
            'Data daftar hubungi kami berhasil diambil'
        );
    }
}
