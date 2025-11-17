<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    // 🔍 PENCARIAN BARANG (WAJIB ADA & WAJIB JSON)
   public function search(Request $request)
{
    $keyword = $request->keyword;

    // Pastikan nama kolom sesuai dengan database kamu:
    // nama_barang, harga, stok
    $barang = Barang::where('nama_barang', 'LIKE', "%{$keyword}%")
        ->get(['id', 'nama_barang', 'harga', 'stok']);

    // Ubah nama_barang → nama (agar cocok dengan JS kamu)
    $barang = $barang->map(function($b){
        return [
            'id' => $b->id,
            'nama' => $b->nama_barang, 
            'harga' => $b->harga,
            'stok' => $b->stok
        ];
    });

    return response()->json($barang);
}

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'stok'        => 'required|integer',
            'harga'       => 'required|integer',
        ]);

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'stok'        => $request->stok,
            'harga'       => $request->harga,
            'kategori'    => 'Umum',
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        Barang::destroy($id);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}