@extends('layouts.app')

@section('title', 'Profil Kasir')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold text-black mb-4">👤 Profil Kasir</h3>

    <!-- Kartu Profil -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex align-items-center flex-wrap">

            <!-- Foto Profil -->
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                class="rounded-circle border border-2 border-secondary me-4 mb-3 mb-md-0" alt="Foto Profil" width="90"
                height="90">

            <div>
                <h5 class="fw-bold mb-1 text-black">{{ $user->name ?? '-' }}</h5>
                <p class="text-muted mb-2"><i class="bi bi-envelope-fill"></i> {{ $user->email ?? '-' }}</p>
                <span class="badge bg-primary">Kasir Aktif</span>
            </div>
        </div>
    </div>

    <!-- Ubah Password -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-semibold mb-3 text-black">🔒 Ubah Password</h5>

            <!-- Notifikasi -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                ✅ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                ⚠️ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('profile.updatePassword') }}" method="POST" class="mt-3">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password Lama</label>
                    <input type="password" name="current_password" class="form-control shadow-sm" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password Baru</label>
                    <input type="password" name="new_password" class="form-control shadow-sm" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="form-control shadow-sm" required>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary shadow-sm px-4">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
.card {
    border-radius: 10px;
}

.btn-primary {
    background-color: #1b3b63;
    border: none;
}

.btn-primary:hover {
    background-color: #163250;
}

.form-control:focus {
    border-color: #1b3b63;
    box-shadow: 0 0 0 0.2rem rgba(27, 59, 99, 0.25);
}
</style>
@endsection