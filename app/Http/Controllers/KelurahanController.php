<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use Illuminate\Http\Request;

class KelurahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelurahan = Kelurahan::orderBy('nama')->get();
        return view('kelurahan.index', compact('kelurahan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kelurahan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kelurahan,nama',
            'kode' => 'nullable|string|max:50',
            'batas_wilayah' => 'nullable|string',
        ]);

        Kelurahan::create($validated);

        return redirect()->route('kelurahan.index')->with('success', 'Data kelurahan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelurahan $kelurahan)
    {
        $kelurahan->load('penduduk');
        return view('kelurahan.show', compact('kelurahan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelurahan $kelurahan)
    {
        return view('kelurahan.edit', compact('kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelurahan $kelurahan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kelurahan,nama,' . $kelurahan->id,
            'kode' => 'nullable|string|max:50',
            'batas_wilayah' => 'nullable|string',
        ]);

        $kelurahan->update($validated);

        return redirect()->route('kelurahan.index')->with('success', 'Data kelurahan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelurahan $kelurahan)
    {
        if ($kelurahan->penduduk()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus kelurahan yang masih memiliki data penduduk.');
        }

        $kelurahan->delete();

        return redirect()->route('kelurahan.index')->with('success', 'Data kelurahan berhasil dihapus.');
    }
}
