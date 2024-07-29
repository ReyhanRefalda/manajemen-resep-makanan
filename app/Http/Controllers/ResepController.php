<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResepController extends Controller
{
    public function index()
    {
        $resep = Resep::with('kategori', 'bahan', 'langkah', 'pembuat')->get();
        return view('resep.index', compact('resep'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('resep.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required',
            'waktu_persiapan' => 'required|integer',
            'waktu_memasak' => 'required|integer',
            'kategori_id' => 'required|exists:kategori,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Change here
        ]);

        $imagePath = $request->file('image')->store('images', 'public');
        $validatedData['image'] = $imagePath;

        Resep::create($validatedData);

        return redirect()->route('resep.index')->with('success', 'Resep berhasil ditambahkan.');
    }

    public function show(Resep $resep)
    {
        return view('resep.show', compact('resep'));
    }

    public function edit(Resep $resep)
    {
        $kategoris = Kategori::all();
        return view('resep.edit', compact('resep', 'kategoris'));
    }

    public function update(Request $request, Resep $resep)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required',
            'waktu_persiapan' => 'required|integer',
            'waktu_memasak' => 'required|integer',
            'kategori_id' => 'required|exists:kategori,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Change here
        ]);

        if ($request->hasFile('image')) {
            if ($resep->image) {
                Storage::delete('public/' . $resep->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $resep->update($validatedData);

        return redirect()->route('resep.index')->with('success', 'Resep berhasil diperbarui.');
    }

    public function destroy(Resep $resep)
    {
        if ($resep->image) {
            Storage::delete('public/' . $resep->image);
        }
        $resep->delete();

        return redirect()->route('resep.index')->with('success', 'Resep berhasil dihapus.');
    }
}
