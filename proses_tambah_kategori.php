<?php
// proses_tambah_pelanggaran_kategori.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
$status_aktif = $_POST['status_aktif'];

$sql = "INSERT INTO t_pelanggaran_kategori
        (nama, deskripsi, status_aktif)
        VALUES
        ('$nama', '$deskripsi', '$status_aktif')";

if (mysqli_query($koneksi, $sql)) {

    header("Location: kelola_pelanggaran_kategori.php");
    exit;

} else {

    echo "Gagal menambahkan data kategori pelanggaran: "
         . mysqli_error($koneksi);

}
?>