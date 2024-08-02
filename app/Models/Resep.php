<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'resep';

    // Atribut yang dapat diisi
    protected $fillable = [
        'nama',
        'deskripsi',
        'waktu_persiapan',
        'waktu_memasak',
        'kategori_id',
        'pembuat_id',
        'image',
    ];

    // Relasi dengan Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi dengan Pembuat
    public function pembuat()
    {
        return $this->belongsTo(Pembuat::class, 'pembuat_id');
    }

    // Relasi dengan Bahan (banyak ke banyak)
    public function bahans()
    {
        return $this->belongsToMany(Bahan::class, 'resep_bahan')->withPivot('jumlah');
    }

    // Relasi dengan Langkah (misalnya banyak ke banyak, pastikan sesuai dengan struktur tabel)
    public function langkah()
    {
        return $this->hasMany(Langkah::class);
    }
}
