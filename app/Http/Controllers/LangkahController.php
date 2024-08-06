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

        $resep = $resepQuery->with('langkah')->get();

        return view('langkah.index', compact('resep'));
    }



    public function create()
    {
        $reseps = Resep::with('langkah')->get();

        // Menyimpan nomor langkah terakhir dari setiap resep
        $lastSteps = [];
        foreach ($reseps as $resep) {
            $lastStepNumber = $resep->langkah->max('nomor') ?? 0;
            $lastSteps[$resep->id] = $lastStepNumber;
        }

        return view('langkah.create', compact('reseps', 'lastSteps'));
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
        $request->validate([
            'resep_id' => 'required|exists:resep,id',
            'steps.*.nomor' => 'required|integer',
            'steps.*.deskripsi' => 'required|string',
        ], [
            'steps.*.nomor.required' => 'Nomor langkah harus diisi.',
            'steps.*.nomor.integer' => 'Nomor langkah harus berupa angka.',
            'steps.*.deskripsi.required' => 'Deskripsi langkah harus diisi.',
        ]);

        $steps = $request->input('steps');
        $resep_id = $request->input('resep_id');

        // Ambil langkah yang ada untuk resep ini
        $existingSteps = Langkah::where('resep_id', $resep_id)
            ->orderBy('nomor')
            ->pluck('nomor')
            ->toArray();

        $maxExistingStep = empty($existingSteps) ? 0 : max($existingSteps);

        foreach ($steps as $step) {
            $expectedStepNumber = $maxExistingStep + 1;

            if ($step['nomor'] != $expectedStepNumber) {
                return redirect()->route('langkah.create')->with('error', 'Langkah harus ditambahkan secara berurutan. Langkah ke-' . $expectedStepNumber . ' harus ditambahkan. Langkah yang Anda masukkan adalah ke-' . $step['nomor'] . '.');
            }

            // Cek jika nomor langkah sudah ada
            if (in_array($step['nomor'], $existingSteps)) {
                return redirect()->route('langkah.create')->with('error', 'Langkah ke-' . $step['nomor'] . ' sudah ada untuk resep ini.');
            }

            $validatedData = [
                'resep_id' => $resep_id,
                'nomor' => $step['nomor'],
                'deskripsi' => $step['deskripsi'],
            ];

            Langkah::create($validatedData);
            $maxExistingStep = $step['nomor']; // Update langkah maksimal yang ada
        }

        return redirect()->route('langkah.index')->with('success', 'Langkah berhasil ditambahkan.');
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

    public function update(Request $request, Langkah $langkah)
    {
        $validatedData = $request->validate([
            'resep_id' => 'required|exists:resep,id',
            'nomor' => 'required|integer',
            'deskripsi' => 'required|string', // Allow deskripsi to be nullable
        ], [
            'nomor.required' => 'Nomor langkah harus diisi.',
            'nomor.integer' => 'Nomor langkah harus berupa angka.',
            'deskripsi.required' => 'Deskripsi langkah harus diisi.',
        ]);

        $resep_id = $request->input('resep_id');

        // Ambil langkah yang ada untuk resep ini, kecuali yang sedang diupdate
        $existingSteps = Langkah::where('resep_id', $resep_id)
            ->where('id', '<>', $langkah->id)
            ->pluck('nomor')
            ->toArray();

        $maxExistingStep = empty($existingSteps) ? 0 : max($existingSteps);

        if ($validatedData['nomor'] > $maxExistingStep + 1) {
            return redirect()->route('langkah.edit', $langkah->id)->with('error', 'Langkah harus ditambahkan secara berurutan. Langkah ke-' . ($maxExistingStep + 1) . ' harus ditambahkan.');
        }

        // Cek jika nomor langkah yang diupdate sudah ada
        if (in_array($validatedData['nomor'], $existingSteps)) {
            return redirect()->route('langkah.edit', $langkah->id)->with('error', 'Langkah ke-' . $validatedData['nomor'] . ' sudah ada untuk resep ini.');
        }

        // Check if deskripsi is empty, if so, restore the previous description
        if (empty($validatedData['deskripsi'])) {
            $validatedData['deskripsi'] = $langkah->deskripsi;
        }

        $langkah->update($validatedData);

        return redirect()->route('langkah.index')->with('success', 'Langkah berhasil diperbarui.');
    }


    public function destroy(Langkah $langkah)
    {
        $langkah->delete();

        return redirect()->route('langkah.index')->with('success', 'Langkah berhasil dihapus.');
    }
}
