<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    protected $table = 'resep';

    protected $fillable = [
        'nama',
        'deskripsi',
        'waktu_persiapan',
        'waktu_memasak',
        'kategori_id',
        'pembuat_id',
        'image',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function bahan()
    {
        return $this->belongsToMany(Bahan::class, 'resep_bahan');
    }

    public function langkah()
    {
        return $this->hasMany(Langkah::class);
    }

    public function pembuat()
    {
        return $this->belongsTo(Pembuat::class, 'pembuat_id');
    }
}
