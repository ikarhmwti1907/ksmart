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
    Schema::table('detail_transaksis', function (Blueprint $table) {

        // Hapus cascade (HARUS)
        $table->dropForeign(['barang_id']);

        // Tambahkan foreign key tanpa cascade
        $table->foreign('barang_id')->references('id')->on('barangs');

        // Tambahkan snapshot agar nama barang tidak hilang
        $table->string('nama_barang')->after('barang_id');
        $table->decimal('harga_barang', 12, 2)->after('nama_barang');
    });
}

};