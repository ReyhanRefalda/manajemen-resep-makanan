<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;

    protected $table = 'bahan';

    protected $fillable = [
        'nama',
    ];

    public function resep()
    {
        return $this->belongsToMany(Resep::class, 'resep_bahan');
    }
}
