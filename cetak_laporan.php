
<?php
// cetak_laporan.php

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
// QUERY DATA LAPORAN
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

// Guru hanya melihat laporan kelas tanggung jawabnya
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

// ==========================================
// EKSEKUSI QUERY
// ==========================================
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
// TANGGAL INDONESIA
// ==========================================
$bulanIndonesia = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];

$tanggalCetak = date('d') . ' ' .
    $bulanIndonesia[(int)date('m')] . ' ' .
    date('Y');

// ==========================================
// EXPORT EXCEL
// ==========================================
if (isset($_GET['export']) && $_GET['export'] === 'excel') {

    header("Content-Type: application/vnd.ms-excel; charset=utf-8");

    header("Content-Disposition: attachment; filename=laporan_pelanggaran.xls");

    header("Pragma: no-cache");

    header("Expires: 0");

    echo "\xEF\xBB\xBF";

    echo '<table border="1">';

    echo '<tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Nama Pelanggaran</th>
            <th>Guru Pencatat</th>
            <th>Tanggal</th>
            <th>Poin</th>
            <th>Tindakan</th>
            <th>Status</th>
          </tr>';

    $no = 1;

    while ($row = mysqli_fetch_assoc($hasil)) {

        echo '<tr>';

        echo '<td>' . $no++ . '</td>';

        echo '<td>' . htmlspecialchars($row['nama_siswa'] ?? '-', ENT_QUOTES, 'UTF-8') . '</td>';

        echo '<td>' . htmlspecialchars($row['nama_kelas'] ?? '-', ENT_QUOTES, 'UTF-8') . '</td>';

        echo '<td>' . htmlspecialchars($row['nama_pelanggaran'] ?? '-', ENT_QUOTES, 'UTF-8') . '</td>';

        echo '<td>' . htmlspecialchars($row['nama_guru'] ?? '-', ENT_QUOTES, 'UTF-8') . '</td>';

        echo '<td>' . htmlspecialchars($row['tanggal'] ?? '-', ENT_QUOTES, 'UTF-8') . '</td>';

        echo '<td>' . (int)$row['poin'] . '</td>';

        echo '<td>' . htmlspecialchars($row['tindakan'] ?? '-', ENT_QUOTES, 'UTF-8') . '</td>';

        echo '<td>' . htmlspecialchars($row['status'] ?? '-', ENT_QUOTES, 'UTF-8') . '</td>';

        echo '</tr>';
    }

    echo '</table>';

    mysqli_stmt_close($stmt);

    exit;
}

// ==========================================
// LINK EXPORT EXCEL
// ==========================================
$queryExcel = http_build_query([
    'export' => 'excel',
    'tanggal_mulai' => $tanggal_mulai,
    'tanggal_selesai' => $tanggal_selesai
]);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cetak Laporan Pelanggaran Siswa</title>

    <style>

        /* ==================================
           TAMPILAN HALAMAN
        ================================== */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            background: #e9ecef;
            font-family: "Times New Roman", serif;
            color: black;
        }

        .area-cetak {
            width: 100%;
            max-width: 1100px;
            margin: 20px auto;
            padding: 30px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.12);
        }

        .tombol-aksi {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            display: inline-block;
            padding: 9px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-cetak {
            background: #dc3545;
            color: white;
        }

        .btn-excel {
            background: #198754;
            color: white;
        }

        .btn-kembali {
            background: #6c757d;
            color: white;
        }

        /* ==================================
           KOP SEKOLAH
        ================================== */

        .kop-surat {
            text-align: center;
            margin-bottom: 15px;
        }

        .kop-surat h2 {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 5px;
        }

        .kop-surat p {
            font-size: 11pt;
            margin: 0;
        }

        .garis-kop {
            border-top: 3px solid black;
            border-bottom: 1px solid black;
            height: 5px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        /* ==================================
           JUDUL LAPORAN
        ================================== */

        .judul-cetak {
            text-align: center;
            margin-bottom: 20px;
        }

        .judul-cetak h3 {
            font-size: 16pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
        }

        .judul-cetak p {
            font-size: 12pt;
            margin: 0;
        }

        /* ==================================
           INFORMASI LAPORAN
        ================================== */

        .informasi-laporan {
            font-size: 11pt;
            margin-bottom: 12px;
        }

        .informasi-laporan table {
            border: none;
        }

        .informasi-laporan td {
            border: none;
            padding: 3px 0;
        }

        /* ==================================
           TABEL
        ================================== */

        .tabel-laporan {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }

        .tabel-laporan th,
        .tabel-laporan td {
            border: 1px solid black;
            padding: 7px 6px;
            vertical-align: middle;
        }

        .tabel-laporan th {
            text-align: center;
            font-weight: bold;
            background: #e5e5e5;
        }

        .tabel-laporan td:nth-child(1),
        .tabel-laporan td:nth-child(6),
        .tabel-laporan td:nth-child(7),
        .tabel-laporan td:nth-child(9) {
            text-align: center;
        }

        .tabel-laporan tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        /* ==================================
           TANDA TANGAN
        ================================== */

        .bagian-tanda-tangan {
            display: flex;
            justify-content: flex-end;
            margin-top: 35px;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .tanda-tangan {
            width: 250px;
            text-align: center;
            font-size: 12pt;
            line-height: 1.5;
        }

        .ruang-ttd {
            height: 75px;
        }

        .nama-penandatangan {
            font-weight: bold;
            text-decoration: underline;
        }

        /* ==================================
           FORMAT CETAK PDF
        ================================== */

        @media print {

            @page {
                size: A4 landscape;
                margin: 15mm;
            }

            html,
            body {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                font-family: "Times New Roman", serif !important;
                color: black !important;
            }

            /* SEMBUNYIKAN SEMUA ELEMEN WEBSITE */
            body * {
                visibility: hidden !important;
            }

            /* HANYA DOKUMEN YANG DICETAK */
            #dokumenCetak,
            #dokumenCetak * {
                visibility: visible !important;
            }

            #dokumenCetak {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                box-shadow: none !important;
            }

            /* SEMBUNYIKAN TOMBOL */
            .tombol-aksi {
                display: none !important;
            }

            .kop-surat {
                display: block !important;
            }

            .judul-cetak {
                display: block !important;
            }

            .informasi-laporan {
                display: block !important;
            }

            /* TABEL */
            .tabel-laporan {
                width: 100% !important;
                border-collapse: collapse !important;
                font-size: 9pt !important;
            }

            .tabel-laporan thead {
                display: table-header-group;
            }

            .tabel-laporan th,
            .tabel-laporan td {
                border: 1px solid black !important;
                padding: 6px !important;
                color: black !important;
                background: white !important;
            }

            .tabel-laporan th {
                background: #e5e5e5 !important;
                text-align: center !important;
            }

            .tabel-laporan tr {
                page-break-inside: avoid !important;
            }

            /* TANDA TANGAN */
            .bagian-tanda-tangan {
                display: flex !important;
                justify-content: flex-end !important;
                margin-top: 35px;
                page-break-inside: avoid !important;
            }

        }

    </style>

</head>

<body>

    <!-- ==================================
         TOMBOL AKSI (TIDAK IKUT CETAK)
    ================================== -->

    <div class="tombol-aksi">

        <a href="laporan.php"
           class="btn btn-kembali">

            Kembali

        </a>

        <a href="cetak_laporan.php?<?= htmlspecialchars($queryExcel, ENT_QUOTES, 'UTF-8'); ?>"
           class="btn btn-excel">

            Export Excel

        </a>

        <button type="button"
                onclick="window.print()"
                class="btn btn-cetak">

            Cetak PDF

        </button>

    </div>

    <!-- ==================================
         DOKUMEN LAPORAN
    ================================== -->

    <div class="area-cetak" id="dokumenCetak">

        <!-- KOP SEKOLAH -->
        <div class="kop-surat">

            <h2>
                SMK Muhammadiyah Kota Tasikmalaya
            </h2>

            <p>
                LAPORAN DATA PELANGGARAN SISWA
            </p>

            <div class="garis-kop"></div>

        </div>

        <!-- JUDUL -->
        <div class="judul-cetak">

            <h3>
                LAPORAN DATA PELANGGARAN SISWA
            </h3>

            <p>
                Tahun Pelaporan <?= date('Y'); ?>
            </p>

        </div>

        <!-- INFORMASI LAPORAN -->
        <div class="informasi-laporan">

            <table>

                <tr>

                    <td style="width:150px;">
                        Tanggal Cetak
                    </td>

                    <td>
                        :
                        <?= htmlspecialchars($tanggalCetak, ENT_QUOTES, 'UTF-8'); ?>
                    </td>

                </tr>

                <tr>

                    <td>
                        Periode Laporan
                    </td>

                    <td>

                        :

                        <?= $tanggal_mulai !== ''
                            ? htmlspecialchars(
                                date('d-m-Y', strtotime($tanggal_mulai)),
                                ENT_QUOTES,
                                'UTF-8'
                            )
                            : 'Semua tanggal'; ?>

                        s/d

                        <?= $tanggal_selesai !== ''
                            ? htmlspecialchars(
                                date('d-m-Y', strtotime($tanggal_selesai)),
                                ENT_QUOTES,
                                'UTF-8'
                            )
                            : 'Semua tanggal'; ?>

                    </td>

                </tr>

            </table>

        </div>

        <!-- TABEL LAPORAN -->
        <table class="tabel-laporan">

            <thead>

                <tr>

                    <th style="width:40px;">No.</th>

                    <th>Nama Siswa</th>

                    <th>Kelas</th>

                    <th>Nama Pelanggaran</th>

                    <th>Guru Pencatat</th>

                    <th>Tanggal</th>

                    <th style="width:55px;">Poin</th>

                    <th>Tindakan</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                <?php

                $no = 1;

                $jumlahData = 0;

                while ($row = mysqli_fetch_assoc($hasil)) {

                    $jumlahData++;

                ?>

                    <tr>

                        <td>
                            <?= $no++; ?>
                        </td>

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
                            <?= (int)$row['poin']; ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['tindakan'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['status'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                        </td>

                    </tr>

                <?php } ?>

                <?php if ($jumlahData === 0) { ?>

                    <tr>

                        <td colspan="9" style="text-align:center;">
                            Belum ada data pelanggaran siswa.
                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

        <!-- TANDA TANGAN -->
        <div class="bagian-tanda-tangan">

            <div class="tanda-tangan">

                <p>
                    Tasikmalaya, <?= htmlspecialchars($tanggalCetak, ENT_QUOTES, 'UTF-8'); ?>
                </p>

                <p>
                    Mengetahui,
                </p>

                <p>
                    Kepala Sekolah
                </p>

                <div class="ruang-ttd"></div>

                <p class="nama-penandatangan">
                    (........................................)
                </p>

                <p>
                    NIP. ................................
                </p>

            </div>

        </div>

    </div>

</body>

</html>

<?php
mysqli_stmt_close($stmt);
?>
