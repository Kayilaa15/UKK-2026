<?php
// proses_tambah_walikelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$tahun_ajaran_id = $_POST['tahun_ajaran_id'];
$kelas_id = $_POST['kelas_id'];
$guru_id = $_POST['guru_id'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$status_aktif = $_POST['status_aktif'];

if ($tanggal_selesai < $tanggal_mulai) {
    exit('Tanggal selesai tidak boleh lebih awal dari tanggal mulai.');
}

$sql = "INSERT INTO t_walikelas
        (tahun_ajaran_id, kelas_id, guru_id,
         tanggal_mulai, tanggal_selesai, status_aktif)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "iiissi",
    $tahun_ajaran_id,
    $kelas_id,
    $guru_id,
    $tanggal_mulai,
    $tanggal_selesai,
    $status_aktif
);

if (mysqli_stmt_execute($stmt)) {
    header("Location: kelola_walikelas.php");
    exit;
} else {
    echo "Gagal menambahkan wali kelas: "
        . mysqli_stmt_error($stmt);
}
?>