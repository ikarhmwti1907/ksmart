@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3 text-left">📄 Laporan Transaksi</h3>
    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Bayar</th>
                            <th>Kembalian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
                            <td class="fw-semibold text-dark">Rp {{ number_format($row->total, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($row->bayar, 0, ',', '.') }}</td>
                            <td class="fw-semibold text-dark">Rp {{ number_format($row->kembalian, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection