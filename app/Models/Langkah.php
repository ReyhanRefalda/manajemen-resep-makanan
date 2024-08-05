<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Langkah extends Model
{
    use HasFactory;

    protected $table = 'langkah';
    protected $fillable = [
        'resep_id',
        'nomor',
        'deskripsi',
    ];

    public function resep()
    {
        return $this->belongsTo(Resep::class);
    }
}