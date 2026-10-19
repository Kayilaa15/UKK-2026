<?php
// tindakan.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// Proses menyimpan tindakan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);

    $tindakan = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['tindakan'] ?? '')
    );

    // Samakan nama tabel dengan tabel yang ditampilkan
    $sql_update = "UPDATE t_pelanggaran_siswa
                   SET tindakan = '$tindakan'
                   WHERE id = $id";

    if (mysqli_query($koneksi, $sql_update)) {
        header('Location: tindakan.php?pesan=berhasil');
        exit;
    } else {
        $pesan_error = mysqli_error($koneksi);
    }
}

// Mengambil data pelanggaran siswa
$sql = "SELECT id, nama_siswa, nama_kelas,
               nama_pelanggaran, tanggal,
               keterangan, tindakan
        FROM t_pelanggaran_siswa
        ORDER BY tanggal DESC";

$hasil = mysqli_query($koneksi, $sql);

if (!$hasil) {
    die('Gagal mengambil data: ' . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tindakan Pelanggaran Siswa</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2 class="mb-2">Tindakan Pelanggaran Siswa</h2>
            <p class="text-muted">
                Kelola tindakan untuk setiap pelanggaran siswa.
            </p>

            <div class="mb-3">
                <a href="dashboard.php" class="btn btn-secondary">
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- Pesan berhasil -->
            <?php if (isset($_GET['pesan']) && $_GET['pesan'] === 'berhasil') { ?>
                <div class="alert alert-success alert-dismissible fade show">
                    Tindakan berhasil disimpan.
                    <button type="button" class="btn-close"
                            data-bs-dismiss="alert"></button>
                </div>
            <?php } ?>

            <!-- Pesan error -->
            <?php if (isset($pesan_error)) { ?>
                <div class="alert alert-danger">
                    Gagal menyimpan tindakan:
                    <?= htmlspecialchars($pesan_error); ?>
                </div>
            <?php } ?>

            <!-- TABEL DATA -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Pelanggaran Siswa</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">

                        <table id="tabelTindakan"
                               class="table table-striped table-bordered table-hover align-middle">

                            <thead class="table-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Pelanggaran</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Tindakan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>
                                    <tr>
                                        <!-- Nomor otomatis dari DataTables -->
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
                                            <?= htmlspecialchars($row['tanggal'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['keterangan'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <form
                                                id="formTindakan<?= (int) $row['id']; ?>"
                                                method="POST"
                                                action="tindakan.php">

                                                <input type="hidden" name="id"
                                                       value="<?= (int) $row['id']; ?>">

                                                <textarea
                                                    name="tindakan"
                                                    class="form-control"
                                                    rows="2"
                                                    placeholder="Masukkan tindakan..."
                                                    required><?= htmlspecialchars($row['tindakan'] ?? ''); ?></textarea>
                                            </form>
                                        </td>

                                        <td>
                                            <button
                                                type="submit"
                                                form="formTindakan<?= (int) $row['id']; ?>"
                                                class="btn btn-success btn-sm">
                                                Simpan
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>

                    </div>
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

<!-- Inisialisasi DataTables -->
<script>
$(document).ready(function () {
    $('#tabelTindakan').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],

        searching: true,
        ordering: true,
        paging: true,

        order: [[4, 'desc']],

        columnDefs: [
            {
                orderable: false,
                searchable: false,
                targets: [0, 7]
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
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data pelanggaran",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data pelanggaran tidak ditemukan",
            emptyTable: "Belum ada data pelanggaran",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        }
    });
});
</script>

</body>
</html>