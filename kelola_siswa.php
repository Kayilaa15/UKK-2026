<?php
// kelola_siswa.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$sql = "SELECT * FROM t_siswa ORDER BY nama ASC";
$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Siswa</title>

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

            <h1 class="mb-4">Kelola Siswa</h1>

            <!-- Tombol Navigasi -->
            <div class="mb-3">
                <a href="dashboard.php" class="btn btn-secondary">
                    Kembali ke Dashboard
                </a>

                <a href="tambah_siswa.php" class="btn btn-primary">
                    + Tambah Siswa
                </a>
            </div>

            <!-- TABEL DATA SISWA -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="table-responsive">

                        <table id="tabelSiswa"
                               class="table table-striped table-bordered table-hover align-middle w-100">

                            <thead class="table-dark">
                                <tr>
                                    <th>No </th>
                                    <th>NIS</th>
                                    <th>NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th>Status Aktif</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>

                                <tr>
                                <!--Nomor urut otomatis-->
                                    <td></td>

                                    <td>
                                        <?= htmlspecialchars($row['nis'] ?? '') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nisn'] ?? '') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama'] ?? '') ?>
                                    </td>

                                    <td>
                                        <?php
                                        if ($row['jenis_kelamin'] == 'L') {
                                            echo "Laki-laki";
                                        } elseif ($row['jenis_kelamin'] == 'P') {
                                            echo "Perempuan";
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['tanggal_lahir'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['alamat'] ?? '-') ?>
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

                                            <a href="edit_siswa.php?id=<?= urlencode($row['id']) ?>"
                                               class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <a href="hapus_siswa.php?id=<?= urlencode($row['id']) ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin ingin menghapus data siswa ini?');">
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

<script>
$(document).ready(function () {

    // Inisialisasi DataTables
    var tabel = $('#tabelSiswa').DataTable({

        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data siswa",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data siswa tidak ditemukan",
            emptyTable: "Belum ada data siswa",

            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50, 100],

        order: [[3, 'asc']],

        columnDefs: [
            {
                targets: [0, 8],
                orderable: false,
                searchable: false
            }
        ]

    });

    // Fungsi nomor urut otomatis
    function nomorUrut() {

        var informasi = tabel.page.info();

        tabel
            .column(0, {
                search: 'applied',
                order: 'applied'
            })
            .nodes()
            .each(function (cell, i) {

                cell.textContent = informasi.start + i + 1;

            });
    }

    // Perbarui nomor urut setiap tabel berubah
    tabel.on('draw.dt', function () {
        nomorUrut();
    });

    // Tampilkan nomor urut saat halaman pertama dibuka
    nomorUrut();

});
</script>

