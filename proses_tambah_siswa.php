<?php
// proses_tambah_siswa.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$nis = $_POST['nis'];
$nisn = $_POST['nisn'];
$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];
$status_aktif = $_POST['status_aktif'];

$sql = "INSERT INTO t_siswa
        (nis, nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status_aktif)
        VALUES
        ('$nis', '$nisn', '$nama', '$jenis_kelamin', '$tanggal_lahir', '$alamat', '$status_aktif')";

if (mysqli_query($koneksi, $sql)) {

    header("Location: kelola_siswa.php");
    exit;

} else {

    echo "Gagal menambahkan data siswa: " . mysqli_error($koneksi);

}
?>