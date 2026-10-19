<?php
session_start();
include "config/koneksi.php";


$nama = "Kayila Nur Fadilah";
$kelas = "XII RPL";
$sekolah = "SMK Muhammadiyah Tasikmalaya";
$jurusan = "Rekayasa Perangkat Lunak";
$hobi = "Baca Buku ";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Tentang Saya</title>
</head>
<body>
    <div class="container-fluid">
    <div class="row">
        <?php
            include 'layout/sidebar.php';
        ?>
        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <div class="container-fluid">
    <div class="row">
        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">

    <h2>Tentang Saya</h2>

    <p>Nama: <?php echo $nama; ?></p>
    <p>Kelas: <?php echo $kelas; ?></p>
    <p>Sekolah: <?php echo $sekolah; ?></p>
    <p>Jurusan: <?php echo $jurusan; ?></p>
    <p>Hobi: <?php echo $hobi; ?></p>

    <h3>Deskripsi Diri</h3>
    <p>
        Saya adalah seorang pelajar yang sedang belajar
        Rekayasa Perangkat Lunak. Saya senang mempelajari
        teknologi dan membuat website. Saya ingin terus
        belajar agar bisa menjadi Web Developer.
    </p>

    <a href="dashboard.php">Kembali ke Dashboard</a>

</body>
</html>