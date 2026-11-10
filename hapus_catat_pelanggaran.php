<?php
// hapus_catat_pelanggaran.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['pesan_error'] = 'ID catatan pelanggaran tidak valid.';
    header('Location: catat_pelanggaran.php');
    exit;
}

// Hapus hanya jika status catatan belum Selesai
$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM t_pelanggaran_siswa
     WHERE id = ?
     AND status <> 'Selesai'"
);

if (!$stmt) {
    $_SESSION['pesan_error'] = 'Query hapus gagal diproses: ' . mysqli_error($koneksi);
    header('Location: catat_pelanggaran.php');
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $_SESSION['pesan_sukses'] = 'Catatan pelanggaran berhasil dihapus.';
    } else {
        // Tidak ada baris terhapus: ID tidak ada atau status sudah Selesai
        $cek = mysqli_prepare(
            $koneksi,
            "SELECT status FROM t_pelanggaran_siswa WHERE id = ? LIMIT 1"
        );
        mysqli_stmt_bind_param($cek, "i", $id);
        mysqli_stmt_execute($cek);
        $data = mysqli_fetch_assoc(mysqli_stmt_get_result($cek));
        mysqli_stmt_close($cek);

        if ($data && strcasecmp(trim($data['status']), 'Selesai') === 0) {
            $_SESSION['pesan_error'] = 'Catatan berstatus Selesai tidak dapat dihapus.';
        } else {
            $_SESSION['pesan_error'] = 'Data catatan pelanggaran tidak ditemukan.';
        }
    }
} else {
    $_SESSION['pesan_error'] = 'Gagal menghapus catatan pelanggaran: ' . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);
header('Location: catat_pelanggaran.php');
exit;
?>
