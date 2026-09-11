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
            // Menambahkan kolom bayar dan kembali setelah kolom total_pembayaran
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
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn(['bayar', 'kembali']);
        });
    }
};