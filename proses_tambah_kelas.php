<?php
// proses_tambah_kelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$nama = $_POST['nama'];
$tingkat = $_POST['tingkat'];
$jurusan = $_POST['jurusan'];
$status_aktif = $_POST['status_aktif'];

$sql = "INSERT INTO t_kelas
        (nama, tingkat, jurusan, status_aktif)
        VALUES
        ('$nama', '$tingkat', '$jurusan', '$status_aktif')";

if (mysqli_query($koneksi, $sql)) {

    header("Location: kelola_kelas.php");
    exit;

} else {

    echo "Gagal menambahkan data kelas: " . mysqli_error($koneksi);

}
?>