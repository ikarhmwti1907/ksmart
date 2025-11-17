<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SmartKasir')</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #FFFFFF;
        margin: 0;
        font-family: sans-serif;
    }

    /* ================== SIDEBAR ================== */
    .sidebar {
        width: 230px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        background-color: #1F3A5F;
        color: white;
        padding-top: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.3s ease-in-out;
        z-index: 1000;
    }

    .sidebar a {
        display: block;
        color: #FFF;
        padding: 10px 20px;
        text-decoration: none;
        font-size: 15px;
        transition: all 0.3s;
    }

    .sidebar a:hover {
        background-color: #F47C20;
        padding-left: 30px;
    }

    /* ================== NAVBAR ================== */
    .navbar-custom {
        background-color: #F47C20;
        position: fixed;
        top: 0;
        left: 230px;
        width: calc(100% - 230px);
        z-index: 900;
    }

    .navbar-brand {
        color: white !important;
        font-weight: bold;
    }

    .toggle-btn {
        display: none;
        font-size: 26px;
        cursor: pointer;
        color: white;
        font-weight: bold;
    }

    /* ================== CONTENT ================== */
    .main-content {
        margin-left: 230px;
        padding: 80px 20px 20px;
        /* FIX: hapus z-index dan position agar modal tidak ketutup */
        z-index: auto !important;
        position: static !important;
    }

    /* ================== FIX MODAL Z-INDEX ================== */
    .modal-backdrop {
        z-index: 3000 !important;
    }

    .modal {
        z-index: 4000 !important;
    }

    .modal-content {
        z-index: 5000 !important;
    }

    /* Logout button */
    .btn-logout {
        background-color: #1F3A5F;
        color: white;
        border: none;
        width: 100%;
        padding: 10px;
        text-align: left;
        transition: all 0.3s;
    }

    .btn-logout:hover {
        background-color: #F47C20;
        padding-left: 25px;
    }

    /* ================== RESPONSIVE ================== */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-230px);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .navbar-custom {
            left: 0;
            width: 100%;
        }

        .main-content {
            margin-left: 0;
        }

        .toggle-btn {
            display: inline-block;
        }
    }
    </style>
</head>

<body>

    <!-- ================== SIDEBAR ================== -->
    <div class="sidebar" id="sidebar">

        <div>
            <div class="logo text-center">
                <img src="{{ asset('images/logo.jpg') }}" width="80" alt="Logo SmartKasir">
                <h5>SmartKasir</h5>
            </div>

            <div class="menu">
                <a href="{{ url('/dashboard') }}">🏠 Dashboard</a>
                <a href="{{ url('/barang') }}">📦 Kelola Barang</a>
                <a href="{{ url('/transaksi') }}">💰 Transaksi</a>
                <a href="{{ url('/laporan/barang') }}">📊 Laporan Barang</a>
                <a href="{{ url('/laporan/transaksi') }}">📈 Laporan Transaksi</a>
                <a href="{{ route('profile') }}">👤 Profil</a>
            </div>
        </div>

        <button type="button" class="btn-logout" data-bs-toggle="modal" data-bs-target="#logoutModal">
            🚪 Logout
        </button>
    </div>

    <!-- ================== NAVBAR ================== -->
    <nav class="navbar navbar-custom px-4">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <span class="toggle-btn" onclick="toggleSidebar()">☰</span>
            <span class="navbar-brand mb-0 h4">SmartKasir</span>
            <span class="text-white">Halo, {{ Auth::user()->name ?? 'Kasir' }}</span>
        </div>
    </nav>

    <!-- ================== MAIN CONTENT ================== -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- ================== LOGOUT MODAL ================== -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/992/992680.png" width="80" class="mb-3">
                    <h5>Yakin ingin keluar dari akun?</h5>
                    <p class="text-muted">Pastikan semua transaksi telah disimpan sebelum logout.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4">Ya, Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>