<?php
// proses_tambah_jenis_pelanggaran.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah_jenis_pelanggaran.php');
    exit;
}

$kategori_id = filter_input(
    INPUT_POST,
    'pelanggaran_kategori_id',
    FILTER_VALIDATE_INT
);

$kode = trim($_POST['kode'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$poin = filter_input(INPUT_POST, 'poin', FILTER_VALIDATE_INT);
$deskripsi = trim($_POST['deskripsi'] ?? '');

$status_aktif = filter_input(
    INPUT_POST,
    'status_aktif',
    FILTER_VALIDATE_INT
);

// Validasi input
if (
    !$kategori_id ||
    $kode === '' ||
    $nama === '' ||
    $poin === false ||
    $poin === null ||
    $poin < 0 ||
    !in_array($status_aktif, [0, 1], true) ||
    strlen($kode) > 30 ||
    strlen($nama) > 150
) {
    $_SESSION['pesan_error'] = 'Data tidak valid. Periksa kembali formulir.';
    header('Location: tambah_jenis_pelanggaran.php');
    exit;
}

// Periksa kategori
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id
     FROM t_pelanggaran_kategori
     WHERE id = ? AND status_aktif = 1"
);

mysqli_stmt_bind_param($stmt, "i", $kategori_id);
mysqli_stmt_execute($stmt);

$hasil_kategori = mysqli_stmt_get_result($stmt);
$kategori_ada = mysqli_num_rows($hasil_kategori) > 0;

mysqli_stmt_close($stmt);

if (!$kategori_ada) {
    $_SESSION['pesan_error'] = 'Kategori tidak ditemukan atau tidak aktif.';
    header('Location: tambah_jenis_pelanggaran.php');
    exit;
}

// Simpan data
$sql = "INSERT INTO t_pelanggaran
        (
            pelanggaran_kategori_id,
            kode,
            nama,
            poin,
            deskripsi,
            status_aktif
        )
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "issisi",
    $kategori_id,
    $kode,
    $nama,
    $poin,
    $deskripsi,
    $status_aktif
);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);

    $_SESSION['pesan_sukses'] =
        'Jenis pelanggaran berhasil ditambahkan.';

    header('Location: kelola_jenis_pelanggaran.php');
    exit;
}

$kode_error = mysqli_stmt_errno($stmt);
mysqli_stmt_close($stmt);

if ($kode_error === 1062) {
    $_SESSION['pesan_error'] =
        'Kode pelanggaran sudah digunakan.';
} else {
    $_SESSION['pesan_error'] =
        'Gagal menyimpan jenis pelanggaran.';
}

header('Location: tambah_jenis_pelanggaran.php');
exit;
?>