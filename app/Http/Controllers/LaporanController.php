<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Transaksi;

class LaporanController extends Controller {
    public function laporanBarang() {
        $barangs = Barang::all();
        return view('laporan.barang', compact('barangs'));
    }

    public function transaksi()
{
    $data = \App\Models\Transaksi::orderBy('created_at','DESC')->get();
    return view('laporan.transaksi', compact('data'));
}



}