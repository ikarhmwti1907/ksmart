<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            if (!Schema::hasColumn('detail_transaksis', 'nama_barang')) {
                $table->string('nama_barang')->nullable();
            }

            if (!Schema::hasColumn('detail_transaksis', 'harga_barang')) {
                $table->integer('harga_barang')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            if (Schema::hasColumn('detail_transaksis', 'nama_barang')) {
                $table->dropColumn('nama_barang');
            }

            if (Schema::hasColumn('detail_transaksis', 'harga_barang')) {
                $table->dropColumn('harga_barang');
            }
        });
    }
};