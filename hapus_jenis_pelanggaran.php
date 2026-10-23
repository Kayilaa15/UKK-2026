<?php
// hapus_jenis_pelanggaran.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['pesan_error'] = 'ID jenis pelanggaran tidak valid.';
    header('Location: kelola_jenis_pelanggaran.php');
    exit;
}

// Periksa apakah data tersedia
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT nama FROM t_pelanggaran WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

mysqli_stmt_close($stmt);

if (!$data) {
    $_SESSION['pesan_error'] = 'Data jenis pelanggaran tidak ditemukan.';
    header('Location: kelola_jenis_pelanggaran.php');
    exit;
}

// Hapus data
$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM t_pelanggaran WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);

    $_SESSION['pesan_sukses'] =
        'Jenis pelanggaran "' . $data['nama'] .
        '" berhasil dihapus.';

    header('Location: kelola_jenis_pelanggaran.php');
    exit;
}

$kode_error = mysqli_stmt_errno($stmt);
mysqli_stmt_close($stmt);

if ($kode_error === 1451) {
    $_SESSION['pesan_error'] =
        'Data tidak dapat dihapus karena sudah digunakan dalam catatan pelanggaran siswa. Nonaktifkan data jika masih diperlukan.';
} else {
    $_SESSION['pesan_error'] =
        'Gagal menghapus jenis pelanggaran.';
}

header('Location: kelola_jenis_pelanggaran.php');
exit;
?>