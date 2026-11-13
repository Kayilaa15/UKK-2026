<?php
// rekap_poin.php

// ============================================
// 1. KONEKSI DAN SESSION
// ============================================
include 'includes/cek_session.php';
include 'config/koneksi.php';

// ============================================
// 2. MENGAMBIL INPUT PENCARIAN DAN FILTER
// ============================================
$cari = isset($_GET['cari'])
    ? trim($_GET['cari'])
    : '';

$kelas_filter = isset($_GET['kelas'])
    ? trim($_GET['kelas'])
    : '';

$cari_sql = mysqli_real_escape_string($koneksi, $cari);
$kelas_sql = mysqli_real_escape_string($koneksi, $kelas_filter);

// ============================================
// 3. MENGAMBIL DATA KELAS UNTUK FILTER
// ============================================
$query_kelas = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM t_kelas ORDER BY nama ASC"
);

if (!$query_kelas) {
    die("Gagal mengambil data kelas: " . mysqli_error($koneksi));
}

$data_kelas = [];

while ($kelas = mysqli_fetch_assoc($query_kelas)) {
    $data_kelas[] = $kelas;
}

// ============================================
// 4. QUERY REKAP POIN SISWA
// ============================================
$sql = "SELECT
            s.id AS siswa_id,
            s.nis,
            s.nama AS nama_siswa,
            COALESCE(k.nama, '-') AS nama_kelas,
            COALESCE(p.total_poin, 0) AS total_poin,
            COALESCE(p.jumlah_pelanggaran, 0) AS jumlah_pelanggaran
        FROM t_siswa s

        LEFT JOIN (
            SELECT
                siswa_id,
                SUM(poin) AS total_poin,
                COUNT(*) AS jumlah_pelanggaran
            FROM t_pelanggaran_siswa
            GROUP BY siswa_id
        ) p ON p.siswa_id = s.id

        LEFT JOIN (
            SELECT
                siswa_id,
                MAX(kelas_id) AS kelas_id
            FROM t_kelas_siswa
            WHERE status_aktif = 1
            GROUP BY siswa_id
        ) ks ON ks.siswa_id = s.id

        LEFT JOIN t_kelas k ON k.id = ks.kelas_id

        WHERE 1=1";

// ============================================
// 5. PENCARIAN SISWA
// ============================================
if ($cari != '') {
    $sql .= " AND (
        s.nama LIKE '%$cari_sql%'
        OR s.nis LIKE '%$cari_sql%'
    )";
}

// ============================================
// 6. FILTER KELAS
// ============================================
if ($kelas_filter != '') {
    $sql .= " AND k.id = '$kelas_sql'";
}

// ============================================
// 7. URUTAN POIN TERTINGGI
// ============================================
$sql .= " ORDER BY total_poin DESC, s.nama ASC";

$query_rekap = mysqli_query($koneksi, $sql);

if (!$query_rekap) {
    die("Gagal mengambil rekap poin: " . mysqli_error($koneksi));
}

// ============================================
// 8. MENGHITUNG RINGKASAN
// ============================================
$data_rekap = [];
$total_poin_semua = 0;
$total_catatan = 0;

while ($data = mysqli_fetch_assoc($query_rekap)) {
    $data_rekap[] = $data;

    $total_poin_semua += (int) $data['total_poin'];
    $total_catatan += (int) $data['jumlah_pelanggaran'];
}

$jumlah_siswa = count($data_rekap);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rekap Poin Pelanggaran Siswa</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">

    <style>
        .angka {
            font-size: 2rem;
            font-weight: bold;
            color: #0d6efd;
        }

        /* Bagian cetak disembunyikan pada tampilan biasa */
        .kop-rekap,
        .judul-cetak,
        .tanda-tangan {
            display: none;
        }

        /* =====================================
           PENGATURAN CETAK
        ===================================== */
        @media print {

            @page {
                size: landscape;
                margin: 12mm;
            }

            body {
                background: white !important;
                color: black !important;
                font-size: 11px;
            }

            /* Sembunyikan sidebar, tombol, filter,
               dan kontrol DataTables */
            .no-print,
            .sidebar,
            .dt-length,
            .dt-search,
            .dt-info,
            .dt-paging,
            .dataTables_length,
            .dataTables_filter,
            .dataTables_info,
            .dataTables_paginate {
                display: none !important;
            }

            .container-fluid,
            .row,
            main {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* KOP SURAT TETAP MUNCUL */
            .kop-rekap {
                display: block !important;
                text-align: center !important;
                border-bottom: 3px solid black !important;
                padding-bottom: 12px !important;
                margin-bottom: 20px !important;
            }

            .kop-rekap h2 {
                font-size: 21px !important;
                font-weight: bold !important;
                margin-bottom: 4px !important;
            }

            .kop-rekap h5 {
                font-size: 15px !important;
                font-weight: bold !important;
            }

            .kop-rekap p {
                margin: 2px 0 !important;
                font-size: 10px !important;
            }

            /* JUDUL CETAK TETAP MUNCUL */
            .judul-cetak {
                display: block !important;
                text-align: center !important;
                margin-bottom: 20px !important;
            }

            .judul-cetak h5 {
                font-size: 15px !important;
                font-weight: bold !important;
            }

            /* SEMBUNYIKAN TIGA KOTAK RINGKASAN */
            .ringkasan-cetak {
                display: none !important;
            }

            /* TABEL */
            .card {
                border: none !important;
                box-shadow: none !important;
            }

            .card-body {
                padding: 0 !important;
            }

            .table-responsive {
                overflow: visible !important;
            }

            table {
                width: 100% !important;
                border-collapse: collapse !important;
                margin: 0 !important;
            }

            .table th,
            .table td {
                border: 1px solid black !important;
                color: black !important;
                background: white !important;
                padding: 7px !important;
                font-size: 10px !important;
            }

            .table thead th {
                background: #dee2e6 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            thead {
                display: table-header-group;
            }

            tr {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            /* Badge poin saat dicetak */
            .badge {
                background: white !important;
                color: black !important;
                border: none !important;
                padding: 0 !important;
                font-size: 10px !important;
            }

            /* TANDA TANGAN TETAP MUNCUL */
            .tanda-tangan {
                display: block !important;
                width: 250px !important;
                margin: 25px 0 0 auto !important;
                text-align: center !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            .nama-kepala {
                margin-top: 60px !important;
                font-weight: bold !important;
                text-decoration: underline !important;
            }

            /* Keterangan bawah tabel disembunyikan */
            .keterangan-tabel {
                display: none !important;
            }
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">

            <div class="container-fluid">

                <!-- JUDUL HALAMAN -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 no-print">

                    <div>
                        <h2>Rekap Poin Pelanggaran Siswa</h2>

                        <p class="text-muted mb-0">
                            Ringkasan jumlah pelanggaran dan poin setiap siswa.
                        </p>
                    </div>

                    <div class="d-flex gap-2">

                        <a href="dashboard.php" class="btn btn-secondary">
                            Kembali ke Dashboard
                        </a>

                        <button type="button"
                                onclick="cetakRekap()"
                                class="btn btn-success">
                            Cetak Rekap
                        </button>

                    </div>
                </div>

                <!-- KOP SURAT -->
                <div class="kop-rekap text-center mb-4">

                    <h2 class="fw-bold mb-1">
                        SMK MUHAMMADIYAH
                    </h2>

                    <h5 class="fw-bold mb-2">
                        LAPORAN DATA KESISWAAN
                    </h5>

                    <p class="mb-1 small">
                        Jl. Rumah Sakit No. 29, Empangsari, Kec. Tawang,
                        Kota Tasikmalaya, Jawa Barat 46113
                    </p>

                    <p class="mb-1 small">
                        Telepon: (0265) 327380
                        | WA: 085189303384 / 085189303385
                    </p>

                    <p class="mb-2 small">
                        Email: info@smkmtsm.sch.id
                    </p>

                </div>

                <!-- JUDUL CETAK -->
                <div class="judul-cetak text-center mb-4">

                    <h5 class="fw-bold text-decoration-underline">
                        LAPORAN REKAP POIN PELANGGARAN SISWA
                    </h5>

                    <p>
                        Tanggal Cetak:
                        <?= date('d-m-Y'); ?>
                    </p>

                </div>

                <!-- RINGKASAN: HANYA TAMPIL DI HALAMAN BIASA -->
                <div class="row g-3 mb-4 ringkasan-cetak">

                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <p class="text-muted mb-1">
                                    Jumlah Siswa
                                </p>

                                <div class="angka">
                                    <?= $jumlah_siswa; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <p class="text-muted mb-1">
                                    Total Poin
                                </p>

                                <div class="angka">
                                    <?= $total_poin_semua; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <p class="text-muted mb-1">
                                    Jumlah Catatan Pelanggaran
                                </p>

                                <div class="angka">
                                    <?= $total_catatan; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- PENCARIAN DAN FILTER -->
                <div class="card shadow-sm mb-4 no-print">

                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            Pencarian dan Filter Siswa
                        </h5>
                    </div>

                    <div class="card-body">

                        <form method="GET" action="rekap_poin.php">

                            <div class="row g-3">

                                <div class="col-md-5">
                                    <label for="cari" class="form-label">
                                        Cari Siswa
                                    </label>

                                    <input
                                        type="text"
                                        name="cari"
                                        id="cari"
                                        class="form-control"
                                        placeholder="Masukkan nama atau NIS siswa"
                                        value="<?= htmlspecialchars($cari); ?>">
                                </div>

                                <div class="col-md-4">
                                    <label for="kelas" class="form-label">
                                        Filter Kelas
                                    </label>

                                    <select name="kelas" id="kelas"
                                            class="form-select">

                                        <option value="">
                                            Semua Kelas
                                        </option>

                                        <?php foreach ($data_kelas as $kelas) { ?>
                                            <option
                                                value="<?= (int) $kelas['id']; ?>"
                                                <?= $kelas_filter == $kelas['id'] ? 'selected' : ''; ?>>

                                                <?= htmlspecialchars($kelas['nama']); ?>

                                            </option>
                                        <?php } ?>

                                    </select>
                                </div>

                                <div class="col-md-3 d-flex align-items-end gap-2">

                                    <button type="submit" class="btn btn-primary">
                                        Cari
                                    </button>

                                    <a href="rekap_poin.php" class="btn btn-secondary">
                                        Reset
                                    </a>

                                </div>

                            </div>
                        </form>

                    </div>
                </div>

                <!-- TABEL REKAP -->
                <div class="card shadow-sm">

                    <div class="card-header bg-dark text-white no-print">
                        <h5 class="mb-0">
                            Data Rekap Poin Siswa
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table id="tabelRekap"
                                   class="table table-striped table-bordered table-hover align-middle w-100">

                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Jumlah Pelanggaran</th>
                                        <th>Total Poin</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php foreach ($data_rekap as $data) { ?>
                                        <tr>
                                            <td></td>

                                            <td>
                                                <?= htmlspecialchars($data['nis'] ?? '-'); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($data['nama_siswa'] ?? '-'); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($data['nama_kelas'] ?? '-'); ?>
                                            </td>

                                            <td class="text-center">
                                                <?= (int) $data['jumlah_pelanggaran']; ?>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-warning text-dark">
                                                    <?= (int) $data['total_poin']; ?> poin
                                                </span>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>

                        <p class="text-muted mb-0 mt-3 keterangan-tabel">
                            Total poin dihitung berdasarkan catatan pada
                            tabel t_pelanggaran_siswa.
                        </p>

                    </div>
                </div>

                <!-- TANDA TANGAN -->
                <div class="tanda-tangan text-center ms-auto mt-5"
                     style="max-width: 280px;">

                    <p>
                        Tasikmalaya, <?= date('d-m-Y'); ?>
                    </p>

                    <p>Mengetahui,</p>

                    <p class="fw-bold">
                        Kepala SMK Muhammadiyah
                    </p>

                    <p class="nama-kepala">
                        ( ................................ )
                    </p>

                    <p>
                        NIP. ................................
                    </p>

                </div>

            </div>

        </main>

    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<script>
// ============================================
// DATATABLES
// ============================================
let tabelRekap;

$(document).ready(function () {

    tabelRekap = $('#tabelRekap').DataTable({

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        searching: true,

        ordering: true,

        paging: true,

        order: [[5, 'desc'], [2, 'asc']],

        columnDefs: [
            {
                orderable: false,
                searchable: false,
                targets: 0
            }
        ],

        drawCallback: function () {

            var api = this.api();
            var nomorAwal = api.page.info().start;

            api.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {

                cell.innerHTML = nomorAwal + i + 1;

            });

        },

        language: {

            search: "Cari di tabel:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data rekap",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data siswa tidak ditemukan",
            emptyTable: "Belum ada data rekap poin siswa",

            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }

        }

    });

});

// ============================================
// CETAK SEMUA DATA REKAP
// ============================================
function cetakRekap() {

    let panjangHalaman = tabelRekap.page.len();

    // Tampilkan seluruh data saat dicetak
    tabelRekap.page.len(-1).draw();

    setTimeout(function () {

        window.onafterprint = function () {

            tabelRekap.page.len(panjangHalaman).draw();

            window.onafterprint = null;

        };

        window.print();

    }, 300);

}
</script>

</body>
</html>