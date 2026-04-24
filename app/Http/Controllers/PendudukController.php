<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penduduk = Penduduk::with('kelurahan')->latest()->paginate(10);
        return view('penduduk.index', compact('penduduk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelurahan = Kelurahan::all();
        return view('penduduk.create', compact('kelurahan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:penduduk,nik',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kelurahan_id' => 'required|exists:kelurahan,id',
            'no_telepon' => 'nullable|string|max:20',
            'status_pernikahan' => 'required|string',
            'jumlah_tanggungan' => 'required|integer|min:0',
            'penghasilan' => 'required|numeric|min:0',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        Penduduk::create($validated);

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penduduk $penduduk)
    {
        $penduduk->load(['kelurahan', 'rumah', 'penilaian.hasilSPK']);
        return view('penduduk.show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penduduk $penduduk)
    {
        $kelurahan = Kelurahan::all();
        return view('penduduk.edit', compact('penduduk', 'kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penduduk $penduduk)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:penduduk,nik,' . $penduduk->id,
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kelurahan_id' => 'required|exists:kelurahan,id',
            'no_telepon' => 'nullable|string|max:20',
            'status_pernikahan' => 'required|string',
            'jumlah_tanggungan' => 'required|integer|min:0',
            'penghasilan' => 'required|numeric|min:0',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $penduduk->update($validated);

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil dihapus.');
    }
}
