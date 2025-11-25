<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class TransaksiController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        $transaksis = Transaksi::with('details.barang')->latest()->get();
        return view('transaksi.index', compact('barangs', 'transaksis'));
    }

    public function store(Request $request)
{
    $request->validate([
        'barang_id' => 'required|array|min:1',
        'barang_id.*' => 'exists:barangs,id',
        'jumlah' => 'required|array|min:1',
        'jumlah.*' => 'integer|min:1',
        'bayar' => 'nullable|numeric|min:0',
    ]);

    // Hitung total terlebih dahulu
    $total = 0;
    foreach ($request->barang_id as $i => $barangId) {
        $barang = Barang::findOrFail($barangId);
        $subtotal = $barang->harga * $request->jumlah[$i];
        $total += $subtotal;
    }

    // Jika bayar belum diinput, jangan proses transaksi
    if ($request->bayar === null) {
        return redirect()->back()->with('error', 'Masukkan nominal bayar terlebih dahulu!');
    }

    // Hitung kembalian
    $bayar = $request->bayar;
    $kembalian = $bayar - $total;

    DB::beginTransaction();
    try {
        // Simpan transaksi
        $transaksi = Transaksi::create([
            'tanggal' => now(),
            'total' => $total,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
        ]);

        // Simpan detail + kurangi stok
        foreach ($request->barang_id as $i => $barangId) {
            $barang = Barang::findOrFail($barangId);
            $jumlah = $request->jumlah[$i];

            DetailTransaksi::create([
    'transaksi_id' => $transaksi->id,
    'barang_id'    => $barang->id,
    'nama_barang'  => $barang->nama_barang,   
    'harga_barang' => $barang->harga,         
    'jumlah'       => $jumlah,
    'subtotal'     => $jumlah * $barang->harga
]);


            $barang->decrement('stok', $jumlah);
        }

        DB::commit();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Gagal menyimpan transaksi: '.$e->getMessage());
    }
}

}