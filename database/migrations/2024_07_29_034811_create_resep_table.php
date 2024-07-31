<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResepTable extends Migration
{
    public function up()
    {
        Schema::create('resep', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi');
            $table->integer('waktu_persiapan');
            $table->integer('waktu_memasak');
            $table->foreignId('kategori_id')->constrained('kategori');
            $table->foreignId('pembuat_id')->constrained('pembuat'); // Tambahkan ini
            $table->string('image')->nullable(); // Jika ada kolom image
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resep');
    }
}

