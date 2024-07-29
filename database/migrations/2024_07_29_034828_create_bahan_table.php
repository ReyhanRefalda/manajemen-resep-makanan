<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanTable extends Migration
{
    public function up()
    {
        Schema::create('bahan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jumlah');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bahan');
    }
}
