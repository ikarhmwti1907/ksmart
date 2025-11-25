@extends('layouts.app')
@section('title', 'Data Barang')

@section('content')

<div class="container mt-3">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-black mb-0">
            <i class="bi bi-box-seam me-2"></i> Data Barang
        </h3>

        <a href="{{ route('barang.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Barang
        </a>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
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
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <button class="btn btn-danger btn-sm btn-hapus" data-id="{{ $barang->id }}"
                                data-nama="{{ $barang->nama_barang }}" data-bs-toggle="modal"
                                data-bs-target="#hapusModal">
                                <i class="bi bi-trash3"></i>
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

<!-- Modal Hapus -->
<div class="modal fade" id="hapusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">

            <!-- HEADER -->
            <div class="modal-header" style="background:#dc3545; color:white;">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">

                <i class="bi bi-trash3-fill text-danger" style="font-size: 60px;"></i>

                <h5 class="mt-3">Yakin ingin menghapus barang ini?</h5>
                <p id="namaBarangHapus" class="text-muted mb-0"></p>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer justify-content-center">
                <button class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>

                <form method="POST" id="formHapus">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger px-4">
                        <i class="bi bi-trash3-fill me-1"></i> Ya, Hapus
                    </button>
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