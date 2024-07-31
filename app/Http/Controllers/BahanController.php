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
                    if (Bahan::whereRaw('LOWER(nama) = ?', strtolower($value))->exists()) {
                        $fail('Nama bahan sudah ada.');
                    }
                },
            ],
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
                function ($attribute, $value, $fail) use ($bahan) {
                    if (Bahan::whereRaw('LOWER(nama) = ?', strtolower($value))
                        ->where('id', '!=', $bahan->id)
                        ->exists()) {
                        $fail('Nama bahan sudah ada.');
                    }
                },
            ],
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
