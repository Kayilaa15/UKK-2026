<?php
// kelola_walikelas.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

$sql = "SELECT
            w.*,
            k.nama AS nama_kelas,
            g.nama AS nama_guru
        FROM t_wali_kelas w
        LEFT JOIN t_kelas k ON w.kelas_id = k.id
        LEFT JOIN t_guru g ON w.guru_id = g.id
        ORDER BY w.id DESC";

$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Wali Kelas</title>

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

            <h1 class="mb-4">Kelola Wali Kelas</h1>

            <!-- Tombol Navigasi -->
            <div class="mb-3">

                <a href="dashboard.php" class="btn btn-secondary">
                    Kembali ke Dashboard
                </a>

                <a href="tambah_walikelas.php" class="btn btn-primary">
                    + Tambah Wali Kelas
                </a>

            </div>

            <!-- TABEL DATA WALI KELAS -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="table-responsive">

                        <table id="tabelWaliKelas"
                               class="table table-striped table-bordered table-hover align-middle w-100">

                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tahun Ajaran ID</th>
                                    <th>Kelas</th>
                                    <th>Guru</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars($row['id']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['tahun_ajaran_id']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_kelas'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_guru'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['tanggal_mulai'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['tanggal_selesai'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?php if ($row['status_aktif'] == 1) { ?>

                                            <span class="badge bg-success">
                                                Aktif
                                            </span>

                                        <?php } else { ?>

                                            <span class="badge bg-danger">
                                                Tidak Aktif
                                            </span>

                                        <?php } ?>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">

                                            <a href="edit_walikelas.php?id=<?= urlencode($row['id']) ?>"
                                               class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <a href="hapus_walikelas.php?id=<?= urlencode($row['id']) ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin ingin menghapus data wali kelas ini?');">
                                                Hapus
                                            </a>

                                        </div>
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

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

<!-- DataTables Bootstrap 5 -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Inisialisasi DataTables -->
<script>
$(document).ready(function () {

    $('#tabelWaliKelas').DataTable({

        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data wali kelas",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data wali kelas tidak ditemukan",
            emptyTable: "Belum ada data wali kelas",

            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        order: [[0, 'desc']],

        columnDefs: [
            {
                targets: 7,
                orderable: false,
                searchable: false
            }
        ]

    });

});
</script>

</body>
</html>
