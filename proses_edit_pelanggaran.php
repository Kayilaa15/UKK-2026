<?php
// proses_edit_pelanggaran_kategori.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = $_POST['id'];
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
$status_aktif = $_POST['status_aktif'];

$sql = "UPDATE t_pelanggaran_kategori SET
        nama = '$nama',
        deskripsi = '$deskripsi',
        status_aktif = '$status_aktif',
        updated_at = CURRENT_TIMESTAMP
        WHERE id = '$id'";

if (mysqli_query($koneksi, $sql)) {

    header("Location: kelola_pelanggaran_kategori.php");
    exit;

} else {

    echo "Gagal mengubah data kategori pelanggaran: "
         . mysqli_error($koneksi);

}
?>