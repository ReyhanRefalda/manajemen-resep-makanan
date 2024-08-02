<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;

    protected $table = 'bahan'; // Nama tabel yang benar

    protected $fillable = [
        'nama',
    ];

    public function reseps()
    {
        return $this->belongsToMany(Resep::class, 'resep_bahan')->withPivot('jumlah');
    }
}
