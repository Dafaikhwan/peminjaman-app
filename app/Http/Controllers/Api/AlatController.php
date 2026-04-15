<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    // ================= LIST ALAT =================
    public function index()
    {
        $data = Alat::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // ================= DETAIL ALAT =================
    public function show($id)
    {
        $alat = Alat::find($id);

        if (!$alat) {
            return response()->json([
                'success' => false,
                'message' => 'Alat tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $alat
        ]);
    }
}