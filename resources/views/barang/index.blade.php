@extends('layouts.app')
@section('title', 'Data Barang')

@section('content')

<div class="container mt-3">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-black mb-0">📦 Data Barang</h3>
        <a href="{{ route('barang.create') }}" class="btn btn-primary shadow-sm">➕ Tambah Barang</a>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm">
        ✅ {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Tabel -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($barangs as $barang)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-start">{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->stok }}</td>
                        <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm">✏️</a>

                            <button class="btn btn-danger btn-sm btn-hapus" data-id="{{ $barang->id }}"
                                data-nama="{{ $barang->nama_barang }}" data-bs-toggle="modal"
                                data-bs-target="#hapusModal">
                                🗑️
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-muted py-3">Tidak ada data barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ===================== MODAL HAPUS (DESAIN PREMIUM) ===================== -->
<div class="modal fade" id="hapusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">

            <!-- HEADER -->
            <div class="modal-header" style="background:#dc3545; color:white;">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/484/484611.png" width="85" class="mb-3"
                    style="filter: drop-shadow(0 0 2px rgba(0,0,0,0.2));">

                <h5>Yakin ingin menghapus barang ini?</h5>
                <p id="namaBarangHapus" class="text-muted mb-0"></p>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer justify-content-center">
                <button class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>

                <form method="POST" id="formHapus">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger px-4">Ya, Hapus</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const hapusButtons = document.querySelectorAll(".btn-hapus");
    const namaBarangHapus = document.getElementById("namaBarangHapus");
    const formHapus = document.getElementById("formHapus");

    hapusButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            let id = this.dataset.id;
            let nama = this.dataset.nama;

            namaBarangHapus.innerHTML = "<strong>" + nama + "</strong>";
            formHapus.action = "/barang/" + id;
        });
    });
});
</script>

@endsection