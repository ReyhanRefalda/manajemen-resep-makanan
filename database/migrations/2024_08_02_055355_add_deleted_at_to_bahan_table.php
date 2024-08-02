<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToBahanTable extends Migration
{
    public function up()
    {
        Schema::table('bahan', function (Blueprint $table) {
            $table->timestamp('deleted_at')->nullable(); // Tambahkan kolom ini
        });
    }

    public function down()
    {
        Schema::table('bahan', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
