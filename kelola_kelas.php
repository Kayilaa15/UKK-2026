<?php
// kelola_kelas.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

$sql = "SELECT * FROM t_kelas ORDER BY nama ASC";
$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Kelas</title>

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

            <h2 class="mb-4">Kelola Kelas</h2>

            <!-- Tombol Navigasi -->
            <div class="mb-3">
                <a href="dashboard.php" class="btn btn-secondary">
                    Kembali ke Dashboard
                </a>

                <a href="tambah_kelas.php" class="btn btn-primary">
                    + Tambah Kelas
                </a>
            </div>

            <!-- Notifikasi Sukses -->
            <?php if (isset($_SESSION['pesan_sukses'])) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['pesan_sukses']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['pesan_sukses']); ?>
            <?php } ?>

            <!-- Notifikasi Error -->
            <?php if (isset($_SESSION['pesan_error'])) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['pesan_error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['pesan_error']); ?>
            <?php } ?>

            <!-- TABEL KELAS -->
            <div class="card shadow-sm">

                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Daftar Kelas</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">

                        <table id="tabelKelas"
                               class="table table-striped table-bordered table-hover align-middle w-100">

                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Nama Kelas</th>
                                    <th>Tingkat</th>
                                    <th>Jurusan</th>
                                    <th>Status Aktif</th>
                                    <th>Dibuat</th>
                                    <th>Diubah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;

                                if ($hasil && mysqli_num_rows($hasil) > 0) {
                                    while ($row = mysqli_fetch_assoc($hasil)) {
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>

                                        <td><?= (int) $row['id']; ?></td>

                                        <td>
                                            <?= htmlspecialchars($row['nama'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['tingkat'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['jurusan'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php if ($row['status_aktif'] == 1) { ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php } else { ?>
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            <?php } ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['created_at'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['updated_at'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="edit_kelas.php?id=<?= (int) $row['id']; ?>"
                                                   class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>

                                                <a href="hapus_kelas.php?id=<?= (int) $row['id']; ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Yakin ingin menghapus data kelas ini?');">
                                                    Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- Bootstrap 5 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Konfigurasi DataTables -->
<script>
$(document).ready(function () {
    $('#tabelKelas').DataTable({
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data kelas tidak ditemukan",
            emptyTable: "Belum ada data kelas",

            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },

        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],

        // Urutkan berdasarkan nama kelas
        order: [[2, 'asc']],

        // Kolom aksi tidak bisa diurutkan atau dicari
        columnDefs: [
            {
                targets: 8,
                orderable: false,
                searchable: false
            }
        ]
    });
});
</script>

</body>
</html>