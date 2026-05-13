<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KelurahanSheetExport implements FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithDrawings, WithCustomStartCell
{
    protected Collection $data;
    protected string $namaKelurahan;
    protected array $filters;

    // KOP & Title takes rows 1-9, row 10 is spacing, data header is row 11
    public const KOP_ROWS   = 9;
    public const DATA_HEADER_ROW = 11;

    public function __construct(Collection $data, string $namaKelurahan, array $filters = [])
    {
        $this->data           = $data;
        $this->namaKelurahan  = $namaKelurahan;
        $this->filters        = $filters;
    }

    public function startCell(): string
    {
        return 'A' . self::DATA_HEADER_ROW;
    }

    // ---------------------  Sheet title (tab) ---------------------
    public function title(): string
    {
        // Sheet name max 31 chars and no special chars
        return substr(preg_replace('/[*:\/\\?[\]]/', '', $this->namaKelurahan), 0, 31);
    }

    // ---------------------  Data source ---------------------
    public function collection(): Collection
    {
        return $this->data;
    }

    // ---------------------  Column headings (appended after KOP) ---------------------
    public function headings(): array
    {
        return [
            'No',
            "Data Penduduk\n(NIK & Nama)",
            "Kontak & Alamat",
            "Kondisi Ekonomi\n(Penghasilan & Tanggungan)",
            "Keselamatan Bangunan\n(Pondasi, Kolom, Konstruksi Atap)",
            "Kesehatan\n(Jendela, Ventilasi, Sanitasi, Air)",
            "Luas (m²)",
            "Komponen Material\n(Atap, Dinding, Lantai)",
            'Status Kepemilikan',
            'Status Kelayakan',
            'Rekomendasi / Keterangan',
        ];
    }

    // ---------------------  Row mapping ---------------------
    public function map($item): array
    {
        static $no = 0;
        $no++;

        $penduduk = $item->penilaian->penduduk;
        $rumah    = $penduduk->rumah;

        // Grouping Data Penduduk
        $dataPenduduk = $penduduk->nik . "\n" . $penduduk->nama_lengkap;
        
        // Grouping Kontak
        $kontakAlamat = $penduduk->alamat . "\n" . ($penduduk->no_telepon ?? 'No Telp: -');

        // Grouping Ekonomi
        $ekonomi = "Rp " . number_format($penduduk->penghasilan, 0, ',', '.') . " / bln\n" .
                   $penduduk->jumlah_tanggungan . " Tanggungan\n" .
                   "Status: " . ($penduduk->status_pernikahan ?? '-');

        // Pilar A
        $pilarA = "Pondasi: " . ($rumah->pondasi ?? '-') . "\n" .
                  "Kolom: " . ($rumah->kolom_balok ?? '-') . "\n" .
                  "Atap: " . ($rumah->konstruksi_atap ?? '-');

        // Pilar B
        $pilarB = "Jendela: " . ($rumah->jendela ?? '-') . "\n" .
                  "Ventilasi: " . ($rumah->ventilasi ?? '-') . "\n" .
                  "Kamar Mandi: " . ($rumah->kamar_mandi ?? '-') . "\n" .
                  "Sumber Air: " . ($rumah->jarak_sumber_air ?? '-');

        // Pilar C
        $pilarC = ($rumah->luas_bangunan ?? '-') . " m²";

        // Pilar D
        $pilarD = "Atap: " . ($rumah->material_atap ?? '-') . " (" . ($rumah->kondisi_atap ?? '-') . ")\n" .
                  "Dinding: " . ($rumah->material_dinding ?? '-') . " (" . ($rumah->kondisi_dinding ?? '-') . ")\n" .
                  "Lantai: " . ($rumah->material_lantai ?? '-') . " (" . ($rumah->kondisi_lantai ?? '-');

        return [
            $no,
            $dataPenduduk,
            $kontakAlamat,
            $ekonomi,
            $pilarA,
            $pilarB,
            $pilarC,
            $pilarD,
            $rumah->status_kepemilikan ?? '-',
            str_replace('_', ' ', $item->kategori_kelayakan),
            $item->rekomendasi ?? '-',
        ];
    }

    // ---------------------  Column widths ---------------------
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 25,  // NIK & Nama
            'C' => 30,  // Kontak Alamat
            'D' => 25,  // Ekonomi
            'E' => 35,  // Pilar A
            'F' => 30,  // Pilar B
            'G' => 12,  // Pilar C
            'H' => 45,  // Pilar D
            'I' => 18,  // Kepemilikan
            'J' => 18,  // Kelayakan
            'K' => 40,  // Rekomendasi
        ];
    }

    // ---------------------  Logo (Drawing) ---------------------
    public function drawings(): Drawing
    {
        $drawing = new Drawing();
        $drawing->setName('Logo Dinas');
        $drawing->setDescription('Logo Dinas Perkim Palembang');
        $drawing->setPath(public_path('logo_dinas.png'));
        $drawing->setHeight(70);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(25);
        $drawing->setOffsetY(5);

        return $drawing;
    }

    // ---------------------  Styles ---------------------
    public function styles(Worksheet $sheet): void
    {
        $lastCol = 'K'; // 11 columns (A–K)
        $totalRows = self::KOP_ROWS + 1 + $this->data->count(); // KOP + header + data rows

        // ── KOP SURAT & JUDUL ──────────────────────────────────
        // Merge for dinas text (columns B–K, rows 1-9)
        $sheet->mergeCells("B1:{$lastCol}1");
        $sheet->mergeCells("B2:{$lastCol}2");
        $sheet->mergeCells("B3:{$lastCol}3");
        $sheet->mergeCells("B4:{$lastCol}4");
        $sheet->mergeCells("B5:{$lastCol}5");
        $sheet->mergeCells("B6:{$lastCol}6");
        $sheet->mergeCells("B7:{$lastCol}7");
        $sheet->mergeCells("B8:{$lastCol}8");
        $sheet->mergeCells("B9:{$lastCol}9");

        $sheet->setCellValue('B1', 'PEMERINTAH KOTA PALEMBANG');
        $sheet->setCellValue('B2', 'DINAS PERUMAHAN RAKYAT DAN KAWASAN PERMUKIMAN');
        $sheet->setCellValue('B3', 'Jl. D.I. Panjaitan No. 01 A RT. 09 RW. 03, Kel. Plaju Ilir, Kec. Plaju, Kota Palembang, Sumatera Selatan, 3026');
        $sheet->setCellValue('B4', 'Email: kec-plaju@palembang.go.id | Website: kec-plaju.palembang.go.id');
        $sheet->setCellValue('B5', '');
        $sheet->setCellValue('B6', ''); // Jarak 1
        $sheet->setCellValue('B7', ''); // Jarak 2
        $sheet->setCellValue('B8', 'LAPORAN HASIL PENILAIAN BANTUAN RTLH');
        $sheet->setCellValue('B9', 'Kelurahan ' . strtoupper($this->namaKelurahan));

        // KOP & Title text styles
        $sheet->getStyle('B1:B4')->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getStyle('B1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
        ]);
        $sheet->getStyle('B2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
        ]);
        $sheet->getStyle('B3:B4')->applyFromArray([
            'font' => ['italic' => true, 'size' => 9],
        ]);
        $sheet->getStyle('B8')->applyFromArray([
            'font' => ['bold' => true, 'size' => 13, 'underline' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('B9')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Row heights
        $sheet->getRowDimension(1)->setRowHeight(18);
        $sheet->getRowDimension(2)->setRowHeight(22);
        $sheet->getRowDimension(3)->setRowHeight(14);
        $sheet->getRowDimension(4)->setRowHeight(14);
        $sheet->getRowDimension(5)->setRowHeight(8); // Spacer border row
        $sheet->getRowDimension(6)->setRowHeight(14); // Jarak 1
        $sheet->getRowDimension(7)->setRowHeight(14); // Jarak 2
        $sheet->getRowDimension(8)->setRowHeight(20); // Title
        $sheet->getRowDimension(9)->setRowHeight(18); // Subtitle
        $sheet->getRowDimension(10)->setRowHeight(14); // Jarak bawah (1 baris ke tabel)

        // Bottom border of KOP (Under the address)
        $sheet->getStyle("A5:{$lastCol}5")->applyFromArray([
            'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THICK]],
        ]);

        // ── DATA HEADER ROW ────────────────────────────────────
        $headerRow = self::DATA_HEADER_ROW;
        $sheet->getStyle("A{$headerRow}:{$lastCol}{$headerRow}")->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2D6A4F']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
        ]);
        $sheet->getRowDimension($headerRow)->setRowHeight(40); // Slightly taller for wrapped headings

        // ── DATA ROWS ──────────────────────────────────────────
        if ($this->data->count() > 0) {
            $firstDataRow = $headerRow + 1;
            $lastDataRow  = $headerRow + $this->data->count();

            $sheet->getStyle("A{$firstDataRow}:{$lastCol}{$lastDataRow}")->applyFromArray([
                'font'      => ['size' => 9],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
            ]);

            // Zebra striping
            for ($row = $firstDataRow; $row <= $lastDataRow; $row++) {
                if ($row % 2 === 0) {
                    $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0F7F4']],
                    ]);
                }
            }

            // Center specific columns: No, Pilar C (Luas), Kepemilikan, Kelayakan
            $centerCols = ['A', 'G', 'I', 'J'];
            foreach ($centerCols as $col) {
                $sheet->getStyle("{$col}{$firstDataRow}:{$col}{$lastDataRow}")->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                ]);
            }

            // Highlight LAYAK rows in green, TIDAK_LAYAK in red (Column J is Status Kelayakan)
            foreach ($this->data as $i => $item) {
                $row   = $firstDataRow + $i;
                $color = $item->kategori_kelayakan === 'LAYAK' ? '2D6A4F' : 'C0392B';
                $sheet->getStyle("J{$row}:J{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => $color]],
                ]);
            }
        }

        // Freeze panes below KOP header
        $sheet->freezePane('A' . (self::DATA_HEADER_ROW + 1));

        // ── FILTER INFO (appended below data) ─────────────────
        if (!empty($this->filters)) {
            $filterRow = $totalRows + 2;
            $sheet->mergeCells("A{$filterRow}:{$lastCol}{$filterRow}");
            $filterText = 'Filter: ';
            foreach ($this->filters as $key => $value) {
                $filterText .= ucfirst(str_replace('_', ' ', $key)) . ': ' . $value . '   ';
            }
            $sheet->setCellValue("A{$filterRow}", trim($filterText));
            $sheet->getStyle("A{$filterRow}")->applyFromArray([
                'font'      => ['italic' => true, 'size' => 8, 'color' => ['rgb' => '666666']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ]);
        }
    }
}
