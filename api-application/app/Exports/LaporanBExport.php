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
            $SL[0],
            $SP[0],
            $S[0],
            $SL[1],
            $SP[1],
            $S[1],
            $SL[2],
            $SP[2],
            $S[2],
            $SL[3],
            $SP[3],
            $S[3],
        ]);
        $result->push([
            "K",
            $KL[0],
            $KP[0],
            $K[0],
            $KL[1],
            $KP[1],
            $K[1],
            $KL[2],
            $KP[2],
            $K[2],
            $KL[3],
            $KP[3],
            $K[3],
        ]);
        $result->push([
            "N",
            $NL[0],
            $NP[0],
            $N[0],
            $NL[1],
            $NP[1],
            $N[1],
            $NL[2],
            $NP[2],
            $N[2],
            $NL[3],
            $NP[3],
            $N[3],
        ]);
        $result->push([
            "T",
            $TL[0],
            $TP[0],
            $T[0],
            $TL[1],
            $TP[1],
            $T[1],
            $TL[2],
            $TP[2],
            $T[2],
            $TL[3],
            $TP[3],
            $T[3],
        ]);
        $result->push([
            "O",
            $OL[0],
            $OP[0],
            $O[0],
            $OL[1],
            $OP[1],
            $O[1],
            $OL[2],
            $OP[2],
            $O[2],
            $OL[3],
            $OP[3],
            $O[3],
        ]);
        $result->push([
            "B",
            $BL[0],
            $BP[0],
            $B[0],
            $BL[1],
            $BP[1],
            $B[1],
            $BL[2],
            $BP[2],
            $B[2],
            $BL[3],
            $BP[3],
            $B[3],
        ]);
        $result->push([
            "D",
            $DL[0],
            $DP[0],
            $D[0],
            $DL[1],
            $DP[1],
            $D[1],
            $DL[2],
            $DP[2],
            $D[2],
            $DL[3],
            $DP[3],
            $D[3],
        ]);
        $result->push([
            "-",
            $STL[0],
            $STP[0],
            $ST[0],
            $STL[1],
            $STP[1],
            $ST[1],
            $STL[2],
            $STP[2],
            $ST[2],
            $STL[3],
            $STP[3],
            $ST[3],
        ]);
        $result->push([
            "2T",
            $TTL[0],
            $TTP[0],
            $TT[0],
            $TTL[1],
            $TTP[1],
            $TT[1],
            $TTL[2],
            $TTP[2],
            $TT[2],
            $TTL[3],
            $TTP[3],
            $TT[3],
        ]);
        $result->push([
            "D-O-B",
            $DOBL[0],
            $DOBP[0],
            $DOB[0],
            $DOBL[1],
            $DOBP[1],
            $DOB[1],
            $DOBL[2],
            $DOBP[2],
            $DOB[2],
            $DOBL[3],
            $DOBP[3],
            $DOB[3],
        ]);
        $result->push([
            "BGM",
            $BGML[0],
            $BGMP[0],
            $BGM[0],
            $BGML[1],
            $BGMP[1],
            $BGM[1],
            $BGML[2],
            $BGMP[2],
            $BGM[2],
            $BGML[3],
            $BGMP[3],
            $BGM[3],
        ]);

        return $result;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Menggabungkan kolom A sampai C pada baris 1
                $event->sheet->getDelegate()->mergeCells('A1:H3');

                // Menambahkan judul ke tengah-tengah sel yang digabungkan
                $event->sheet->setCellValue('A1', 'Catatan ibu hamil, kelahiran, kematian bayi' . chr(10) . 'dan kematian ibu hamil, melahirkan atau nifas' . chr(10) . 'Januari - Desember');
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->setCellValue('J4', 'Januari');
                $event->sheet->setCellValue('M4', 'Februari');
                $event->sheet->setCellValue('P4', 'Maret');
                $event->sheet->setCellValue('S4', 'April');
                $event->sheet->setCellValue('V4', 'Mei');
                $event->sheet->setCellValue('Y4', 'Juni');
                $event->sheet->setCellValue('AB4', 'Juli');
                $event->sheet->setCellValue('AE4', 'Agustus');
                $event->sheet->setCellValue('AH4', 'September');
                $event->sheet->setCellValue('AK4', 'Oktober');
                $event->sheet->setCellValue('AN4', 'November');
                $event->sheet->setCellValue('AQ4', 'Desember');
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
        $sheet->getColumnDimension('A')->setWidth(26);
        $sheet->getColumnDimension('B')->setWidth(26);
        $sheet->getColumnDimension('C')->setWidth(26);
        $sheet->getColumnDimension('D')->setWidth(3);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(50);
        return [
            1 => ['font' => ['bold' => true]],
            4 => ['font' => ['bold' => true]],
        ];
    }

    public function startCell(): string
    {
        return 'B4';
    }
}
