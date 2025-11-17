<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SmartKasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="card shadow p-4" style="width:360px;">
        <h5 class="text-center mb-3 fw-bold">🔑 Lupa Password</h5>

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('forgot.password.send') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Masukkan Email Anda</label>
                <input type="email" name="email" class="form-control" required placeholder="contoh@email.com">
            </div>
            <button type="submit" class="btn btn-primary w-100">Kirim Tautan Reset</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ url('/login') }}" class="text-decoration-none">⬅️ Kembali ke Login</a>
        </div>
    </div>
</body>

</html>