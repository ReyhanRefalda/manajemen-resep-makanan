<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    public function index()
    {
        $bahans = Bahan::all();
        return view('bahan.index', compact('bahans'));
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
        
        $bahan->update($request->all());

        return redirect()->route('bahan.index')->with('success', 'Bahan berhasil diperbarui.');
    }

    public function destroy(Bahan $bahan)
    {
        $bahan->delete();

        return redirect()->route('bahan.index')->with('success', 'Bahan berhasil dihapus.');
    }
}
