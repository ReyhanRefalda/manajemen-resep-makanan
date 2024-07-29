<?php

namespace App\Http\Controllers;

use App\Models\Langkah;
use App\Models\Resep;
use Illuminate\Http\Request;

class LangkahController extends Controller
{
    public function index()
    {
        $langkah = Langkah::with('resep')->get();
        return view('langkah.index', compact('langkah'));
    }

    public function create()
    {
        $resep = Resep::all();
        return view('langkah.create', compact('resep'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'resep_id' => 'required|exists:resep,id',
            'nomor' => 'required|integer',
            'deskripsi' => 'required',
        ]);

        Langkah::create($validatedData);

        return redirect()->route('langkah.index')->with('success', 'Langkah berhasil ditambahkan.');
    }

    public function show(Langkah $langkah)
    {
        return view('langkah.show', compact('langkah'));
    }

    public function edit(Langkah $langkah)
    {
        $resep = Resep::all();
        return view('langkah.edit', compact('langkah', 'resep'));
    }

    public function update(Request $request, Langkah $langkah)
    {
        $validatedData = $request->validate([
            'resep_id' => 'required|exists:resep,id',
            'nomor' => 'required|integer',
            'deskripsi' => 'required',
        ]);

        $langkah->update($validatedData);

        return redirect()->route('langkah.index')->with('success', 'Langkah berhasil diperbarui.');
    }

    public function destroy(Langkah $langkah)
    {
        $langkah->delete();

        return redirect()->route('langkah.index')->with('success', 'Langkah berhasil dihapus.');
    }
}
