<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResepBahanTable extends Migration
{
    public function up()
    {
        Schema::create('resep_bahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resep_id')->constrained('resep')->onDelete('cascade');
            $table->foreignId('bahan_id')->constrained('bahan')->onDelete('cascade');
            $table->string('jumlah');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resep_bahan');
    }
}
