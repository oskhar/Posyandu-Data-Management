<?php

namespace App\Http\Controllers;

use App\Models\BeritaModel;
use App\Models\EdukasiModel;
use App\Models\GambarModel;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatistikController extends Controller
{
    public function dashboard(): JsonResponse
    {
        // $dataPerMonth = EdukasiModel::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
        //     ->groupBy('month')
        //     ->get();

        // $result = [];

        // for ($i = 1; $i <= 12; $i++) {
        //     $result[$i] = 0;
        // }

        // foreach ($dataPerMonth as $data) {
        //     $result[$data->month] = $data->count;
        // }


        $lastWeek = Carbon::now()->subWeek();

        $dataLastWeek = EdukasiModel::where('created_at', '>=', $lastWeek)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get();

        $edukasi = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $lastWeek->clone()->addDays($i)->toDateString();
            $edukasi[$date] = 0;
        }

        foreach ($dataLastWeek as $data) {
            $edukasi[$data->date] = $data->count;
        }

        $dataLastWeek = BeritaModel::where('created_at', '>=', $lastWeek)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get();

        $berita = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $lastWeek->clone()->addDays($i)->toDateString();
            $berita[$date] = 0;
        }

        foreach ($dataLastWeek as $data) {
            $berita[$data->date] = $data->count;
        }

        $dataLastWeek = GambarModel::where('created_at', '>=', $lastWeek)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get();

        $gambar = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $lastWeek->clone()->addDays($i)->toDateString();
            $gambar[$date] = 0;
        }

        foreach ($dataLastWeek as $data) {
            $gambar[$data->date] = $data->count;
        }
        return response()->json([
            'berita' => $berita,
            'edukasi' => $edukasi,
            'gambar' => $gambar,
        ])->setStatusCode(200);
    }
}
