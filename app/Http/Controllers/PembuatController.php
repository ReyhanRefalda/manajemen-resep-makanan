<?php

namespace App\Http\Controllers;

use App\Models\Pembuat;
use Illuminate\Http\Request;

class PembuatController extends Controller
{
    public function index()
    {
        $pembuat = Pembuat::all();
        return view('pembuat.index', compact('pembuat'));
    }

    public function create()
    {
        return view('pembuat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        Pembuat::create($request->all());

        return redirect()->route('pembuat.index')->with('success', 'Pembuat berhasil dibuat.');
    }

    public function show($id)
    {
        $pembuat = Pembuat::findOrFail($id);
        return view('pembuat.show', compact('pembuat'));
    }

    public function edit($id)
    {
        $pembuat = Pembuat::findOrFail($id);
        return view('pembuat.edit', compact('pembuat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $pembuat = Pembuat::findOrFail($id);
        $pembuat->update($request->all());

        return redirect()->route('pembuat.index')->with('success', 'Pembuat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pembuat = Pembuat::findOrFail($id);
        $pembuat->delete();

        return redirect()->route('pembuat.index')->with('success', 'Pembuat berhasil dihapus.');
    }
}
