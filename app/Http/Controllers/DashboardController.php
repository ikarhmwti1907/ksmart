<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalBarang = Barang::count();
        $totalTransaksi = Transaksi::count();
        $totalPendapatan = Transaksi::sum('total');

        // Grafik pendapatan 7 hari terakhir
        $transaksiHarian = Transaksi::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total) as total_harian')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'), 'ASC')
            ->limit(7)
            ->get();

        $labels = $transaksiHarian->pluck('tanggal')->toArray();
        $data = $transaksiHarian->pluck('total_harian')->toArray();

        // Barang terlaris (5 besar)
        $barangTerlaris = DetailTransaksi::select(
                'barang_id',
                DB::raw('SUM(jumlah) as total_jual')
            )
            ->groupBy('barang_id')
            ->orderByDesc('total_jual')
            ->limit(5)
            ->with('barang')
            ->get();

        $barangLabels = $barangTerlaris->pluck('barang.nama_barang')->toArray();
        $barangData = $barangTerlaris->pluck('total_jual')->toArray();

        return view('dashboard', compact(
            'totalBarang',
            'totalTransaksi',
            'totalPendapatan',
            'labels',
            'data',
            'barangLabels',
            'barangData'
        ));
    }
}