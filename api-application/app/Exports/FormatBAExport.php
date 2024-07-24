<?php

namespace App\Exports;

use App\Models\BayiModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FormatBAExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell, WithStyles
{
    protected $batasBulanStart = [0, 6, 12, 24];
    protected $batasBulanEnd = [5, 11, 23, 59];
    protected $tahunDipilih;
    protected $tabDipilih;
    public function __construct($tahun, $tab)
    {
        $this->tahunDipilih = $tahun;
        $this->tabDipilih = $tab;
    }
    public function headings(): array
    {
        /**
         * Menyusun baris judul Anda
         *
         */
        return [
            'Nama Bayi',
            'L/P',
            'Tanggal Lahir',
            'Berat Lahir',
            'Nama Ibu',
            'Nama Ayah',
            'RT/RW',
            'KMS',
            'KIA',
            'Umur',
            'Berat',
            'N/T/O/B & BGM',
            'Umur',
            'Berat',
            'N/T/O/B & BGM',
            'Umur',
            'Berat',
            'N/T/O/B & BGM',
            'Umur',
            'Berat',
            'N/T/O/B & BGM',
            'Umur',
            'Berat',
            'N/T/O/B & BGM',
            'Umur',
            'Berat',
            'N/T/O/B & BGM',
            'Umur',
            'Berat',
            'N/T/O/B & BGM',
            'Umur',
            'Berat',
            'N/T/O/B & BGM',
            'Umur',
            'Berat',
            'N/T/O/B & BGM',
            'Umur',
            'Berat',
            'N/T/O/B & BGM',
            'Umur',
            'Berat',
            'N/T/O/B & BGM',
            'Umur',
            'Berat',
            'N/T/O/B & BGM',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        /**
         * Menyiapkan label bulan
         *
         */
        $bulanLabels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        /**
         * Membuat case statment untuk dikumpulkan
         * dan dieksekusi bersamaan nantinya
         *
         */
        $caseStatements = [];

        /**
         * Melakukan perulangan sebanyak jumlah bulan yang ada
         *
         */
        foreach ($bulanLabels as $index => $bulan) {
            $caseStatements[] = "MAX(CASE WHEN penimbangan.bulan_penimbangan = " . ($index + 1) . " AND penimbangan.id IS NOT NULL THEN standar_deviasi.umur_bulan ELSE '-' END) as 'Umur - " . $bulan . "'";
            $caseStatements[] = "MAX(CASE WHEN penimbangan.bulan_penimbangan = " . ($index + 1) . " AND penimbangan.id IS NOT NULL THEN penimbangan.berat_badan ELSE '-' END) as 'Berat - " . $bulan . "'";
            $caseStatements[] = "MAX(CASE WHEN penimbangan.bulan_penimbangan = " . ($index + 1) . " AND penimbangan.id IS NOT NULL THEN penimbangan.ntob ELSE '-' END) as 'N/T/O/B - " . $bulan . "'";
        }

        /**
         * Membuat query utama
         *
         */
        $queries = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $queries[$bulan - 1] = BayiModel::select(
                'bayi.nama',
                'bayi.jenis_kelamin',
                'bayi.tanggal_lahir',
                'bayi.berat_lahir',
                'orang_tua.nama_ibu',
                'orang_tua.nama_ayah',
                'orang_tua.rt_rw',
                'bayi.memiliki_kms',
                'bayi.memiliki_kia'
            )->join('orang_tua', 'orang_tua.id', 'bayi.id_orang_tua')
                ->leftJoin('penimbangan', function ($join) use ($bulan) {
                    $join->on('penimbangan.id_bayi', '=', 'bayi.id')
                        ->where('penimbangan.tahun_penimbangan', $this->tahunDipilih);
                })
                ->leftJoin('standar_deviasi', 'standar_deviasi.id', '=', 'penimbangan.id_standar_deviasi')
                ->whereRaw('(' . $this->tahunDipilih . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $bulan . ' - MONTH(bayi.tanggal_lahir) BETWEEN ' . $this->batasBulanStart[$this->tabDipilih - 1] . ' AND ' . $this->batasBulanEnd[$this->tabDipilih - 1])
                ->whereNull('bayi.tanggal_meninggal');

            /**
             * Melakukan grouping data agar bisa benar benar selaras
             *
             */
            $queries[$bulan - 1]->selectRaw(implode(',', $caseStatements))
                ->groupBy('bayi.nama')
                ->groupBy('bayi.jenis_kelamin')
                ->groupBy('bayi.tanggal_lahir')
                ->groupBy('bayi.berat_lahir')
                ->groupBy('orang_tua.nama_ibu')
                ->groupBy('orang_tua.nama_ayah')
                ->groupBy('orang_tua.rt_rw')
                ->groupBy('bayi.memiliki_kms')
                ->groupBy('bayi.memiliki_kia');

        }

        /**
         * Melakukan perulangan dari queries
         *
         */
        foreach ($queries as $index => $query) {

            /**
             * Memeriksa query utama
             *
             */
            if ($index === 0) {

                /**
                 * Tetapkan index 0 menjadi query utama
                 *
                 */
                $mergedQuery = $query;
            } else {

                /**
                 * Menambahkan query lainnya untuk
                 * distak ke dalam query utama
                 *
                 */
                $mergedQuery = $mergedQuery->union($query);
            }
        }

        /**
         * Mengambil data dari query yang sudah diolah
         *
         */
        $results = $mergedQuery->get();

        /**
         * Mengembalikan data format b untuk
         * dicetak sebagai file excel
         *
         */
        return $results;
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Menggabungkan kolom A sampai C pada baris 1
                $event->sheet->getDelegate()->mergeCells('A1:AS3');

                // Menambahkan judul ke tengah-tengah sel yang digabungkan
                $event->sheet->setCellValue('A1', 'Register bayi (' . $this->batasBulanStart[$this->tabDipilih - 1] . ' - ' . $this->batasBulanEnd[$this->tabDipilih - 1] . ' bulan) dalam wilayah kerja posyandu Januari - Desember. Tahun ' . $this->tahunDipilih);

                $event->sheet->getDelegate()->mergeCells('J4:L4');
                $event->sheet->getDelegate()->mergeCells('M4:O4');
                $event->sheet->getDelegate()->mergeCells('P4:R4');
                $event->sheet->getDelegate()->mergeCells('S4:U4');
                $event->sheet->getDelegate()->mergeCells('V4:X4');
                $event->sheet->getDelegate()->mergeCells('Y4:AA4');
                $event->sheet->getDelegate()->mergeCells('AB4:AD4');
                $event->sheet->getDelegate()->mergeCells('AE4:AG4');
                $event->sheet->getDelegate()->mergeCells('AH4:AJ4');
                $event->sheet->getDelegate()->mergeCells('AK4:AM4');
                $event->sheet->getDelegate()->mergeCells('AN4:AP4');
                $event->sheet->getDelegate()->mergeCells('AQ4:AS4');

                $event->sheet->getDelegate()->mergeCells('A4:A5');
                $event->sheet->getDelegate()->mergeCells('B4:B5');
                $event->sheet->getDelegate()->mergeCells('C4:C5');
                $event->sheet->getDelegate()->mergeCells('D4:D5');
                $event->sheet->getDelegate()->mergeCells('E4:E5');
                $event->sheet->getDelegate()->mergeCells('F4:F5');
                $event->sheet->getDelegate()->mergeCells('G4:G5');
                $event->sheet->getDelegate()->mergeCells('H4:H5');
                $event->sheet->getDelegate()->mergeCells('I4:I5');

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

                $event->sheet->setCellValue('A4', 'Nama Bayi');
                $event->sheet->setCellValue('B4', 'L/P');
                $event->sheet->setCellValue('C4', 'Tanggal Lahir');
                $event->sheet->setCellValue('D4', 'Berat Lahir');
                $event->sheet->setCellValue('E4', 'Nama Ibu');
                $event->sheet->setCellValue('F4', 'Nama Ayah');
                $event->sheet->setCellValue('G4', 'RT/RW');
                $event->sheet->setCellValue('H4', 'KMS');
                $event->sheet->setCellValue('I4', 'KIA');
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
        $sheet->getColumnDimension('A')->setWidth(26);
        $sheet->getColumnDimension('B')->setWidth(3);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(26);
        $sheet->getColumnDimension('F')->setWidth(26);
        $sheet->getColumnDimension('G')->setWidth(7);
        $sheet->getColumnDimension('H')->setWidth(5);
        $sheet->getColumnDimension('I')->setWidth(5);

        // Melanjutkan penyesuaian dimensi kolom untuk setiap bulan (Umur, Berat, N/T/O/B)
        $sheet->getColumnDimension('J')->setWidth(5);
        $sheet->getColumnDimension('K')->setWidth(5);
        $sheet->getColumnDimension('L')->setWidth(20);

        $sheet->getColumnDimension('M')->setWidth(5);
        $sheet->getColumnDimension('N')->setWidth(5);
        $sheet->getColumnDimension('O')->setWidth(20);

        $sheet->getColumnDimension('P')->setWidth(5);
        $sheet->getColumnDimension('Q')->setWidth(5);
        $sheet->getColumnDimension('R')->setWidth(20);

        $sheet->getColumnDimension('S')->setWidth(5);
        $sheet->getColumnDimension('T')->setWidth(5);
        $sheet->getColumnDimension('U')->setWidth(20);

        $sheet->getColumnDimension('V')->setWidth(5);
        $sheet->getColumnDimension('W')->setWidth(5);
        $sheet->getColumnDimension('X')->setWidth(20);

        $sheet->getColumnDimension('Y')->setWidth(5);
        $sheet->getColumnDimension('Z')->setWidth(5);
        $sheet->getColumnDimension('AA')->setWidth(20);

        $sheet->getColumnDimension('AB')->setWidth(5);
        $sheet->getColumnDimension('AC')->setWidth(5);
        $sheet->getColumnDimension('AD')->setWidth(20);

        $sheet->getColumnDimension('AE')->setWidth(5);
        $sheet->getColumnDimension('AF')->setWidth(5);
        $sheet->getColumnDimension('AG')->setWidth(20);

        $sheet->getColumnDimension('AH')->setWidth(5);
        $sheet->getColumnDimension('AI')->setWidth(5);
        $sheet->getColumnDimension('AJ')->setWidth(20);

        $sheet->getColumnDimension('AK')->setWidth(5);
        $sheet->getColumnDimension('AL')->setWidth(5);
        $sheet->getColumnDimension('AM')->setWidth(20);

        $sheet->getColumnDimension('AN')->setWidth(5);
        $sheet->getColumnDimension('AO')->setWidth(5);
        $sheet->getColumnDimension('AP')->setWidth(20);

        $sheet->getColumnDimension('AQ')->setWidth(5);
        $sheet->getColumnDimension('AR')->setWidth(5);
        $sheet->getColumnDimension('AS')->setWidth(20);

        return [
            1 => ['font' => ['bold' => true, 'size' => 20]],
            4 => ['font' => ['bold' => true]],
            5 => ['font' => ['bold' => true]],
        ];
    }

    public function startCell(): string
    {
        return 'A5';
    }
}
