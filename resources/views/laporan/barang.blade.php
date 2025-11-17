@extends('layouts.app')
@section('title', 'Laporan Data Barang')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3 text-left">📄 Laporan Data Barang</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <!-- Wrapper agar tabel bisa scroll di HP -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangs as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>{{ $b->stok }}</td>
                            <td class="text-dark fw-semibold">
                                Rp {{ number_format($b->harga, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END table-responsive -->

        </div>
    </div>
</div>
@endsection