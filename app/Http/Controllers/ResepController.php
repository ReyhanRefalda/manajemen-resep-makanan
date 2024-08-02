<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Pembuat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $kategoris = Kategori::all();
        $pembuat = Pembuat::all();
        $bahans = Bahan::all();

        return view('resep.create', compact('kategoris', 'pembuat', 'bahans'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_persiapan' => 'nullable|string',
            'waktu_memasak' => 'nullable|string',
            'pembuat_id' => 'required|exists:pembuat,id',
            'kategori_id' => 'required|exists:kategori,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bahan.*' => 'exists:bahan,id',
            'jumlah.*' => 'numeric|min:1',
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
            $resep->bahans()->attach($bahanId, ['jumlah' => $jumlah[$bahanId] ?? 1]);
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
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_persiapan' => 'nullable|string',
            'waktu_memasak' => 'nullable|string',
            'kategori_id' => 'required|exists:kategori,id',
            'pembuat_id' => 'required|exists:pembuat,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bahan.*' => 'exists:bahan,id',
            'jumlah.*' => 'numeric|min:1',
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
            $resep->bahans()->attach($bahanId, ['jumlah' => $jumlah[$bahanId] ?? 1]);
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
