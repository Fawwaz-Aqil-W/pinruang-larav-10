php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Then add them back with new names
            $table->timestamp('disetujui_pada')->nullable();
            $table->unsignedBigInteger('disetujui_oleh')->nullable();
            $table->timestamp('ditolak_pada')->nullable();
            $table->unsignedBigInteger('ditolak_oleh')->nullable();
            $table->string('alasan_ditolak')->nullable();
        });
    }

    public function down()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // First drop the new columns
            $table->dropColumn([
                'disetujui_pada',
                'disetujui_oleh',
                'ditolak_pada',
                'ditolak_oleh',
                'alasan_ditolak'
            ]);
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            // Then add back the original columns
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->string('reject_reason')->nullable();
        });
    }
};