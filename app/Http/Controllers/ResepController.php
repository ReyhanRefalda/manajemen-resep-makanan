<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use App\Models\Kategori;
use App\Models\Pembuat; // Pastikan untuk mengimpor model Pembuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResepController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $reseps = Resep::with('kategori', 'pembuat')
                        ->where('nama', 'like', '%' . $search . '%')
                        ->get();

        return view('resep.index', compact('reseps'));
    }

   


    
    public function create()
    {
        $kategoris = Kategori::all();
        $pembuat = Pembuat::all(); // Ambil data pembuat
        return view('resep.create', compact('kategoris', 'pembuat'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required',
            'waktu_persiapan' => 'required',
            'waktu_memasak' => 'required',
            'kategori_id' => 'required|exists:kategori,id',
            'pembuat_id' => 'required|exists:pembuat,id', // Validasi pembuat_id
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
        ],[
            'nama.required' => 'Nama resep harus diisi',
            'nama.string' => 'Nama resep harus berupa huruf',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'waktu_persiapan.required' => 'Waktu persiapan harus diisi',
            'waktu_memasak.required' => 'Waktu memasak harus diisi',
            'kategori_id.required' => 'Kategori harus diisi',
            'pembuat_id.required' => 'Nama Pembuat harus diisi',
            'image.required' => 'Image harus diisi',
            'image.mimes' => 'Image harus berformat jpeg,png,jpg,gif',
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
        $pembuat = Pembuat::all(); // Ambil data pembuat
        return view('resep.edit', compact('resep', 'kategoris', 'pembuat'));
    }

    public function update(Request $request, Resep $resep)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required',
            'waktu_persiapan' => 'required',
            'waktu_memasak' => 'required',
            'kategori_id' => 'required|exists:kategori,id',
            'pembuat_id' => 'required|exists:pembuat,id', // Validasi pembuat_id
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
        ],[
            'nama.required' => 'Nama resep harus diisi',
            'nama.string' => 'Nama resep harus berupa huruf',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'waktu_persiapan.required' => 'Waktu persiapan harus diisi',
            'waktu_memasak.required' => 'Waktu memasak harus diisi',
            'kategori_id.required' => 'Kategori harus diisi',
            'pembuat_id.required' => 'Nama Pembuat harus diisi',
            'image.required' => 'Image harus diisi',
            'image.mimes' => 'Image harus berformat jpeg,png,jpg,gif',
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
