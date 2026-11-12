
<?php
// cetak_tindakan.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// ====================================
// FUNGSI TINDAKAN OTOMATIS
// ====================================

function tentukanTindakan($namaPelanggaran)
{
    $nama = strtolower(trim($namaPelanggaran));

    if (strpos($nama, 'rambut') !== false) {
        return 'Menegur siswa dan meminta siswa merapikan rambut sesuai aturan sekolah.';
    } elseif (
        strpos($nama, 'rokok') !== false ||
        strpos($nama, 'vape') !== false
    ) {
        return 'Memberikan pembinaan dan memanggil orang tua siswa.';
    } elseif (
        strpos($nama, 'tidak masuk') !== false ||
        strpos($nama, 'absen') !== false
    ) {
        return 'Memberikan teguran dan meminta surat keterangan dari orang tua.';
    } elseif (strpos($nama, 'sampah') !== false) {
        return 'Memberikan teguran dan meminta siswa membersihkan lingkungan sekolah.';
    } elseif (
        strpos($nama, 'gaduh') !== false ||
        strpos($nama, 'ribut') !== false
    ) {
        return 'Memberikan teguran dan pembinaan agar siswa tidak mengulangi perbuatannya.';
    } elseif (strpos($nama, 'terlambat') !== false) {
        return 'Memberikan teguran dan pembinaan kedisiplinan kepada siswa.';
    } elseif (strpos($nama, 'meninggalkan kelas') !== false) {
        return 'Memberikan teguran dan meminta siswa mengikuti kegiatan belajar dengan tertib.';
    } elseif (
        strpos($nama, 'tidak mengerjakan tugas') !== false ||
        strpos($nama, 'tugas') !== false
    ) {
        return 'Meminta siswa menyelesaikan tugas dan memberikan pembinaan.';
    } else {
        return 'Memberikan teguran dan pembinaan kepada siswa agar tidak mengulangi pelanggaran.';
    }
}

// ====================================
// AMBIL DATA PELANGGARAN BELUM DITINDAK
// ====================================

$query = "SELECT
            ps.id,
            ps.nama_siswa,
            ps.nama_kelas,
            ps.nama_pelanggaran,
            ps.tanggal,
            ps.keterangan,
            ps.tindakan,
            ps.poin,
            ps.status
          FROM t_pelanggaran_siswa ps
          WHERE ps.tindakan IS NULL
             OR TRIM(ps.tindakan) = ''
          ORDER BY ps.tanggal DESC, ps.id DESC";

$hasil = mysqli_query($koneksi, $query);

if (!$hasil) {
    die('Gagal mengambil data: ' . mysqli_error($koneksi));
}

$jumlahData = mysqli_num_rows($hasil);

$no = 1;
$totalPoin = 0;

function e($value)
{
    return htmlspecialchars(
        (string) ($value ?? '-'),
        ENT_QUOTES,
        'UTF-8'
    );
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cetak Laporan Tindakan Pelanggaran Siswa</title>

    <style>

        @page {
            size: A4 landscape;
            margin: 1.5cm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 11pt;
            color: #000;
            background: white;
        }

        .container {
            width: 100%;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px double black;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .kop-surat h2 {
            font-size: 18pt;
            margin: 0 0 5px;
            font-weight: bold;
        }

        .kop-surat h3 {
            font-size: 13pt;
            margin: 5px 0;
        }

        .kop-surat p {
            font-size: 10pt;
            margin: 3px;
        }

        .judul {
            text-align: center;
            margin: 20px 0;
        }

        .judul h3 {
            text-decoration: underline;
            margin-bottom: 5px;
        }

        .judul p {
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 7px;
            vertical-align: middle;
        }

        table th {
            text-align: center;
            font-weight: bold;
            background: #eeeeee;
        }

        .text-center {
            text-align: center;
        }

        .ringkasan {
            margin-top: 12px;
        }

        .tanggal {
            text-align: right;
            margin-top: 25px;
        }

        .ttd {
            width: 100%;
            margin-top: 35px;
            text-align: center;
        }

        .ttd td {
            width: 50%;
            border: none;
            vertical-align: top;
            height: 120px;
        }

        .nama {
            font-weight: bold;
            text-decoration: underline;
        }

        .tombol {
            margin-bottom: 20px;
        }

        .tombol button {
            padding: 9px 18px;
            cursor: pointer;
        }

        @media print {

            .tombol {
                display: none;
            }

            thead {
                display: table-header-group;
            }

            tr {
                page-break-inside: avoid;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <!-- TOMBOL CETAK -->
    <div class="tombol">

        <button onclick="window.print()">
            Cetak Laporan
        </button>

        <button onclick="window.close()">
            Tutup
        </button>

    </div>

    <!-- KOP SEKOLAH -->
    <div class="kop-surat">

        <h2>SMK MUHAMMADIYAH KOTA TASIKMALAYA</h2>

        <h3>LAPORAN TINDAKAN PELANGGARAN SISWA</h3>

        <p>Alamat: ...............................................................</p>

        <p>
            Telepon: ........................ |
            Email: ........................
        </p>

    </div>

    <!-- JUDUL LAPORAN -->
    <div class="judul">

        <h3>LAPORAN DATA PELANGGARAN SISWA</h3>

        <p>
            Dicetak pada:
            <?php echo date('d-m-Y'); ?>
        </p>

    </div>

    <!-- TABEL DATA -->
    <table>

        <thead>

            <tr>
                <th style="width: 35px;">No.</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Nama Pelanggaran</th>
                <th>Tanggal</th>
                <th style="width: 55px;">Poin</th>
                <th>Keterangan</th>
                <th>Tindakan</th>
            </tr>

        </thead>

        <tbody>

            <?php if ($jumlahData > 0) { ?>

                <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>

                    <?php

                    $tindakanOtomatis = tentukanTindakan(
                        $row['nama_pelanggaran']
                    );

                    $totalPoin += (int) $row['poin'];

                    ?>

                    <tr>

                        <td class="text-center">
                            <?php echo $no++; ?>
                        </td>

                        <td>
                            <?php echo e($row['nama_siswa']); ?>
                        </td>

                        <td>
                            <?php echo e($row['nama_kelas']); ?>
                        </td>

                        <td>
                            <?php echo e($row['nama_pelanggaran']); ?>
                        </td>

                        <td class="text-center">
                            <?php echo e($row['tanggal']); ?>
                        </td>

                        <td class="text-center">
                            <?php echo e($row['poin']); ?>
                        </td>

                        <td>
                            <?php echo e($row['keterangan']); ?>
                        </td>

                        <td>
                            <?php echo e($tindakanOtomatis); ?>
                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td colspan="8" class="text-center">
                        Tidak ada data pelanggaran yang belum ditindak.
                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

    <!-- RINGKASAN -->
    <div class="ringkasan">

        <strong>
            Jumlah Data:
            <?php echo $jumlahData; ?> data
        </strong>

        <br>

        <strong>
            Total Poin:
            <?php echo $totalPoin; ?> poin
        </strong>

    </div>

    <!-- TANGGAL -->
    <div class="tanggal">

        Tasikmalaya, <?php echo date('d-m-Y'); ?>

    </div>

    <!-- TANDA TANGAN -->
    <table class="ttd">

        <tr>

            <td>

                Mengetahui,<br>
                Kepala Sekolah

                <br><br><br><br>

                <span class="nama">
                    (...................................)
                </span>

            </td>

            <td>

                Petugas / Guru

                <br><br><br><br><br>

                <span class="nama">
                    (...................................)
                </span>

            </td>

        </tr>

    </table>

</div>

</body>
</html>
