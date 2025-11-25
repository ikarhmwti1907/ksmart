@extends('layouts.app')
@section('title', 'Tambah Barang')

@section('content')
<div class="container mt-3">

    <h3 class="mb-4">
        <i class="bi bi-plus-circle me-2"></i> Tambah Barang
    </h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('barang.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Stok</label>
                    <input type="number" name="stok" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-1"></i> Simpan
                </button>

                <a href="{{ route('barang.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                </a>
            </form>

        </div>
    </div>

</div>
@endsection