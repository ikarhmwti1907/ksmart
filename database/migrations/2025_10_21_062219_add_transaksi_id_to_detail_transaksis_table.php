<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    // Kosongkan karena tabel sudah ada
}

public function down(): void
{
    Schema::dropIfExists('detail_transaksis');
}

};