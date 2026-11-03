<?php
// laporan.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Jika tombol Export Excel ditekan, proses unduhan
if (isset($_GET['export']) && $_GET['export'] === 'excel') {

    $sqlExcel = "
        SELECT
            s.nis,
            s.nama AS nama_siswa,
            p.kode,
            p.nama AS nama_pelanggaran,
            p.poin,
            ps.id AS id_pelanggaran_siswa
        FROM t_pelanggaran_siswa ps
        JOIN t_siswa s
            ON ps.siswa_id = s.id
        JOIN t_pelanggaran p
            ON ps.pelanggaran_id = p.id
        ORDER BY ps.id DESC
    ";

    $dataExcel = mysqli_query($koneksi, $sqlExcel);

    if (!$dataExcel) {
        die("Gagal mengambil data: " .
            htmlspecialchars(mysqli_error($koneksi), ENT_QUOTES, 'UTF-8'));
    }

    // Header unduhan Excel
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=laporan_pelanggaran.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Membantu Excel membaca karakter UTF-8
    echo "\xEF\xBB\xBF";

    echo '<table border="1">';
    echo '<tr>';
    echo '<th>No</th>';
    echo '<th>NIS</th>';
    echo '<th>Nama Siswa</th>';
    echo '<th>Kode Pelanggaran</th>';
    echo '<th>Jenis Pelanggaran</th>';
    echo '<th>Poin</th>';
    echo '</tr>';

    $no = 1;

    while ($row = mysqli_fetch_assoc($dataExcel)) {
        echo '<tr>';
        echo '<td>' . $no++ . '</td>';
        echo '<td>' . htmlspecialchars((string) $row['nis'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . htmlspecialchars((string) $row['nama_siswa'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . htmlspecialchars((string) ($row['kode'] ?? ''), ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . htmlspecialchars((string) $row['nama_pelanggaran'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . (int) $row['poin'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';

    mysqli_free_result($dataExcel);
    exit;
}

// Ambil data untuk ditampilkan di halaman laporan
$sql = "
    SELECT
        ps.id,
        s.nis,
        s.nama AS nama_siswa,
        p.kode,
        p.nama AS nama_pelanggaran,
        p.poin
    FROM t_pelanggaran_siswa ps
    JOIN t_siswa s
        ON ps.siswa_id = s.id
    JOIN t_pelanggaran p
        ON ps.pelanggaran_id = p.id
    ORDER BY ps.id DESC
";

$hasil = mysqli_query($koneksi, $sql);

if (!$hasil) {
    die("Gagal mengambil laporan: " .
        htmlspecialchars(mysqli_error($koneksi), ENT_QUOTES, 'UTF-8'));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
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

        /* Pengaturan khusus saat mencetak atau menyimpan sebagai PDF */
        @media print {
            body {
                background: #fff !important;
                font-size: 12px;
            }

            .sidebar,
            nav,
            .no-print,
            .dataTables_filter,
            .dataTables_length,
            .dataTables_info,
            .dataTables_paginate,
            .dataTables_processing {
                display: none !important;
            }

            main {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                min-height: auto !important;
                padding: 0 !important;
            }

            .container-fluid,
            .row {
                display: block !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }

            .card-header {
                border: none !important;
                padding: 0 0 10px 0 !important;
            }

            .card-body {
                padding: 0 !important;
            }

            .table-responsive {
                overflow: visible !important;
            }

            #tabelLaporan {
                width: 100% !important;
                border-collapse: collapse !important;
                font-size: 10px;
            }

            #tabelLaporan th,
            #tabelLaporan td {
                border: 1px solid #000 !important;
                padding: 5px !important;
                color: #000 !important;
                background: #fff !important;
            }

            h3,
            h5 {
                color: #000 !important;
            }

            @page {
                size: landscape;
                margin: 1.5cm;
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

            <h3 class="judul-halaman">Laporan Pelanggaran Siswa</h3>

            <div class="card">

                <div class="card-header bg-white d-flex
                            justify-content-between align-items-center">

                    <h5 class="mb-0">Data Laporan Pelanggaran</h5>

                    <div class="no-print">
                        <!-- Tombol Cetak PDF -->
                        <button type="button"
                                onclick="cetakPDF()"
                                class="btn btn-danger btn-sm">
                            Cetak PDF
                        </button>

                        <!-- Tombol Export Excel -->
                        <a href="laporan.php?export=excel"
                           class="btn btn-success btn-sm">
                            Export Excel
                        </a>
                    </div>

                </div>
                
                <div class="card-body">

                    <div class="table-responsive">

                        <table id="tabelWaliKelas"
                               class="table table-striped table-bordered table-hover align-middle w-100">

                            <thead class="table-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kode Pelanggaran</th>
                                    <th>Jenis Pelanggaran</th>
                                    <th>Poin</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;

                                while ($row = mysqli_fetch_assoc($hasil)) {
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>

                                        <td>
                                            <?= htmlspecialchars(
                                                (string) $row['nis'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                (string) $row['nama_siswa'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                (string) ($row['kode'] ?? ''),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                (string) $row['nama_pelanggaran'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>

                                        <td><?= (int) $row['poin']; ?></td>
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
let panjangHalamanSebelumCetak = 10;

$(document).ready(function () {
    $('#tabelLaporan').DataTable({
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Data tidak ditemukan",
            emptyTable: "Belum ada laporan pelanggaran",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        order: [[2, 'asc']],
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false
            }
        ]
    });
});

// Fungsi cetak PDF melalui menu cetak browser
function cetakPDF() {
    const tabel = $('#tabelLaporan').DataTable();

    // Tampilkan semua data sebelum mencetak
    panjangHalamanSebelumCetak = tabel.page.len();
    tabel.page.len(-1).draw();

    // Beri waktu untuk memperbarui tabel sebelum membuka dialog cetak
    setTimeout(function () {
        window.print();
    }, 300);
}

// Kembalikan jumlah data per halaman setelah dialog cetak ditutup
window.addEventListener('afterprint', function () {
    const tabel = $('#tabelLaporan').DataTable();
    tabel.page.len(panjangHalamanSebelumCetak).draw();
});
</script>

</body>
</html>