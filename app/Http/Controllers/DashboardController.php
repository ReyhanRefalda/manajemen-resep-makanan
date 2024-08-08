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
                // Pisahkan kata-kata pencarian
                $searchTerms = explode(' ', $search);

                // Menambahkan kondisi pencarian untuk setiap kata
                $query->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->where(function ($query) use ($term) {
                            $query->where('nama', 'like', '%' . $term . '%')
                                ->orWhereHas('bahans', function ($query) use ($term) {
                                    $query->where('nama', 'like', '%' . $term . '%');
                                });
                        });
                    }
                });
            })
            ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan waktu pembuatan terbaru
            ->get();

        return view('dashboard', compact('reseps', 'search'));
    }
}
