@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 text-left">
        <i class="bi bi-cash-stack me-2"></i> Transaksi Penjualan
    </h2>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
    </div>
    @endif


    <!--Form Transaksi -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-dark text-white fw-semibold">
            <i class="bi bi-pencil-square me-1"></i> Input Transaksi
        </div>

        <div class="card-body">

            <button type="button" id="tambahBarang" class="btn btn-secondary mb-3">
                <i class="bi bi-plus-circle me-1"></i> Tambah Barang
            </button>

            <form action="{{ route('transaksi.store') }}" method="POST" id="formTransaksi">
                @csrf

                <table class="table table-bordered text-center align-middle" id="tabelBarang">
                    <thead class="table-primary">
                        <tr>
                            <th>Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td style="width: 300px; position: relative;">
                                <input type="text" name="nama_barang[]" class="form-control nama-barang"
                                    placeholder="Ketik nama barang..." autocomplete="off">

                                <div class="hasil-pencarian"></div>

                                <input type="hidden" name="barang_id[]" class="barang-id">
                                <input type="hidden" name="stok[]" class="stok-barang">
                            </td>

                            <td class="harga fw-semibold text-black" data-harga="0">Rp 0</td>

                            <td>
                                <input type="number" min="1" name="jumlah[]" class="form-control jumlah text-center"
                                    value="1">
                            </td>

                            <td class="subtotal fw-semibold text-black">Rp 0</td>

                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm hapus-baris">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mb-3">
                    <label class="fw-semibold">Total (Rp)</label>
                    <input type="text" id="total" name="total" class="form-control fw-bold text-dark" readonly>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Bayar (Rp)</label>
                    <input type="number" id="bayar" name="bayar" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Kembalian (Rp)</label>
                    <input type="text" id="kembalian" class="form-control fw-bold text-dark" readonly>
                </div>

                <button class="btn btn-success" type="submit">
                    <i class="bi bi-save me-1"></i> Simpan Transaksi
                </button>
            </form>

        </div>
    </div>

    <!-- Riwayat Transaksi -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-semibold">
            <i class="bi bi-receipt-cutoff me-1"></i> Riwayat Transaksi
        </div>

        <div class="card-body">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transaksis as $t)
                    <tr>
                        <td>{{ $t->tanggal }}</td>
                        <td class="fw-semibold text-dark">Rp {{ number_format($t->total) }}</td>
                        <td>Rp {{ number_format($t->bayar) }}</td>
                        <td class="fw-semibold text-dark">Rp {{ number_format($t->kembalian) }}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>


<!--Modal Uang Kurang -->
<div class="modal fade" id="modalUangKurang" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-x-circle-fill me-1"></i> Uang Kurang
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-1">Pembayaran tidak mencukupi untuk total transaksi.</p>
                <p class="fw-bold text-danger">Transaksi tidak dapat disimpan.</p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<style>
.hasil-pencarian {
    position: absolute;
    top: 45px;
    left: 0;
    width: 100%;
    background: white;
    border: 1px solid #e3e3e3;
    border-radius: 6px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    max-height: 260px;
    overflow-y: auto;
    display: none;
}

.list-group-item {
    padding: 10px 14px;
}

.list-group-item:hover {
    background: #f5faff;
}

.disabled-item {
    background: #eee !important;
    color: #888 !important;
    cursor: not-allowed !important;
}

.disabled-item:hover {
    background: #eee !important;
}
</style>


<script>
document.addEventListener("DOMContentLoaded", () => {

    const formatRupiah = (x) => "Rp " + new Intl.NumberFormat("id-ID").format(x);
    const getNum = (v) => parseInt(String(v).replace(/\D/g, "")) || 0;

    const hitungTotal = () => {
        let total = 0;

        document.querySelectorAll("#tabelBarang tbody tr").forEach(tr => {
            let harga = parseInt(tr.querySelector(".harga").dataset.harga || 0);
            let jumlah = parseInt(tr.querySelector(".jumlah").value || 0);

            let subtotal = harga * jumlah;
            tr.querySelector(".subtotal").textContent = formatRupiah(subtotal);

            total += subtotal;
        });

        document.getElementById("total").value = formatRupiah(total);

        let bayar = getNum(document.getElementById("bayar").value);
        document.getElementById("kembalian").value = formatRupiah(bayar - total);
    };


    /* Cari Barang */
    document.addEventListener("input", function(e) {
        if (!e.target.classList.contains("nama-barang")) return;

        let tr = e.target.closest("tr");
        let keyword = e.target.value.trim();
        let box = tr.querySelector(".hasil-pencarian");

        if (keyword.length < 1) {
            box.style.display = "none";
            return;
        }

        fetch(`/barang/search?keyword=${encodeURIComponent(keyword)}`)
            .then(res => res.json())
            .then(data => {
                if (!data.length) {
                    box.innerHTML =
                        `<div class="p-2 text-danger text-center">Barang tidak ditemukan</div>`;
                    box.style.display = "block";
                    return;
                }

                let html = `<div class="list-group">`;

                data.forEach(b => {
                    let disableClass = b.stok <= 0 ? "disabled-item" : "";

                    html += `
                        <button type="button"
                            class="list-group-item pilih-barang ${disableClass}"
                            data-id="${b.id}"
                            data-nama="${b.nama}"
                            data-harga="${b.harga}"
                            data-stok="${b.stok}">
                            <b>${b.nama}</b><br>
                            Harga: Rp ${new Intl.NumberFormat("id-ID").format(b.harga)}<br>
                            Stok: ${b.stok <= 0 ? "<span class='text-danger fw-bold'>HABIS</span>" : b.stok}
                        </button>
                    `;
                });

                html += "</div>";
                box.innerHTML = html;
                box.style.display = "block";
            });
    });


    /* Pilih Barang */
    document.addEventListener("click", e => {
        let btn = e.target.closest(".pilih-barang");
        if (!btn) return;

        if (btn.classList.contains("disabled-item")) return;

        let tr = btn.closest("tr");

        tr.querySelector(".nama-barang").value = btn.dataset.nama;
        tr.querySelector(".barang-id").value = btn.dataset.id;
        tr.querySelector(".stok-barang").value = btn.dataset.stok;

        tr.querySelector(".harga").dataset.harga = btn.dataset.harga;
        tr.querySelector(".harga").textContent = formatRupiah(btn.dataset.harga);

        tr.querySelector(".jumlah").value = 1;

        tr.querySelector(".hasil-pencarian").style.display = "none";

        hitungTotal();
    });

    document.addEventListener("click", e => {
        document.querySelectorAll(".hasil-pencarian").forEach(box => {
            if (!box.contains(e.target) && !e.target.classList.contains("nama-barang")) {
                box.style.display = "none";
            }
        });
    });

    document.addEventListener("input", e => {
        if (e.target.classList.contains("jumlah") || e.target.id === "bayar") {
            hitungTotal();
        }
    });

    document.addEventListener("click", function(e) {
        if (e.target.id === "tambahBarang") {

            let tbody = document.querySelector("#tabelBarang tbody");

            let template = document.querySelector("#tabelBarang tbody tr:first-child");
            let tr = template.cloneNode(true);

            tr.querySelector(".nama-barang").value = "";
            tr.querySelector(".hasil-pencarian").innerHTML = "";
            tr.querySelector(".barang-id").value = "";
            tr.querySelector(".stok-barang").value = "";
            tr.querySelector(".jumlah").value = 1;

            tr.querySelector(".harga").dataset.harga = 0;
            tr.querySelector(".harga").textContent = "Rp 0";
            tr.querySelector(".subtotal").textContent = "Rp 0";

            tbody.appendChild(tr);
        }
    });

    document.addEventListener("click", e => {
        if (e.target.closest(".hapus-baris")) {
            let tr = e.target.closest("tr");
            tr.remove();
            hitungTotal();
        }
    });

    document.getElementById("formTransaksi").addEventListener("submit", function(e) {
        let total = getNum(document.getElementById("total").value);
        let bayar = getNum(document.getElementById("bayar").value);

        if (bayar < total) {
            e.preventDefault();

            let modal = new bootstrap.Modal(document.getElementById("modalUangKurang"));
            modal.show();

            return false;
        }
    });

});
</script>

@endsection