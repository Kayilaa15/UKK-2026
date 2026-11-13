<?php
// laporan.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// ========================================
// 1. SESSION DAN HAK AKSES
// ========================================
$role = $_SESSION['role'] ?? '';
$id_user = (int) ($_SESSION['id_user'] ?? 0);

if (!in_array($role, ['admin', 'guru'], true)) {
    http_response_code(403);
    exit('Akses ditolak.');
}

// ========================================
// 2. IDENTIFIKASI GURU WALI KELAS
// ========================================
$id_guru = 0;

if ($role === 'guru') {

    $stmt_guru = mysqli_prepare(
        $koneksi,
        "SELECT g.id
         FROM t_guru g
         INNER JOIN t_wali_kelas wk ON wk.guru_id = g.id
         WHERE g.user_id = ?
         AND wk.status_aktif = 1
         LIMIT 1"
    );

    mysqli_stmt_bind_param($stmt_guru, "i", $id_user);
    mysqli_stmt_execute($stmt_guru);

    $hasil_guru = mysqli_stmt_get_result($stmt_guru);
    $guru = mysqli_fetch_assoc($hasil_guru);

    mysqli_stmt_close($stmt_guru);

    if (!$guru) {
        exit('Anda bukan guru wali kelas yang aktif.');
    }

    $id_guru = (int) $guru['id'];
}

// ========================================
// 3. FILTER TANGGAL
// ========================================
$tanggal_mulai = trim($_GET['tanggal_mulai'] ?? '');
$tanggal_selesai = trim($_GET['tanggal_selesai'] ?? '');

function tanggalValid($tanggal)
{
    if ($tanggal === '') {
        return true;
    }

    $date = DateTime::createFromFormat('!Y-m-d', $tanggal);

    return $date && $date->format('Y-m-d') === $tanggal;
}

if (!tanggalValid($tanggal_mulai) || !tanggalValid($tanggal_selesai)) {
    exit('Format tanggal tidak valid.');
}

if (
    $tanggal_mulai !== '' &&
    $tanggal_selesai !== '' &&
    $tanggal_mulai > $tanggal_selesai
) {
    exit('Tanggal mulai tidak boleh melebihi tanggal selesai.');
}

// ========================================
// 4. QUERY LAPORAN
// ========================================
$sql = "SELECT
            ps.id,
            ps.nama_siswa,
            ps.nama_kelas,
            ps.nama_pelanggaran,
            ps.nama_guru,
            ps.tanggal,
            ps.poin,
            ps.tindakan,
            ps.status
        FROM t_pelanggaran_siswa ps
        WHERE 1=1";

$types = '';
$params = [];

if ($role === 'guru') {

    $sql .= " AND EXISTS (
        SELECT 1
        FROM t_wali_kelas wk
        WHERE wk.guru_id = ?
        AND wk.kelas_id = ps.kelas_id
        AND wk.tahun_ajaran_id = ps.tahun_ajaran_id
        AND wk.status_aktif = 1
    )";

    $types .= 'i';
    $params[] = $id_guru;
}

if ($tanggal_mulai !== '') {
    $sql .= " AND ps.tanggal >= ?";
    $types .= 's';
    $params[] = $tanggal_mulai;
}

if ($tanggal_selesai !== '') {
    $sql .= " AND ps.tanggal <= ?";
    $types .= 's';
    $params[] = $tanggal_selesai;
}

$sql .= " ORDER BY ps.tanggal DESC, ps.id DESC";

$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    exit('Query laporan gagal: ' . htmlspecialchars(mysqli_error($koneksi)));
}

if ($params) {

    $bind = [$stmt, $types];

    foreach ($params as $key => &$value) {
        $bind[] = &$value;
    }

    call_user_func_array('mysqli_stmt_bind_param', $bind);
}

mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$jumlah_data = mysqli_num_rows($hasil);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laporan Pelanggaran - SMK Muhammadiyah</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- DATATABLES -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">

    <style>

        body {
            background-color: #fff;
        }

        .judul-halaman {
            font-weight: 700;
        }

        .card {
            border: none;
            border-radius: 10px;
        }

        /* Header dan tanda tangan disembunyikan di layar biasa */
        .kop-laporan,
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

            /* Sembunyikan sidebar dan kontrol */
            .no-print,
            .sidebar,
            .dt-length,
            .dt-search,
            .dt-info,
            .dt-paging,
            .dataTables_length,
            .dataTables_filter,
            .dataTables_info,
            .dataTables_paginate,
            .card-header {
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

            /* HEADER SEKOLAH TETAP MUNCUL */
            .kop-laporan {
                display: block !important;
                text-align: center;
                border-bottom: 3px solid black;
                padding-bottom: 12px;
                margin-bottom: 20px;
            }

            .kop-laporan h2 {
                font-size: 21px;
                font-weight: bold;
                margin-bottom: 4px;
            }

            .kop-laporan h5 {
                font-size: 15px;
                font-weight: bold;
            }

            .kop-laporan p {
                margin: 2px 0;
                font-size: 10px;
            }

            /* JUDUL LAPORAN */
            .judul-cetak {
                display: block !important;
                text-align: center;
                margin-bottom: 20px;
            }

            .judul-cetak h5 {
                font-size: 15px;
                font-weight: bold;
            }

            /* TABEL */
            .card,
            .card-body {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
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

            /* TANDA TANGAN */
            .tanda-tangan {
                display: block !important;
                width: 250px;
                margin: 25px 0 0 auto !important;
                text-align: center;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            .nama-kepala {
                margin-top: 60px;
                font-weight: bold;
                text-decoration: underline;
            }

        }

    </style>

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <!-- SIDEBAR -->
        <?php include 'layout/sidebar.php'; ?>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <!-- JUDUL HALAMAN DAN TOMBOL KEMBALI -->
            <div class="mb-4 no-print">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <div>

                        <h3 class="judul-halaman">
                            Laporan Pelanggaran Siswa
                        </h3>

                        <p class="text-muted mb-0">
                            Laporan data pelanggaran siswa SMK Muhammadiyah.
                        </p>

                    </div>

                    <div>

                        <a href="dashboard.php" class="btn btn-secondary">
                            Kembali ke Dashboard
                        </a>

                    </div>

                </div>

            </div>

            <!-- FILTER TANGGAL -->
            <div class="card shadow-sm mb-4 no-print">

                <div class="card-header bg-primary text-white">

                    <h5 class="mb-0">
                        Filter Laporan
                    </h5>

                </div>

                <div class="card-body">

                    <form method="GET" action="laporan.php">

                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    Tanggal Mulai
                                </label>

                                <input type="date"
                                       name="tanggal_mulai"
                                       class="form-control"
                                       value="<?= htmlspecialchars($tanggal_mulai); ?>">

                            </div>

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    Tanggal Selesai
                                </label>

                                <input type="date"
                                       name="tanggal_selesai"
                                       class="form-control"
                                       value="<?= htmlspecialchars($tanggal_selesai); ?>">

                            </div>

                            <div class="col-md-4 d-flex align-items-end gap-2 mb-3">

                                <button type="submit" class="btn btn-primary">
                                    Tampilkan
                                </button>

                                <a href="laporan.php" class="btn btn-secondary">
                                    Reset
                                </a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <!-- KOP SURAT -->
            <div class="kop-laporan text-center mb-4">

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
                    LAPORAN DATA PELANGGARAN SISWA
                </h5>

                <p>
                    Periode:

                    <?= $tanggal_mulai
                        ? date('d-m-Y', strtotime($tanggal_mulai))
                        : 'Semua Tanggal'; ?>

                    s/d

                    <?= $tanggal_selesai
                        ? date('d-m-Y', strtotime($tanggal_selesai))
                        : 'Semua Tanggal'; ?>

                </p>

            </div>

            <!-- TABEL LAPORAN -->
            <div class="card shadow-sm">

                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center no-print">

                    <h5 class="mb-0">
                        Data Laporan Pelanggaran
                    </h5>

                    <button onclick="cetakLaporan()"
                            type="button"
                            class="btn btn-light btn-sm">

                        Cetak Laporan

                    </button>

                </div>

                <div class="table-responsive">

                    <table id="tabelLaporan"
                           class="table table-bordered table-striped table-hover align-middle w-100">

                        <thead class="table-dark">

                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Nama Pelanggaran</th>
                                <th>Guru Pencatat</th>
                                <th>Tanggal</th>
                                <th>Poin</th>
                                <th>Tindakan</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php
                            $no = 1;

                            while ($row = mysqli_fetch_assoc($hasil)) {
                            ?>

                                <tr>

                                    <td class="text-center">
                                        <?= $no++; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_siswa'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_kelas'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_pelanggaran'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_guru'] ?? '-'); ?>
                                    </td>

                                    <td class="text-center">
                                        <?= !empty($row['tanggal'])
                                            ? date('d-m-Y', strtotime($row['tanggal']))
                                            : '-'; ?>
                                    </td>

                                    <td class="text-center">
                                        <?= (int) $row['poin']; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['tindakan'] ?? '-'); ?>
                                    </td>

                                    <td class="text-center">
                                        <?= htmlspecialchars($row['status'] ?? '-'); ?>
                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

                <?php if ($jumlah_data === 0) { ?>

                    <div class="alert alert-warning text-center no-print">
                        Belum ada data pelanggaran siswa.
                    </div>

                <?php } ?>

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

        </main>

    </div>

</div>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DATATABLES -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<script>

// ========================================
// DATATABLES
// ========================================

let tabelLaporan;

$(document).ready(function () {

    tabelLaporan = $('#tabelLaporan').DataTable({

        language: {

            search: "Cari:",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data",

            zeroRecords: "Data tidak ditemukan",

            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }

        },

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        order: [[5, 'desc']],

        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false
            }
        ],

        drawCallback: function () {

            let api = this.api();
            let info = api.page.info();

            api.column(0, {
                page: 'current'
            }).nodes().each(function (cell, i) {

                cell.innerHTML = info.start + i + 1;

            });

        }

    });

});

// ========================================
// CETAK SEMUA DATA
// ========================================

function cetakLaporan() {

    // Simpan jumlah data per halaman
    let panjangHalaman = tabelLaporan.page.len();

    // Tampilkan semua data
    tabelLaporan.page.len(-1).draw();

    // Tunggu tabel selesai diperbarui
    setTimeout(function () {

        window.onafterprint = function () {

            // Kembalikan tampilan DataTables
            tabelLaporan.page.len(panjangHalaman).draw();

            window.onafterprint = null;

        };

        // Cetak laporan
        window.print();

    }, 300);

}

</script>

</body>
</html>

<?php
mysqli_stmt_close($stmt);
?>