<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLangkahTable extends Migration
{
    public function up()
    {
        Schema::create('langkah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resep_id')->constrained('resep')->onDelete('cascade');
            $table->integer('nomor');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('langkah');
    }
}
