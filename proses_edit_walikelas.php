<?php
// proses_edit_walikelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = (int) ($_POST['id'] ?? 0);
$tahun_ajaran_id = (int) $_POST['tahun_ajaran_id'];
$kelas_id = (int) $_POST['kelas_id'];
$guru_id = (int) $_POST['guru_id'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$status_aktif = (int) $_POST['status_aktif'];

if ($tanggal_selesai < $tanggal_mulai) {
    exit('Tanggal selesai tidak boleh lebih awal dari tanggal mulai.');
}

$sql = "UPDATE t_walikelas SET
        tahun_ajaran_id = ?,
        kelas_id = ?,
        guru_id = ?,
        tanggal_mulai = ?,
        tanggal_selesai = ?,
        status_aktif = ?,
        updated_at = CURRENT_TIMESTAMP
        WHERE id = ?";

$stmt = mysqli_prepare($koneksi, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "iiissii",
    $tahun_ajaran_id,
    $kelas_id,
    $guru_id,
    $tanggal_mulai,
    $tanggal_selesai,
    $status_aktif,
    $id
);

if (mysqli_stmt_execute($stmt)) {
    header("Location: kelola_walikelas.php");
    exit;
} else {
    echo "Gagal mengubah data wali kelas: "
        . mysqli_stmt_error($stmt);
}
?>