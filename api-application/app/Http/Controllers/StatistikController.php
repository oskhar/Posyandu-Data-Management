<?php

namespace App\Http\Controllers;

use App\Models\BeritaModel;
use App\Models\EdukasiModel;
use App\Models\GambarModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatistikController extends Controller
{
    public function dashboard(): JsonResponse
    {
        $lastWeek = Carbon::now()->subWeek();

        $berita = $this->getDataLastWeek(BeritaModel::class, $lastWeek);
        $edukasi = $this->getDataLastWeek(EdukasiModel::class, $lastWeek);
        $gambar = $this->getDataLastWeek(GambarModel::class, $lastWeek);

        return response()->json([
            'berita' => $berita,
            'edukasi' => $edukasi,
            'gambar' => $gambar,
        ])->setStatusCode(200);
    }

    private function getDataLastWeek($model, $lastWeek)
    {
        $dataThisWeek = $model::where('created_at', '>=', Carbon::now()->startOfWeek())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get();

        $dataLastWeek = $model::where('created_at', '>=', $lastWeek->startOfWeek())
            ->where('created_at', '<', $lastWeek->endOfWeek())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get();

        $result = [
            'jumlah_hari_ini' => $this->getDataCountByDate($dataThisWeek, Carbon::now()->toDateString()),
            'persentase_perubahan_minggu_lalu' => $this->calculatePercentageChange($dataThisWeek, $dataLastWeek),
            'jumlah_minggu_ini' => $dataThisWeek->sum('count'),
            'bandingkan_minggu_lalu' => $this->compareThisWeekToLastWeek($dataThisWeek, $dataLastWeek),
            'statistik' => [],
        ];

        for ($i = 1; $i <= 7; $i++) {
            $date = $lastWeek->clone()->addDays($i)->toDateString();
            $result['statistik'][$date] = $this->getDataCountByDate($dataThisWeek, $date);
        }

        return $result;
    }

    private function getDataCountByDate($data, $date)
    {
        $item = $data->where('date', $date)->first();
        return $item ? $item->count : 0;
    }

    private function calculatePercentageChange($dataThisWeek, $dataLastWeek)
    {
        $countThisWeek = $dataThisWeek->sum('count');
        $countLastWeek = $dataLastWeek->sum('count');

        if ($countThisWeek == 0 && $countLastWeek == 0) {
            return 0;
        }

        $percentageChange = (($countThisWeek) / ($countLastWeek + $countThisWeek)) * 100;
        return $percentageChange;
    }

    private function compareThisWeekToLastWeek($dataThisWeek, $dataLastWeek)
    {
        $countThisWeek = $dataThisWeek->sum('count');
        $countLastWeek = $dataLastWeek->sum('count');

        if ($countThisWeek < $countLastWeek) {
            $diff = $countLastWeek - $countThisWeek;
            return "{$diff} lebih sedikit dari minggu lalu";
        } elseif ($countThisWeek > $countLastWeek) {
            $diff = $countThisWeek - $countLastWeek;
            return "{$diff} lebih banyak dari minggu lalu";
        } else {
            return "Jumlah sama dengan minggu lalu";
        }
    }
}
