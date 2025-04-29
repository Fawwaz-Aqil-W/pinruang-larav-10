<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('ruangan', function (Blueprint $table) {
        $table->string('fasilitas')->nullable();
        $table->text('deskripsi')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('ruangan', function (Blueprint $table) {
        $table->dropColumn(['fasilitas', 'deskripsi']);
    });
}
};
