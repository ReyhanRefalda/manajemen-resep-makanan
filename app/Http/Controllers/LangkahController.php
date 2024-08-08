<?php

namespace App\Http\Controllers;

use App\Models\Langkah;
use App\Models\Resep;
use Illuminate\Http\Request;

class LangkahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $resepQuery = Resep::query();

        if ($search) {
            // Cari resep yang sesuai dengan nama
            $resepQuery->where('nama', 'LIKE', "%{$search}%");
            
        }

        $resep = $resepQuery->with('langkahs')->orderBy('created_at', 'desc')->get();

        return view('langkah.index', compact('resep'));
    }


    public function create(Request $request)
    {
        $resep_id = $request->query('resep_id');
    
        // Ambil data resep berdasarkan id
        $resep = Resep::all(); // Atau sesuaikan dengan query yang sesuai
        $lastSteps = []; // Ambil langkah terakhir untuk setiap resep
    
        // Kirim data ke view
        return view('langkah.create', [
            'resep_id' => $resep_id,
            'resep' => $resep,
            'lastSteps' => $lastSteps
        ]);
    }
    
    
    public function massDestroy(Request $request)
    {
        $ids = $request->input('ids');

        if ($ids) {
            Langkah::whereIn('id', $ids)->delete();
            return redirect()->route('langkah.index')->with('success', 'Langkah terpilih berhasil dihapus.');
        }

        return redirect()->route('langkah.index')->with('error', 'Tidak ada langkah yang dipilih untuk dihapus.');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'resep_id' => 'required|exists:resep,id',
            'langkah.*.deskripsi' => 'required|string',
            'langkah.*.nomor' => 'required|integer',
        ], [
            // Pesan kesalahan kustom jika ada field yang tidak valid
            'resep_id.required' => 'Resep ID harus diisi.',
            'resep_id.exists' => 'Resep ID tidak ditemukan.',
            'langkah.*.deskripsi.required' => 'Deskripsi langkah harus diisi.',
            'langkah.*.deskripsi.string' => 'Deskripsi langkah harus berupa teks.',
            'langkah.*.nomor.required' => 'Nomor langkah harus diisi.',
            'langkah.*.nomor.integer' => 'Nomor langkah harus berupa angka.',
        ]);
    
    
        $resepId = $request->input('resep_id');
        $langkahs = $request->input('langkah', []);
    
        // Hapus langkah yang ada sebelum menyimpan yang baru
        Langkah::where('resep_id', $resepId)->delete();
    
        foreach ($langkahs as $langkah) {
            Langkah::create([
                'resep_id' => $resepId,
                'deskripsi' => $langkah['deskripsi'],
                'nomor' => $langkah['nomor'],
            ]);
        }
    
        // Redirect to the resep.index page with a success message
        return redirect()->route('resep.index')->with('success', 'Langkah berhasil disimpan!');
    }
    
    public function show(Langkah $langkah)
    {
        return view('langkah.show', compact('langkah'));
    }

    public function edit(Langkah $langkah)
    {
        $resep = Resep::all(); // Ambil data resep untuk dropdown
        return view('langkah.edit', compact('langkah', 'resep'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'langkah.*.deskripsi' => 'required|string',
            'langkah.*.nomor' => 'required|integer'
        ]);
    
        $resep = Resep::findOrFail($id);
    
        // Hapus langkah-langkah yang tidak lagi ada di formulir
        $existingLangkahIds = array_keys($request->input('langkah', []));
        $resep->langkahs()->whereNotIn('id', $existingLangkahIds)->delete();
    
        // Perbarui atau tambahkan langkah-langkah baru
        foreach ($request->input('langkah', []) as $langkahId => $data) {
            $langkah = Langkah::find($langkahId);
    
            if ($langkah) {
                $langkah->update($data);
            } else {
                $resep->langkahs()->create($data);
            }
        }
    
        // Redirect to the resep.index page with a success message
        return redirect()->route('resep.index')->with('success', 'Data Resep Berhasil Diperbarui!');
    }
    
    

    public function destroy(Langkah $langkah)
    {
        $langkah->delete();

        return redirect()->route('langkah.index')->with('success', 'Langkah berhasil dihapus.');
    }
}