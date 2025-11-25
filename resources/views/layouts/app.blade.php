<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SmartKasir')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
    body {
        background-color: #FFFFFF;
        margin: 0;
        font-family: sans-serif;
    }


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

    .main-content {
        margin-left: 230px;
        padding: 80px 20px 20px;
        z-index: auto !important;
        position: static !important;
    }

    .modal-backdrop {
        z-index: 3000 !important;
    }

    .modal {
        z-index: 4000 !important;
    }

    .modal-content {
        z-index: 5000 !important;
    }

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

    /* Responsive */
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

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">

        <div>
            <div class="logo text-center">
                <img src="{{ asset('images/logo.jpg') }}" width="80" alt="Logo SmartKasir">
                <h5>SmartKasir</h5>
            </div>

            <div class="menu">
                <a href="{{ url('/dashboard') }}">
                    <i class="bi bi-house-door-fill me-2"></i> Dashboard
                </a>

                <a href="{{ url('/barang') }}">
                    <i class="bi bi-box-seam me-2"></i> Kelola Barang
                </a>

                <a href="{{ url('/transaksi') }}">
                    <i class="bi bi-cash-stack me-2"></i> Transaksi
                </a>

                <a href="{{ url('/laporan/barang') }}">
                    <i class="bi bi-clipboard-data me-2"></i> Laporan Barang
                </a>

                <a href="{{ url('/laporan/transaksi') }}">
                    <i class="bi bi-bar-chart-line me-2"></i> Laporan Transaksi
                </a>
            </div>
        </div>

        <button type="button" class="btn-logout" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </button>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-custom px-4">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <span class="toggle-btn" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </span>
            <span class="navbar-brand mb-0 h4">SmartKasir</span>
            <span class="text-white">
                <i class="bi bi-person-fill me-1"></i> Halo, {{ Auth::user()->name ?? 'Kasir' }}
            </span>
        </div>
    </nav>

    <div class="main-content">
        @yield('content')
    </div>

    <!-- Modal Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="bi bi-box-arrow-right" style="font-size: 60px; color:#dc3545"></i>
                    <h5 class="mt-3">Yakin ingin keluar dari akun?</h5>
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