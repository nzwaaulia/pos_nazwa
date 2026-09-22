<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            // Menambahkan kolom bayar/uang diterima dan kembali
            $table->decimal('bayar', 15, 2)->nullable()->after('total_pembayaran');
            $table->decimal('kembali', 15, 2)->nullable()->after('bayar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn(['bayar', 'kembali']);
        });
    }
};