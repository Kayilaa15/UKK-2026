
<?php
// laporan.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// ==========================================
// SESSION DAN HAK AKSES
// ==========================================
$role = $_SESSION['role'] ?? '';
$id_user = (int) ($_SESSION['id_user'] ?? 0);

if ($role !== 'admin' && $role !== 'guru') {
    http_response_code(403);
    exit('Akses ditolak. Halaman ini hanya dapat diakses oleh Admin dan Guru Wali Kelas.');
}

// ==========================================
// CEK GURU WALI KELAS AKTIF
// ==========================================
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

    if (!$stmt_guru) {
        die("Gagal memeriksa data guru: " . mysqli_error($koneksi));
    }

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

// ==========================================
// FILTER TANGGAL
// ==========================================
$tanggal_mulai = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';

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

// ==========================================
// QUERY LAPORAN
// ==========================================
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

// Guru hanya melihat kelas tanggung jawabnya
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

// Bind parameter
if (!empty($params)) {

    $bind_params = [$stmt, $types];

    foreach ($params as $key => $value) {
        $bind_params[] = &$params[$key];
    }

    call_user_func_array(
        'mysqli_stmt_bind_param',
        $bind_params
    );
}

mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);

if (!$hasil) {
    die("Gagal mengambil laporan: " . mysqli_error($koneksi));
}

// ==========================================
// LINK CETAK DENGAN FILTER YANG SAMA
// ==========================================
$queryCetak = http_build_query([
    'tanggal_mulai' => $tanggal_mulai,
    'tanggal_selesai' => $tanggal_selesai
]);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Pelanggaran Siswa</title>

    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- DATATABLES -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">

    <style>

        body {
            background-color: #f8f9fa;
        }

        main {
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .judul-halaman {
            font-weight: 600;
            margin-bottom: 20px;
        }

        #tabelLaporan th,
        #tabelLaporan td {
            vertical-align: middle;
        }

        .dataTables_wrapper {
            padding-top: 10px;
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

            <h1 class="mb-3 judul-halaman">
                Laporan Pelanggaran Siswa
            </h1>

            <p class="text-muted">
                Halaman laporan data pelanggaran siswa.
            </p>

            <!-- INFORMASI AKSES -->
            <div class="alert alert-info">

                <?php if ($role === 'admin') { ?>

                    Anda login sebagai <strong>Admin</strong>.
                    Anda dapat melihat seluruh laporan pelanggaran siswa.

                <?php } else { ?>

                    Anda login sebagai <strong>Guru Wali Kelas</strong>.
                    Anda hanya dapat melihat laporan dari kelas yang menjadi tanggung jawab Anda.

                <?php } ?>

            </div>

            <!-- FILTER TANGGAL -->
            <div class="card shadow-sm mb-4">

                <div class="card-header bg-primary text-white">
                    Filter Laporan
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
                                       value="<?= htmlspecialchars($tanggal_mulai, ENT_QUOTES, 'UTF-8'); ?>">

                            </div>

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    Tanggal Selesai
                                </label>

                                <input type="date"
                                       name="tanggal_selesai"
                                       class="form-control"
                                       value="<?= htmlspecialchars($tanggal_selesai, ENT_QUOTES, 'UTF-8'); ?>">

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

                    <span>
                        Data Laporan Pelanggaran
                    </span>

                    <a href="cetak_laporan.php?<?= htmlspecialchars($queryCetak, ENT_QUOTES, 'UTF-8'); ?>"
                       target="_blank"
                       class="btn btn-light btn-sm">

                        Cetak Laporan

                    </a>

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
                                            <?= htmlspecialchars($row['nama_siswa'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_kelas'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_pelanggaran'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_guru'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['tanggal'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                        </td>

                                        <td>
                                            <?= (int) $row['poin']; ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['tindakan'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['status'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <!-- KEMBALI -->
            <div class="mt-3">

                <a href="dashboard.php" class="btn btn-secondary">
                    Kembali ke Dashboard
                </a>

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
