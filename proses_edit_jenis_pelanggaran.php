<?php
// proses_edit_jenis_pelanggaran.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kelola_jenis_pelanggaran.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

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
    !$id ||
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
    header('Location: kelola_jenis_pelanggaran.php');
    exit;
}

// Pastikan data yang akan diedit tersedia
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_pelanggaran WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil_data = mysqli_stmt_get_result($stmt);
$data_ada = mysqli_num_rows($hasil_data) > 0;

mysqli_stmt_close($stmt);

if (!$data_ada) {
    $_SESSION['pesan_error'] = 'Data jenis pelanggaran tidak ditemukan.';
    header('Location: kelola_jenis_pelanggaran.php');
    exit;
}

// Pastikan kategori tersedia
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_pelanggaran_kategori WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $kategori_id);
mysqli_stmt_execute($stmt);

$hasil_kategori = mysqli_stmt_get_result($stmt);
$kategori_ada = mysqli_num_rows($hasil_kategori) > 0;

mysqli_stmt_close($stmt);

if (!$kategori_ada) {
    $_SESSION['pesan_error'] = 'Kategori pelanggaran tidak ditemukan.';
    header('Location: edit_jenis_pelanggaran.php?id=' . $id);
    exit;
}

// Update data
$sql = "UPDATE t_pelanggaran
        SET pelanggaran_kategori_id = ?,
            kode = ?,
            nama = ?,
            poin = ?,
            deskripsi = ?,
            status_aktif = ?
        WHERE id = ?";

$stmt = mysqli_prepare($koneksi, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "issisii",
    $kategori_id,
    $kode,
    $nama,
    $poin,
    $deskripsi,
    $status_aktif,
    $id
);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);

    $_SESSION['pesan_sukses'] =
        'Jenis pelanggaran berhasil diperbarui.';

    header('Location: kelola_jenis_pelanggaran.php');
    exit;
}

$kode_error = mysqli_stmt_errno($stmt);
mysqli_stmt_close($stmt);

if ($kode_error === 1062) {
    $_SESSION['pesan_error'] = 'Kode pelanggaran sudah digunakan.';
} else {
    $_SESSION['pesan_error'] = 'Gagal memperbarui data jenis pelanggaran.';
}

header('Location: edit_jenis_pelanggaran.php?id=' . $id);
exit;
?>