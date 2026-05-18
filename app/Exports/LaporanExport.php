<?php

namespace App\Exports;

use App\Models\HasilSpk;
use App\Models\Kelurahan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanExport implements WithMultipleSheets
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function sheets(): array
    {
        $role = $this->filters['user_role'] ?? 'camat';
        $userKelurahanId = $this->filters['user_kelurahan_id'] ?? null;

        $query = HasilSpk::with([
            'penilaian.penduduk.kelurahan',
            'penilaian.penduduk.rumah',
        ])
            ->join('penilaian', 'hasil_spk.penilaian_id', '=', 'penilaian.id')
            ->join('penduduk', 'penilaian.penduduk_id', '=', 'penduduk.id')
            ->select('hasil_spk.*', 'penduduk.kelurahan_id');

        // Scoping based on user role
        if ($role === 'admin') {
            $query->whereIn('penilaian.verifikasi_status', ['terverifikasi', 'valid']);
        } else {
            $query->where('penilaian.verifikasi_status', 'valid');
        }

        // Restrict operator
        if ($role === 'operator' && $userKelurahanId) {
            $query->where('penduduk.kelurahan_id', $userKelurahanId);
        }

        // Apply optional filters
        if (!empty($this->filters['kelurahan_id'])) {
            $query->where('penduduk.kelurahan_id', $this->filters['kelurahan_id']);
        }

        if (!empty($this->filters['status'])) {
            $query->where('hasil_spk.kategori_kelayakan', $this->filters['status']);
        }

        if (!empty($this->filters['tgl_mulai'])) {
            $query->whereDate('penilaian.tanggal_penilaian', '>=', $this->filters['tgl_mulai']);
        }

        if (!empty($this->filters['tgl_selesai'])) {
            $query->whereDate('penilaian.tanggal_penilaian', '<=', $this->filters['tgl_selesai']);
        }

        $query->orderBy('penduduk.kelurahan_id')
              ->orderBy('hasil_spk.nilai_defuzzifikasi', 'desc');

        // Group the results by Kelurahan
        $grouped = $query->get()->groupBy(fn($item) => $item->penilaian->penduduk->kelurahan_id ?? 0);

        $sheets = [];

        foreach ($grouped as $kelurahanId => $rows) {
            $namaKelurahan = $rows->first()->penilaian->penduduk->kelurahan->nama ?? 'Tidak Diketahui';
            $sheets[]      = new KelurahanSheetExport($rows, $namaKelurahan, $this->filters);
        }

        // Edge case: no data at all → produce one empty sheet with a notice
        if (empty($sheets)) {
            $sheets[] = new KelurahanSheetExport(collect(), 'Tidak Ada Data', $this->filters);
        }

        return $sheets;
    }
}
