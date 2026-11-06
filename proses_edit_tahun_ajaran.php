<?php
// proses_edit_tahun_ajaran.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// 1. Mengambil data dari form
$id = $_POST['id'];
$nama = $_POST['nama'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$status_aktif = $_POST['status_aktif'];

// 2. Memeriksa apakah semua data sudah diisi
if ($nama == '' || $tanggal_mulai == '' || $tanggal_selesai == '') {

    $_SESSION['pesan_error'] = "Semua data harus diisi!";
    header("Location: edit_tahun_ajaran.php?id=$id");
    exit;
}

// 3. Memeriksa tanggal
if ($tanggal_selesai < $tanggal_mulai) {

    $_SESSION['pesan_error'] = "Tanggal selesai tidak boleh sebelum tanggal mulai!";
    header("Location: edit_tahun_ajaran.php?id=$id");
    exit;
}

// 4. Memeriksa status aktif
if ($status_aktif == 1) {

    // Mencari tahun ajaran lain yang sudah aktif
    $cek = mysqli_query($koneksi, "
        SELECT * FROM t_tahun_ajaran
        WHERE status_aktif = 1
        AND id != '$id'
    ");

    // Jika sudah ada tahun ajaran lain yang aktif
    if (mysqli_num_rows($cek) > 0) {

        $_SESSION['pesan_error'] = "Gagal! Sudah ada tahun ajaran lain yang aktif. Nonaktifkan terlebih dahulu tahun ajaran sebelumnya.";

        header("Location: edit_tahun_ajaran.php?id=$id");
        exit;
    }
}

// 5. Mengubah data tahun ajaran
$sql = "UPDATE t_tahun_ajaran SET
        nama = '$nama',
        tanggal_mulai = '$tanggal_mulai',
        tanggal_selesai = '$tanggal_selesai',
        status_aktif = '$status_aktif',
        updated_at = NOW()
        WHERE id = '$id'";

// 6. Menjalankan query
if (mysqli_query($koneksi, $sql)) {

    $_SESSION['pesan_sukses'] = "Tahun ajaran berhasil diubah!";
    header("Location: kelola_tahun_ajaran.php");
    exit;

} else {

    $_SESSION['pesan_error'] = "Tahun ajaran gagal diubah!";
    header("Location: edit_tahun_ajaran.php?id=$id");
    exit;
}

?>