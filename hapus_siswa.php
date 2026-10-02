<?php
// hapus_siswa.php
session_start();

include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = $_GET['id'];

// Ambil nama siswa sebelum dihapus
$cek = mysqli_query(
    $koneksi,
    "SELECT nama FROM t_siswa WHERE id = '$id'"
);

$data = mysqli_fetch_assoc($cek);

// Hapus data siswa
$sql = "DELETE FROM t_siswa WHERE id = '$id'";

if (mysqli_query($koneksi, $sql)) {

    $id_user = $_SESSION['id_user'];
    $waktu = date('Y-m-d H:i:s');

    $aktivitas = "hapus siswa: " . $data['nama'];

    // Simpan aktivitas ke tabel log
    $log = "INSERT INTO tbl_log
            (id_user, aktivitas, waktu)
            VALUES
            ('$id_user', '$aktivitas', '$waktu')";

    mysqli_query($koneksi, $log);
}

header('Location: kelola_siswa.php');
exit;
?>