<?php
// laporan.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil data session
$role = $_SESSION['role'] ?? '';
$id_user = (int) ($_SESSION['id_user'] ?? 0);

// Cek hak akses
if ($role !== 'admin' && $role !== 'guru') {
    http_response_code(403);
    exit('Akses ditolak. Halaman ini hanya dapat diakses oleh Admin dan Guru Wali Kelas.');
}

// Jika login sebagai guru, cek apakah guru tersebut merupakan wali kelas aktif
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
    $data_guru = mysqli_fetch_assoc($hasil_guru);

    mysqli_stmt_close($stmt_guru);

    if (!$data_guru) {
        http_response_code(403);
        exit('Akses ditolak. Anda bukan Guru Wali Kelas yang aktif.');
    }

    $id_guru = (int) $data_guru['id'];
}

// Filter tanggal
$tanggal_mulai = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';

// Validasi format tanggal
if (
    ($tanggal_mulai !== '' &&
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_mulai)) ||
    ($tanggal_selesai !== '' &&
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_selesai))
) {
    exit('Format tanggal tidak valid.');
}

if (
    $tanggal_mulai !== '' &&
    $tanggal_selesai !== '' &&
    $tanggal_mulai > $tanggal_selesai
) {
    exit('Tanggal mulai tidak boleh melebihi tanggal selesai.');
}

// Query laporan
$sql = "SELECT
            ps.id,
            ps.tahun_ajaran_id,
            ps.siswa_id,
            ps.nama_siswa,
            ps.kelas_id,
            ps.nama_kelas,
            ps.pelanggaran_id,
            ps.nama_pelanggaran,
            ps.pelanggaran_kategori_id,
            ps.guru_id,
            ps.nama_guru,
            ps.tanggal,
            ps.keterangan,
            ps.poin,
            ps.tindakan,
            ps.status
        FROM t_pelanggaran_siswa ps
        WHERE 1 = 1";

$types = "";
$params = [];

// Guru hanya melihat pelanggaran dari kelas yang menjadi tanggung jawabnya
if ($role === 'guru') {

    $sql .= " AND EXISTS (
                SELECT 1
                FROM t_wali_kelas wk
                WHERE wk.guru_id = ?
                  AND wk.kelas_id = ps.kelas_id
                  AND wk.tahun_ajaran_id = ps.tahun_ajaran_id
                  AND wk.status_aktif = 1
            )";

    $types .= "i";
    $params[] = $id_guru;
}

// Filter tanggal mulai
if ($tanggal_mulai !== '') {
    $sql .= " AND ps.tanggal >= ?";
    $types .= "s";
    $params[] = $tanggal_mulai;
}

// Filter tanggal selesai
if ($tanggal_selesai !== '') {
    $sql .= " AND ps.tanggal <= ?";
    $types .= "s";
    $params[] = $tanggal_selesai;
}

$sql .= " ORDER BY ps.tanggal DESC, ps.id DESC";

$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    die("Gagal menyiapkan laporan: " . htmlspecialchars(mysqli_error($koneksi)));
}

// Bind parameter jika tersedia
if (!empty($params)) {
    $bind_params = [$stmt, $types];

    foreach ($params as $key => $value) {
        $bind_params[] = &$params[$key];
    }

    call_user_func_array('mysqli_stmt_bind_param', $bind_params);
}

mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Pelanggaran Siswa</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
        rel="stylesheet">

    <style>
        @media print {
            .no-print,
            .sidebar,
            #tabelLaporan_wrapper .dt-search,
            #tabelLaporan_wrapper .dt-length,
            #tabelLaporan_wrapper .dt-paging {
                display: none !important;
            }

            main {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            body {
                font-size: 11px;
            }

            table {
                width: 100% !important;
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

            <h1 class="mb-3">Laporan Pelanggaran Siswa</h1>

            <p class="text-muted">
                Halaman laporan data pelanggaran siswa.
            </p>

            <!-- INFORMASI AKSES -->
            <div class="alert alert-info no-print">
                <?php if ($role === 'admin') { ?>
                    Anda login sebagai <strong>Admin</strong>.
                    Anda dapat melihat seluruh laporan pelanggaran siswa.
                <?php } else { ?>
                    Anda login sebagai <strong>Guru Wali Kelas</strong>.
                    Anda hanya dapat melihat laporan dari kelas yang menjadi tanggung jawab Anda.
                <?php } ?>
            </div>

            <!-- FILTER TANGGAL -->
            <div class="card shadow-sm mb-4 no-print">
                <div class="card-header bg-primary text-white">
                    Filter Laporan
                </div>

                <div class="card-body">

                    <form method="GET" action="laporan.php">

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Mulai</label>

                                <input type="date"
                                    name="tanggal_mulai"
                                    class="form-control"
                                    value="<?= htmlspecialchars($tanggal_mulai); ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Selesai</label>

                                <input type="date"
                                    name="tanggal_selesai"
                                    class="form-control"
                                    value="<?= htmlspecialchars($tanggal_selesai); ?>">
                            </div>

                            <div class="col-md-4 mb-3 d-flex align-items-end gap-2">

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

            <!-- TABEL LAPORAN -->
            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                    <span>Data Laporan Pelanggaran</span>

                    <button type="button"
                        onclick="window.print()"
                        class="btn btn-light btn-sm no-print">
                        Cetak Laporan
                    </button>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="tabelLaporan"
                            class="table table-striped table-bordered table-hover align-middle w-100">

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

                                <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>

                                    <tr>
                                        <td></td>

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

                                        <td>
                                            <?= htmlspecialchars($row['tanggal'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= (int) $row['poin']; ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['tindakan'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['status'] ?? '-'); ?>
                                        </td>
                                    </tr>

                                <?php } ?>

                            </tbody>

                        </table>

                    </div>

                </div>
            </div>

            <div class="mt-3 no-print">
                <a href="dashboard.php" class="btn btn-secondary">
                    Kembali ke Dashboard
                </a>
            </div>

        </main>

    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

<!-- DataTables Bootstrap 5 -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Inisialisasi DataTables -->
<script>
$(document).ready(function () {

    $('#tabelLaporan').DataTable({

        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data laporan",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data laporan tidak ditemukan",
            emptyTable: "Belum ada data pelanggaran",

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

        // Nomor urut otomatis
        drawCallback: function () {

            var api = this.api();
            var info = api.page.info();

            api.column(0, {
                page: 'current'
            }).nodes().each(function (cell, i) {

                cell.innerHTML = info.start + i + 1;

            });

        }

    });

});
</script>

</body>
</html>

<?php
mysqli_stmt_close($stmt);
?>
