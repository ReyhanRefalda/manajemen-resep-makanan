<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembuat extends Model
{
    use HasFactory;

    protected $table = 'pembuat';

    protected $fillable = [
        'nama',
        'email',
    ];

    public function reseps()
    {
        return $this->hasMany(Resep::class, 'pembuat_id');
    }
}
