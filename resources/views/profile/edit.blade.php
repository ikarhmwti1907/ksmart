@extends('layouts.app')

@section('title', 'Profil Kasir')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold text-black mb-4">👤 Profil Kasir</h3>

    <div class="row g-4">

        <!-- Update Profile Information -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-semibold text-black mb-3">📝 Informasi Profil</h5>

                    <div class="mt-3">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Password -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-semibold text-black mb-3">🔒 Ubah Password</h5>

                    <div class="mt-3">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-semibold text-black mb-3 text-danger">⚠️ Hapus Akun</h5>

                    <div class="mt-3">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
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