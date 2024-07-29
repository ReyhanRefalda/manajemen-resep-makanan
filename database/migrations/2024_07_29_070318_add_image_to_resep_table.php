<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToResepTable extends Migration
{
    public function up()
    {
        Schema::table('resep', function (Blueprint $table) {
            $table->string('image')->nullable()->after('kategori_id');
        });
    }

    public function down()
    {
        Schema::table('resep', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
