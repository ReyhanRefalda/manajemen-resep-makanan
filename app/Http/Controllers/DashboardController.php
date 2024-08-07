<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Resep;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $reseps = Resep::with('kategori', 'pembuat', 'bahans')
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', '%' . $search . '%')
                             ->orWhereHas('bahans', function($query) use ($search) {
                                 $query->where('nama', 'like', '%' . $search . '%');
                             });
            })
            ->get();

        return view('dashboard', compact('reseps', 'search'));
    }
}
