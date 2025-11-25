@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4 text-left fw-bold text-black">
        <i class="bi bi-house-door-fill me-2"></i> Dashboard <span class="text-dark">SmartKasir</span>
    </h3>

    <!-- Statistik -->
    <div class="row text-center mb-4 g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm py-3 hover-card">
                <div class="card-body">
                    <h6 class="text-secondary mb-1">
                        <i class="bi bi-box-seam me-1"></i> Total Barang
                    </h6>
                    <h3 class="fw-bold text-black">{{ $totalBarang }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm py-3 hover-card">
                <div class="card-body">
                    <h6 class="text-secondary mb-1">
                        <i class="bi bi-receipt-cutoff me-1"></i> Total Transaksi
                    </h6>
                    <h3 class="fw-bold text-black">{{ $totalTransaksi }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm py-3 hover-card">
                <div class="card-body">
                    <h6 class="text-secondary mb-1">
                        <i class="bi bi-cash-stack me-1"></i> Total Pendapatan
                    </h6>
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
                    <i class="bi bi-calendar-week me-2"></i> Pendapatan 7 Hari Terakhir
                </h5>
                <canvas id="pendapatanChart" height="180"></canvas>
            </div>
        </div>

        <!-- Grafik Barang Terlaris  -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="mb-3 text-center text-black fw-semibold">
                    <i class="bi bi-fire me-2"></i> Barang Terjual Terbanyak
                </h5>
                <canvas id="barangChart" height="180"></canvas>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

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