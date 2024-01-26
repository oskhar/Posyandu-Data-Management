<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DB;

class WilayahController extends Controller
{
    //
    public function provinces(Request $request): JsonResponse
    {
        $hasil = DB::table('provinces')
            ->select('id', 'name')
            ->get();
        return response()->json($hasil)->setStatusCode(200);
    }
    public function regencies(Request $request): JsonResponse
    {
        $hasil = DB::table('regencies')
            ->select('id', 'name')
            ->where('province_id', $request->province_id)
            ->get();
        return response()->json($hasil)->setStatusCode(200);
    }
    public function districts(Request $request): JsonResponse
    {
        $hasil = DB::table('districts')
            ->select('id', 'name')
            ->where('regency_id', $request->regency_id)
            ->get();
        return response()->json($hasil)->setStatusCode(200);
    }
    public function villages(Request $request): JsonResponse
    {
        $hasil = DB::table('villages')
            ->select('id', 'name')
            ->where('district_id', $request->district_id)
            ->get();
        return response()->json($hasil)->setStatusCode(200);
    }
}
