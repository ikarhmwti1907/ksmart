@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-left fw-bold text-black">
        📊 Dashboard <span class="text-dark">SmartKasir</span>
    </h3>

    <!-- Statistik -->
    <div class="row text-center mb-4 g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm py-3 hover-card">
                <div class="card-body">
                    <h6 class="text-secondary mb-1">Total Barang</h6>
                    <h3 class="fw-bold text-black">{{ $totalBarang }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm py-3 hover-card">
                <div class="card-body">
                    <h6 class="text-secondary mb-1">Total Transaksi</h6>
                    <h3 class="fw-bold text-black">{{ $totalTransaksi }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm py-3 hover-card">
                <div class="card-body">
                    <h6 class="text-secondary mb-1">Total Pendapatan</h6>
                    <h3 class="fw-bold text-black">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="row g-4">
        <!-- Grafik Pendapatan Harian  -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="mb-3 text-center text-black fw-semibold">
                    📅 Pendapatan 7 Hari Terakhir
                </h5>
                <canvas id="pendapatanChart" height="180"></canvas>
            </div>
        </div>

        <!-- Grafik Barang Terlaris  -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="mb-3 text-center text-black fw-semibold">
                    🔥 Barang Terjual Terbanyak
                </h5>
                <canvas id="barangChart" height="180"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Efek CSS 
    const style = document.createElement('style');
    style.innerHTML = `
        #pendapatanChart, #barangChart {
            opacity: 0;
            transition: all 1s ease;
            transform: scale(0.95);
            filter: drop-shadow(0 0 0px rgba(0,0,0,0.2));
        }
        #pendapatanChart.active, #barangChart.active {
            opacity: 1;
            transform: scale(1);
            filter: drop-shadow(0 6px 12px rgba(0,0,0,0.15));
        }
    `;
    document.head.appendChild(style);

    // Bar Chart
    const ctxPendapatan = document.getElementById('pendapatanChart');
    const pendapatanChart = new Chart(ctxPendapatan, {
        type: 'bar',
        data: {
            labels: @json($labels ?? []),
            datasets: [{
                label: 'Total Pendapatan (Rp)',
                data: @json($data ?? []),
                backgroundColor: 'rgba(54, 162, 235, 0.9)',
                borderRadius: 8
            }]
        },
        options: {
            animation: {
                duration: 1800,
                easing: 'easeOutBounce',
                onComplete: () => ctxPendapatan.classList.add('active')
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString('id-ID')
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                },
                legend: {
                    display: false
                }
            }
        }
    });

    // Doughnut Chart
    const ctxBarang = document.getElementById('barangChart');
    const barangChart = new Chart(ctxBarang, {
        type: 'doughnut',
        data: {
            labels: @json($barangLabels ?? []),
            datasets: [{
                label: 'Jumlah Terjual',
                data: @json($barangData ?? []),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                ],
                borderWidth: 2
            }]
        },
        options: {
            rotation: 0,
            cutout: '65%',
            animation: {
                duration: 2200,
                easing: 'easeInOutElastic',
                animateRotate: true,
                animateScale: true,
                onComplete: () => ctxBarang.classList.add('active')
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: ${ctx.parsed} terjual`
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>


<style>
.hover-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.hover-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}
</style>
@endsection