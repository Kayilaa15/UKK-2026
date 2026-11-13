<?php
// cetak_laporan.php

include "config/koneksi.php";

// Mengambil data dari database
$data = mysqli_query($koneksi, "
    SELECT
        s.nis,
        s.nama,
        pk.nama AS pelanggaran
    FROM t_pelanggaran_siswa ps
    JOIN t_siswa s ON ps.siswa_id = s.id
    JOIN t_pelanggaran_kategori pk ON ps.pelanggaran_id = pk.id
    ORDER BY ps.id DESC
");

if (!$data) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Pelanggaran SMK Muhammadiyah</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background-color: #f1f3f5;
            font-family: Arial, sans-serif;
            color: #000;
        }

        .laporan {
            background: white;
            padding: 40px;
            margin: 30px auto;
            max-width: 1000px;
            border: 1px solid #ddd;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .kop-surat h2 {
            font-size: 23px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .kop-surat h3 {
            font-size: 20px;
            font-weight: bold;
        }

        .judul-laporan {
            text-align: center;
            margin-bottom: 25px;
        }

        .judul-laporan h4 {
            font-weight: bold;
            text-decoration: underline;
        }

        .table th {
            text-align: center;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        .ttd {
            width: 280px;
            margin-left: auto;
            margin-top: 50px;
            text-align: center;
        }

        .nama-kepala {
            margin-top: 80px;
            font-weight: bold;
            text-decoration: underline;
        }

        @media print {
            body {
                background: white;
            }

            .laporan {
                margin: 0;
                padding: 15px;
                max-width: 100%;
                border: none;
            }

            .no-print {
                display: none !important;
            }

            .table {
                --bs-table-bg: white;
            }
        }
    </style>
</head>

<body>

<div class="container laporan">

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <h2>SMK MUHAMMADIYAH</h2>
        <h3>LAPORAN DATA KESISWAAN</h3>
        <p class="mb-1">
            Alamat: .........................................................
        </p>
        <p class="mb-0">
            Telepon: ........................ | Email: ........................
        </p>
    </div>

    <!-- JUDUL -->
    <div class="judul-laporan">
        <h4>LAPORAN DATA PELANGGARAN SISWA</h4>
        <p class="mb-0">Tahun Pelajaran: ....................</p>
    </div>

    <!-- TABEL DATA -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-secondary">
                <tr>
                    <th width="60">No</th>
                    <th width="150">NIS</th>
                    <th>Nama Siswa</th>
                    <th>Jenis Pelanggaran</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;

                if (mysqli_num_rows($data) > 0) {
                    while ($row = mysqli_fetch_assoc($data)) {
                ?>
                    <tr>
                        <td class="text-center">
                            <?= $no++; ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['nis']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['nama']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['pelanggaran']); ?>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                ?>
                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada data pelanggaran siswa.
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- TANDA TANGAN -->
    <div class="ttd">
        <p>
            ...................., <?= date('d-m-Y'); ?>
        </p>

        <p>Mengetahui,</p>
        <p>Kepala SMK Muhammadiyah</p>

        <p class="nama-kepala">
            ( ................................ )
        </p>

        <p>NIP. ................................</p>
    </div>

    <!-- TOMBOL -->
    <div class="no-print text-center mt-4">
        <button onclick="window.print()"
                class="btn btn-primary">
            <i class="bi bi-printer"></i> Cetak Laporan
        </button>

        <a href="laporan.php" class="btn btn-secondary">
            Kembali
        </a>
    </div>

</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

</body>
</html>