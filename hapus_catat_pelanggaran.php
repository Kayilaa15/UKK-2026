
<?php
// hapus_catat_pelanggaran.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil ID catatan
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['pesan_error'] = "ID catatan pelanggaran tidak valid.";
    header("Location: catat_pelanggaran.php");
    exit;
}

// Cek apakah data tersedia
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_pelanggaran_siswa WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$data) {
    $_SESSION['pesan_error'] = "Data pelanggaran tidak ditemukan.";
    header("Location: catat_pelanggaran.php");
    exit;
}

// Hapus data
$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM t_pelanggaran_siswa WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['pesan_sukses'] = "Catatan pelanggaran berhasil dihapus.";
} else {
    $_SESSION['pesan_error'] = "Gagal menghapus catatan pelanggaran.";
}

mysqli_stmt_close($stmt);

header("Location: catat_pelanggaran.php");
exit;
?>
