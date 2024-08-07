<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToLangkahTable extends Migration
{
    public function up()
    {
        Schema::table('langkah', function (Blueprint $table) {
            $table->foreign('resep_id')->references('id')->on('resep')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('langkah', function (Blueprint $table) {
            $table->dropForeign(['resep_id']);
        });
    }
}
