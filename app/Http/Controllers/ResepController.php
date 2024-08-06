<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Pembuat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ResepController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $reseps = Resep::with('bahans', 'pembuat', 'kategori')
            ->where('nama', 'like', '%' . $search . '%')
            ->get();

        return view('resep.index', compact('reseps'));
    }

    public function dashboard()
    {
        $reseps = Resep::with('kategori', 'pembuat')->get();

        return view('dashboard', compact('reseps'));
    }

    public function create()
    {
        $reseps = Resep::all();
        $bahans = Bahan::all();
        $kategoris = Kategori::all();
        $pembuat = Pembuat::all();
        $lastSteps = Resep::withCount('langkah')->get()->mapWithKeys(function ($resep) {
            return [$resep->id => $resep->langkahs_count];
        });
    
        return view('resep.create', compact('reseps', 'bahans', 'kategoris', 'pembuat', 'lastSteps'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255|unique:resep,nama,NULL,id,pembuat_id,' . $request->pembuat_id,
            'deskripsi' => 'required|string',
            'waktu_persiapan' => 'required|string',
            'waktu_memasak' => 'required|string',
            'pembuat_id' => 'required|exists:pembuat,id',
            'kategori_id' => 'required|exists:kategori,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bahan.*' => 'exists:bahan,id',
            'jumlah.*' => 'nullable|string', 
        ], [
            'nama.required' => 'Nama resep harus diisi.',
            'nama.string' => 'Nama resep harus berupa string.',
            'nama.max' => 'Nama resep maksimal 255 karakter.',
            'nama.unique' => 'Nama resep sudah ada untuk pembuat ini.',
            'deskripsi.required' => 'Deskripsi resep harus diisi.',
            'deskripsi.string' => 'Deskripsi resep harus berupa string.',
            'waktu_persiapan.string' => 'Waktu persiapan harus berupa string.',
            'waktu_persiapan.required' => 'Waktu persiapan harus diisi.',
            'waktu_memasak.string' => 'Waktu memasak harus berupa string.',
            'waktu_memasak.required' => 'Waktu memasak harus diisi.',
            'pembuat_id.required' => 'pembuat harus diisi.',
            'pembuat_id.exists' => 'pembuat tidak ditemukan.',
            'kategori_id.required' => 'kategori harus diisi.',
            'kategori_id.exists' => 'kategori tidak ditemukan.',
            'image.required' => 'Gambar harus diisi',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan adalah jpeg, png, jpg, dan gif.',
            'image.max' => 'Ukuran gambar maksimal 2048 kilobyte (2 MB).',
            'bahan.*.exists' => 'bahan tidak ditemukan.',
            'jumlah.*.string' => 'Jumlah harus berupa string jika diisi.',
        ]);

        $resep = Resep::create($validatedData);

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $resep->image = $imagePath;
            $resep->save();
        }

        // Handle many-to-many relation for bahan
        $bahanIds = $request->input('bahan', []);
        $jumlah = $request->input('jumlah', []);

        foreach ($bahanIds as $bahanId) {
            $resep->bahans()->attach($bahanId, ['jumlah' => $jumlah[$bahanId] ?? '']); // Save jumlah as string
        }

        return redirect()->route('resep.index')->with('success', 'Resep berhasil dibuat.');
    }



    public function show(Resep $resep)
    {
        return view('resep.show', compact('resep'));
    }
    public function edit(Resep $resep)
    {
        $kategoris = Kategori::all();
        $pembuat = Pembuat::all();
        $bahans = Bahan::all();

        return view('resep.edit', compact('resep', 'kategoris', 'pembuat', 'bahans'));
    }


    public function update(Request $request, Resep $resep)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255|unique:resep,nama,NULL,id,pembuat_id,' . $request->pembuat_id,
            'deskripsi' => 'required|string',
            'waktu_persiapan' => 'required|string',
            'waktu_memasak' => 'required|string',
            'pembuat_id' => 'required|exists:pembuat,id',
            'kategori_id' => 'required|exists:kategori,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bahan.*' => 'exists:bahan,id',
            'jumlah.*' => 'nullable|string', // Update validation rule to nullable string
        ], [
            'nama.required' => 'Nama resep harus diisi.',
            'nama.string' => 'Nama resep harus berupa string.',
            'nama.max' => 'Nama resep maksimal 255 karakter.',
            'nama.unique' => 'Nama resep sudah ada untuk pembuat ini.',
            'deskripsi.required' => 'Deskripsi resep harus diisi.',
            'deskripsi.string' => 'Deskripsi resep harus berupa string.',
            'waktu_persiapan.string' => 'Waktu persiapan harus berupa string.',
            'waktu_persiapan.required' => 'Waktu persiapan harus diisi.',
            'waktu_memasak.string' => 'Waktu memasak harus berupa string.',
            'waktu_memasak.required' => 'Waktu memasak harus diisi.',
            'pembuat_id.required' => 'pembuat harus diisi.',
            'pembuat_id.exists' => 'pembuat tidak ditemukan.',
            'kategori_id.required' => 'kategori harus diisi.',
            'kategori_id.exists' => 'kategori tidak ditemukan.',
            'image.required' => 'Gambar harus diisi',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan adalah jpeg, png, jpg, dan gif.',
            'image.max' => 'Ukuran gambar maksimal 2048 kilobyte (2 MB).',
            'bahan.*.exists' => 'bahan tidak ditemukan.',
            'jumlah.*.string' => 'Jumlah harus berupa string jika diisi.',
        ]);

        if ($request->hasFile('image')) {
            if ($resep->image) {
                Storage::delete('public/' . $resep->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $resep->update($validatedData);

        // Update many-to-many relation for bahan
        $bahanIds = $request->input('bahan', []);
        $jumlah = $request->input('jumlah', []);

        $resep->bahans()->sync([]);
        foreach ($bahanIds as $bahanId) {
            $resep->bahans()->attach($bahanId, ['jumlah' => $jumlah[$bahanId] ?? '']); // Save jumlah as string
        }

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
