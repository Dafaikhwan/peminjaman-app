<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;

class RuanganApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Ruangan::all()
        ]);
    }
}