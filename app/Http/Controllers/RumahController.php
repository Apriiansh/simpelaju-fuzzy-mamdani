<?php

namespace App\Http\Controllers;

use App\Models\Rumah;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class RumahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rumah = Rumah::with('penduduk')->latest()->paginate(10);
        return view('rumah.index', compact('rumah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $penduduk_id = $request->query('penduduk_id');
        $penduduk = null;
        if ($penduduk_id) {
            $penduduk = Penduduk::findOrFail($penduduk_id);
        } else {
            // Only residents without house record
            $penduduk = Penduduk::doesntHave('rumah')->get();
        }
        
        return view('rumah.create', compact('penduduk', 'penduduk_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id|unique:rumah,penduduk_id',
            'status_kepemilikan' => 'required|string',
            'luas_bangunan' => 'required|numeric|min:0',
            
            // Pilar A
            'pondasi' => 'required|string',
            'kolom_balok' => 'required|string',
            'konstruksi_atap' => 'required|string',
            
            // Pilar B
            'jendela' => 'required|string',
            'ventilasi' => 'required|string',
            'kamar_mandi' => 'required|string',
            'jarak_sumber_air' => 'required|string',
            
            // Pilar D
            'material_atap' => 'required|string',
            'kondisi_atap' => 'required|string',
            'material_dinding' => 'required|string',
            'kondisi_dinding' => 'required|string',
            'material_lantai' => 'required|string',
            'kondisi_lantai' => 'required|string',
            
            'foto_rumah' => 'nullable|url',
        ]);

        $rumah = Rumah::create($validated);

        // OTOMATIS: Jalankan Penilaian SPK Mamdani setelah simpan data rumah
        try {
            $penilaianService = app(\App\Services\Fuzzy\InputMapperService::class);
            $penilaianService->runAssessment($rumah->penduduk_id, date('Y'));
        } catch (\Exception $e) {
            // Log error if fuzzy fails but keep the house data saved
            \Log::error("Fuzzy calculation failed: " . $e->getMessage());
        }

        return redirect()->route('penduduk.show', $validated['penduduk_id'])
            ->with('success', 'Data rumah berhasil disimpan dan skor kelayakan telah dihitung otomatis.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rumah $rumah)
    {
        return redirect()->route('penduduk.show', $rumah->penduduk_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rumah $rumah)
    {
        return view('rumah.edit', compact('rumah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rumah $rumah)
    {
        $validated = $request->validate([
            'status_kepemilikan' => 'required|string',
            'luas_bangunan' => 'required|numeric',
            'pondasi' => 'required|string',
            'kolom_balok' => 'required|string',
            'konstruksi_atap' => 'required|string',
            'jendela' => 'required|string',
            'ventilasi' => 'required|string',
            'kamar_mandi' => 'required|string',
            'jarak_sumber_air' => 'required|string',
            'material_atap' => 'required|string',
            'material_dinding' => 'required|string',
            'material_lantai' => 'required|string',
            'kondisi_atap' => 'required|string',
            'kondisi_dinding' => 'required|string',
            'kondisi_lantai' => 'required|string',
        ]);

        $rumah->update($validated);

        // OTOMATIS: Update Penilaian SPK Mamdani setelah update data rumah
        try {
            $penilaianService = app(\App\Services\Fuzzy\InputMapperService::class);
            $penilaianService->runAssessment($rumah->penduduk_id, date('Y'));
        } catch (\Exception $e) {
            \Log::error("Fuzzy update failed: " . $e->getMessage());
        }

        return redirect()->route('penduduk.show', $rumah->penduduk_id)
            ->with('success', 'Data rumah berhasil diperbarui dan skor kelayakan telah dihitung ulang.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rumah $rumah)
    {
        $penduduk_id = $rumah->penduduk_id;
        $rumah->delete();

        return redirect()->route('penduduk.show', $penduduk_id)
            ->with('success', 'Data rumah berhasil dihapus.');
    }
    public function recalculate(Rumah $rumah)
    {
        try {
            $penilaianService = app(\App\Services\Fuzzy\InputMapperService::class);
            $penilaianService->runAssessment($rumah->penduduk_id, date('Y'));
            return back()->with('success', 'Skor kelayakan berhasil dihitung ulang.');
        } catch (\Exception $e) {
            \Log::error("Fuzzy manual calculation failed: " . $e->getMessage());
            return back()->with('error', 'Gagal menghitung skor: ' . $e->getMessage());
        }
    }
}
