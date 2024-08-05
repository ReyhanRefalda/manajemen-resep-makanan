<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    public function index(Request $request)
    {
        $query = Bahan::query();

        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $bahans = $query->get();

        return view('bahan.index', compact('bahans'))->with('searchQuery', $request->search);
    }

    public function create()
    {
        return view('bahan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (Bahan::whereRaw('LOWER(nama) = ?', [strtolower($value)])->exists()) {
                        $fail('Nama bahan sudah ada.');
                    }
                },
            ],
        ], [
            'nama.required' => 'Nama bahan harus diisi',
            'nama.string' => 'Nama bahan harus berupa huruf',
            'nama.max' => 'Nama bahan tidak boleh lebih dari 255 karakter',
        ]);

        Bahan::create($request->all());

        return redirect()->route('bahan.index')->with('success', 'Bahan berhasil ditambahkan.');
    }

    public function edit(Bahan $bahan)
    {
        return view('bahan.edit', compact('bahan'));
    }

    public function update(Request $request, Bahan $bahan)
    {
        // Ambil nama bahan yang lama
        $oldNama = $bahan->nama;
    
        // Validasi
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($oldNama) {
                    // Hanya cek jika nama bahan berubah
                    if (strtolower($value) !== strtolower($oldNama) && Bahan::whereRaw('LOWER(nama) = ?', [strtolower($value)])->exists()) {
                        $fail('Nama bahan sudah ada.');
                    }
                },
            ],
        ], [
            'nama.required' => 'Nama bahan harus diisi',
            'nama.string' => 'Nama bahan harus berupa huruf',
            'nama.max' => 'Nama bahan tidak boleh lebih dari 255 karakter',
        ]);
    
        // Perbarui data jika ada perubahan
        if ($request->nama !== $oldNama) {
            $bahan->update($request->all());
        }
    
        return redirect()->route('bahan.index')->with('success', 'Bahan berhasil diperbarui.');
    }

    public function destroy(Bahan $bahan)
    {
        // Lakukan soft delete
        $bahan->delete();

        return redirect()->route('bahan.index')->with('success', 'Bahan berhasil dihapus.');
    }
}
