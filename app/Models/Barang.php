<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model {
    use HasFactory;
    protected $fillable = ['nama_barang', 'stok', 'harga', 'kategori'];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}