<?php

namespace App\Exports;

use App\Models\BayiModel;
use App\Models\FormatAModel;
use App\Models\PenimbanganModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanBExport implements FromCollection, WithEvents, WithCustomStartCell, WithStyles
{
    protected $batasBulanStart = [0, 6, 12, 24];
    protected $batasBulanEnd = [5, 11, 23, 59];
    protected $tahun;
    protected $bulan;
    public function __construct($tahun = null, $bulan = null)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        for ($i = 0; $i < 4; $i++) {

            $query = BayiModel::whereRaw('(' . $this->tahun . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $this->bulan . ' - MONTH(bayi.tanggal_lahir) BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i]);

            $S[$i] = $query->count();
            $SP[$i] = $query->where('jenis_kelamin', 'P')
                ->count();
            $SL[$i] = $S[$i] - $SP[$i];

            $query = BayiModel::whereRaw('(' . $this->tahun . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $this->bulan . ' - MONTH(bayi.tanggal_lahir) BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i])
                ->where('memiliki_kms', '1');

            $K[$i] = $query->count();
            $KP[$i] = $query->where('jenis_kelamin', 'P')
                ->count();
            $KL[$i] = $K[$i] - $KP[$i];

            $query = PenimbanganModel::join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('penimbangan.tahun_penimbangan', $this->tahun)
                ->where('penimbangan.bulan_penimbangan', $this->bulan)
                ->whereRaw('SUBSTRING(penimbangan.ntob FROM 1 FOR 1) = "N"')
                ->whereRaw('standar_deviasi.umur_bulan BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i]);

            $N[$i] = $query->count();
            $NP[$i] = $query->where('id_berat_untuk_umur', 2)->count();
            $NL[$i] = $N[$i] - $NP[$i];

            $query = PenimbanganModel::join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('penimbangan.tahun_penimbangan', $this->tahun)
                ->where('penimbangan.bulan_penimbangan', $this->bulan)
                ->whereRaw('SUBSTRING(penimbangan.ntob FROM 1 FOR 1) = "T"')
                ->whereRaw('standar_deviasi.umur_bulan BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i]);

            $T[$i] = $query->count();
            $TP[$i] = $query->where('id_berat_untuk_umur', 2)->count();
            $TL[$i] = $T[$i] - $TP[$i];

            $query = PenimbanganModel::join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('penimbangan.tahun_penimbangan', $this->tahun)
                ->where('penimbangan.bulan_penimbangan', $this->bulan)
                ->whereRaw('SUBSTRING(penimbangan.ntob FROM 1 FOR 1) = "O"')
                ->whereRaw('standar_deviasi.umur_bulan BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i]);

            $O[$i] = $query->count();
            $OP[$i] = $query->where('id_berat_untuk_umur', 2)->count();
            $OL[$i] = $O[$i] - $OP[$i];

            $query = PenimbanganModel::join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('penimbangan.tahun_penimbangan', $this->tahun)
                ->where('penimbangan.bulan_penimbangan', $this->bulan)
                ->whereRaw('SUBSTRING(penimbangan.ntob FROM 1 FOR 1) = "B"')
                ->whereRaw('standar_deviasi.umur_bulan BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i]);

            $B[$i] = $query->count();
            $BP[$i] = $query->where('id_berat_untuk_umur', 2)->count();
            $BL[$i] = $B[$i] - $BP[$i];

            $D[$i] = $N[$i] + $T[$i] + $O[$i] + $B[$i];
            $DP[$i] = $NP[$i] + $TP[$i] + $OP[$i] + $BP[$i];
            $DL[$i] = $NL[$i] + $TL[$i] + $OL[$i] + $BL[$i];

            $ST[$i] = $S[$i] - $D[$i];
            $STP[$i] = $SP[$i] - $DP[$i];
            $STL[$i] = $SL[$i] - $DL[$i];

            $tahunLalu = ($this->bulan - 1 == 0) ? $this->tahun - 1 : $this->tahun;
            $bulanLalu = ($this->bulan - 1 == 0) ? 12 : $this->bulan - 1;

            $query = PenimbanganModel::join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('penimbangan.tahun_penimbangan', $tahunLalu)
                ->where('penimbangan.bulan_penimbangan', $bulanLalu)
                ->whereRaw('SUBSTRING(penimbangan.ntob FROM 1 FOR 1) = "T"')
                ->whereRaw('standar_deviasi.umur_bulan BETWEEN ' . ($this->batasBulanStart[$i] + 1) . ' AND ' . $this->batasBulanEnd[$i]);

            $TT[$i] = $query->count();
            $TTP[$i] = $query->where('id_berat_untuk_umur', 2)->count();
            $TTL[$i] = $TT[$i] - $TTP[$i];

            $DOB[$i] = $D[$i] - $O[$i] - $B[$i];
            $DOBP[$i] = $DP[$i] - $OP[$i] - $BP[$i];
            $DOBL[$i] = $DL[$i] - $OL[$i] - $BL[$i];

            $query = PenimbanganModel::join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('penimbangan.tahun_penimbangan', $this->tahun)
                ->where('penimbangan.bulan_penimbangan', $this->bulan)
                ->whereRaw('SUBSTRING(penimbangan.ntob FROM 1 FOR 3) = "BGM"')
                ->whereRaw('standar_deviasi.umur_bulan BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i]);

            $BGM[$i] = $query->count();
            $BGMP[$i] = $query->where('id_berat_untuk_umur', 2)->count();
            $BGML[$i] = $BGM[$i] - $BGMP[$i];

        }
        $result = collect();

        $result->push([
            "S",
            empty($SL[0]) ? '-' : $SL[0],
            empty($SP[0]) ? '-' : $SP[0],
            empty($S[0]) ? '-' : $S[0],
            empty($SL[1]) ? '-' : $SL[1],
            empty($SP[1]) ? '-' : $SP[1],
            empty($S[1]) ? '-' : $S[1],
            empty($SL[2]) ? '-' : $SL[2],
            empty($SP[2]) ? '-' : $SP[2],
            empty($S[2]) ? '-' : $S[2],
            empty($SL[3]) ? '-' : $SL[3],
            empty($SP[3]) ? '-' : $SP[3],
            empty($S[3]) ? '-' : $S[3],
        ]);
        $result->push([
            "K",
            empty($KL[0]) ? '-' : $KL[0],
            empty($KP[0]) ? '-' : $KP[0],
            empty($K[0]) ? '-' : $K[0],
            empty($KL[1]) ? '-' : $KL[1],
            empty($KP[1]) ? '-' : $KP[1],
            empty($K[1]) ? '-' : $K[1],
            empty($KL[2]) ? '-' : $KL[2],
            empty($KP[2]) ? '-' : $KP[2],
            empty($K[2]) ? '-' : $K[2],
            empty($KL[3]) ? '-' : $KL[3],
            empty($KP[3]) ? '-' : $KP[3],
            empty($K[3]) ? '-' : $K[3],
        ]);
        $result->push([
            "N",
            empty($NL[0]) ? '-' : $NL[0],
            empty($NP[0]) ? '-' : $NP[0],
            empty($N[0]) ? '-' : $N[0],
            empty($NL[1]) ? '-' : $NL[1],
            empty($NP[1]) ? '-' : $NP[1],
            empty($N[1]) ? '-' : $N[1],
            empty($NL[2]) ? '-' : $NL[2],
            empty($NP[2]) ? '-' : $NP[2],
            empty($N[2]) ? '-' : $N[2],
            empty($NL[3]) ? '-' : $NL[3],
            empty($NP[3]) ? '-' : $NP[3],
            empty($N[3]) ? '-' : $N[3],
        ]);
        $result->push([
            "T",
            empty($TL[0]) ? '-' : $TL[0],
            empty($TP[0]) ? '-' : $TP[0],
            empty($T[0]) ? '-' : $T[0],
            empty($TL[1]) ? '-' : $TL[1],
            empty($TP[1]) ? '-' : $TP[1],
            empty($T[1]) ? '-' : $T[1],
            empty($TL[2]) ? '-' : $TL[2],
            empty($TP[2]) ? '-' : $TP[2],
            empty($T[2]) ? '-' : $T[2],
            empty($TL[3]) ? '-' : $TL[3],
            empty($TP[3]) ? '-' : $TP[3],
            empty($T[3]) ? '-' : $T[3],
        ]);
        $result->push([
            "O",
            empty($OL[0]) ? '-' : $OL[0],
            empty($OP[0]) ? '-' : $OP[0],
            empty($O[0]) ? '-' : $O[0],
            empty($OL[1]) ? '-' : $OL[1],
            empty($OP[1]) ? '-' : $OP[1],
            empty($O[1]) ? '-' : $O[1],
            empty($OL[2]) ? '-' : $OL[2],
            empty($OP[2]) ? '-' : $OP[2],
            empty($O[2]) ? '-' : $O[2],
            empty($OL[3]) ? '-' : $OL[3],
            empty($OP[3]) ? '-' : $OP[3],
            empty($O[3]) ? '-' : $O[3],
        ]);
        $result->push([
            "B",
            empty($BL[0]) ? '-' : $BL[0],
            empty($BP[0]) ? '-' : $BP[0],
            empty($B[0]) ? '-' : $B[0],
            empty($BL[1]) ? '-' : $BL[1],
            empty($BP[1]) ? '-' : $BP[1],
            empty($B[1]) ? '-' : $B[1],
            empty($BL[2]) ? '-' : $BL[2],
            empty($BP[2]) ? '-' : $BP[2],
            empty($B[2]) ? '-' : $B[2],
            empty($BL[3]) ? '-' : $BL[3],
            empty($BP[3]) ? '-' : $BP[3],
            empty($B[3]) ? '-' : $B[3],
        ]);
        $result->push([
            "D",
            empty($DL[0]) ? '-' : $DL[0],
            empty($DP[0]) ? '-' : $DP[0],
            empty($D[0]) ? '-' : $D[0],
            empty($DL[1]) ? '-' : $DL[1],
            empty($DP[1]) ? '-' : $DP[1],
            empty($D[1]) ? '-' : $D[1],
            empty($DL[2]) ? '-' : $DL[2],
            empty($DP[2]) ? '-' : $DP[2],
            empty($D[2]) ? '-' : $D[2],
            empty($DL[3]) ? '-' : $DL[3],
            empty($DP[3]) ? '-' : $DP[3],
            empty($D[3]) ? '-' : $D[3],
        ]);
        $result->push([
            "-",
            empty($STL[0]) ? '-' : $STL[0],
            empty($STP[0]) ? '-' : $STP[0],
            empty($ST[0]) ? '-' : $ST[0],
            empty($STL[1]) ? '-' : $STL[1],
            empty($STP[1]) ? '-' : $STP[1],
            empty($ST[1]) ? '-' : $ST[1],
            empty($STL[2]) ? '-' : $STL[2],
            empty($STP[2]) ? '-' : $STP[2],
            empty($ST[2]) ? '-' : $ST[2],
            empty($STL[3]) ? '-' : $STL[3],
            empty($STP[3]) ? '-' : $STP[3],
            empty($ST[3]) ? '-' : $ST[3],
        ]);
        $result->push([
            "2T",
            empty($TTL[0]) ? '-' : $TTL[0],
            empty($TTP[0]) ? '-' : $TTP[0],
            empty($TT[0]) ? '-' : $TT[0],
            empty($TTL[1]) ? '-' : $TTL[1],
            empty($TTP[1]) ? '-' : $TTP[1],
            empty($TT[1]) ? '-' : $TT[1],
            empty($TTL[2]) ? '-' : $TTL[2],
            empty($TTP[2]) ? '-' : $TTP[2],
            empty($TT[2]) ? '-' : $TT[2],
            empty($TTL[3]) ? '-' : $TTL[3],
            empty($TTP[3]) ? '-' : $TTP[3],
            empty($TT[3]) ? '-' : $TT[3],
        ]);
        $result->push([
            "D-O-B",
            empty($DOBL[0]) ? '-' : $DOBL[0],
            empty($DOBP[0]) ? '-' : $DOBP[0],
            empty($DOB[0]) ? '-' : $DOB[0],
            empty($DOBL[1]) ? '-' : $DOBL[1],
            empty($DOBP[1]) ? '-' : $DOBP[1],
            empty($DOB[1]) ? '-' : $DOB[1],
            empty($DOBL[2]) ? '-' : $DOBL[2],
            empty($DOBP[2]) ? '-' : $DOBP[2],
            empty($DOB[2]) ? '-' : $DOB[2],
            empty($DOBL[3]) ? '-' : $DOBL[3],
            empty($DOBP[3]) ? '-' : $DOBP[3],
            empty($DOB[3]) ? '-' : $DOB[3],
        ]);
        $result->push([
            "BGM",
            empty($BGML[0]) ? '-' : $BGML[0],
            empty($BGMP[0]) ? '-' : $BGMP[0],
            empty($BGM[0]) ? '-' : $BGM[0],
            empty($BGML[1]) ? '-' : $BGML[1],
            empty($BGMP[1]) ? '-' : $BGMP[1],
            empty($BGM[1]) ? '-' : $BGM[1],
            empty($BGML[2]) ? '-' : $BGML[2],
            empty($BGMP[2]) ? '-' : $BGMP[2],
            empty($BGM[2]) ? '-' : $BGM[2],
            empty($BGML[3]) ? '-' : $BGML[3],
            empty($BGMP[3]) ? '-' : $BGMP[3],
            empty($BGM[3]) ? '-' : $BGM[3],
        ]);

        return $result;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Menggabungkan kolom A sampai C pada baris 1
                $event->sheet->getDelegate()->mergeCells('A1:M3');

                // Menambahkan judul ke tengah-tengah sel yang digabungkan
                $event->sheet->setCellValue('A1', 'Cetak laporan register bayi' . chr(10) . 'penimbangan bayi pada tahun ' . $this->tahun . ' bulan ke ' . $this->bulan);
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->mergeCells('B4:D4');
                $event->sheet->setCellValue('B4', '0 - 5 Bln');
                $event->sheet->setCellValue('B5', 'L');
                $event->sheet->setCellValue('C5', 'P');
                $event->sheet->setCellValue('D5', 'JML');
                $event->sheet->getDelegate()->mergeCells('E4:G4');
                $event->sheet->setCellValue('E4', '6 - 11 Bln');
                $event->sheet->setCellValue('E5', 'L');
                $event->sheet->setCellValue('F5', 'P');
                $event->sheet->setCellValue('G5', 'JML');
                $event->sheet->getDelegate()->mergeCells('H4:J4');
                $event->sheet->setCellValue('H4', '12 - 23 Bln');
                $event->sheet->setCellValue('H5', 'L');
                $event->sheet->setCellValue('I5', 'P');
                $event->sheet->setCellValue('J5', 'JML');
                $event->sheet->getDelegate()->mergeCells('K4:M4');
                $event->sheet->setCellValue('K4', '24 - 59 Bln');
                $event->sheet->setCellValue('K5', 'L');
                $event->sheet->setCellValue('L5', 'P');
                $event->sheet->setCellValue('M5', 'JML');
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        /**
         * Mengatur "wrap text" atau "teks berjalan
         * otomatis" untuk kolom yang membutuhkan
         * 
         */
        $sheet->getStyle(1)->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(5);
        $sheet->getColumnDimension('C')->setWidth(5);
        $sheet->getColumnDimension('D')->setWidth(5);
        $sheet->getColumnDimension('E')->setWidth(5);
        $sheet->getColumnDimension('F')->setWidth(5);
        $sheet->getColumnDimension('G')->setWidth(5);
        $sheet->getColumnDimension('H')->setWidth(5);
        $sheet->getColumnDimension('I')->setWidth(5);
        $sheet->getColumnDimension('J')->setWidth(5);
        $sheet->getColumnDimension('K')->setWidth(5);
        $sheet->getColumnDimension('L')->setWidth(5);
        $sheet->getColumnDimension('M')->setWidth(5);

        $sheet->getStyle('A4:M16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [
            1 => ['font' => ['bold' => true]],
            4 => ['font' => ['bold' => true]],
            5 => ['font' => ['bold' => true]],
            "A" => ['font' => ['bold' => true]],
        ];
    }

    public function startCell(): string
    {
        return 'A6';
    }
}
