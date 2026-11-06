<?php
// proses_tambah_wali_kelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil data dari form
$guru_id = $_POST['guru_id'];
$kelas_id = $_POST['kelas_id'];
$tahun_ajaran_id = $_POST['tahun_ajaran_id'];

// Cek data kosong
if ($guru_id == '' || $kelas_id == '' || $tahun_ajaran_id == '') {
    $_SESSION['pesan_error'] = "Semua data harus diisi!";
    header("Location: tambah_wali_kelas.php");
    exit;
}

// Simpan data wali kelas
$sql = "INSERT INTO t_wali_kelas
        (guru_id, kelas_id, tahun_ajaran_id, created_at, updated_at)
        VALUES
        ('$guru_id', '$kelas_id', '$tahun_ajaran_id', NOW(), NOW())";

if (mysqli_query($koneksi, $sql)) {
    $_SESSION['pesan_sukses'] = "Wali kelas berhasil ditambahkan!";
    header("Location: kelola_wali_kelas.php");
    exit;
} else {
    $_SESSION['pesan_error'] = "Wali kelas gagal ditambahkan!";
    header("Location: tambah_wali_kelas.php");
    exit;
}
?>