<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Resep; // Pastikan model Resep diimport
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $kategoris = Kategori::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->get();

        return view('kategori.index', compact('kategoris', 'search'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (Kategori::whereRaw('LOWER(nama) = ?', strtolower($value))->exists()) {
                        $fail('Nama kategori sudah ada.');
                    }
                },
            ],
        ], [
            'nama.required' => 'Nama kategori harus diisi',
            'nama.string' => 'Nama kategori harus berupa huruf',
            'nama.max' => 'Nama kategori tidak boleh lebih dari 255 karakter',
        ]);

        Kategori::create($validatedData);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validatedData = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($kategori) {
                    if (Kategori::whereRaw('LOWER(nama) = ?', strtolower($value))
                        ->where('id', '!=', $kategori->id)
                        ->exists()) {
                        $fail('Nama kategori sudah ada.');
                    }
                },
            ],
        ], [
            'nama.required' => 'Nama kategori harus diisi',
            'nama.string' => 'Nama kategori harus berupa huruf',
            'nama.max' => 'Nama kategori tidak boleh lebih dari 255 karakter',
        ]);

        $kategori->update($validatedData);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        // Cek apakah kategori sedang digunakan di data resep
        if (Resep::where('kategori_id', $kategori->id)->exists()) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak bisa dihapus karena sedang digunakan di data resep.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
