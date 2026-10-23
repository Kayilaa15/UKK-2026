<?php
// about_me.php

include 'includes/cek_session.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About Me</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php include 'layout/sidebar.php'; ?>

            <main class="col-md-9 col-lg-10 p-4">

                <!-- Judul Halaman -->
                <h2 class="mb-3">About Me</h2>

                <p class="text-muted mb-4">
                    Kenali lebih dekat profil pembuat aplikasi.
                </p>

                <!-- Tombol Kembali -->
                <div class="mb-4">
                    <a href="dashboard.php" class="btn btn-secondary">
                        Kembali ke Dashboard
                    </a>
                </div>

                <!-- Card Profil -->
                <div class="card shadow-sm">

                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Profil Saya</h5>
                    </div>

                    <div class="card-body">

                        <div class="row align-items-center">

                            <!-- Foto Profil -->
                            <div class="col-md-4 text-center mb-4">
                                <img
                                    src="assets/foto_profil.jpg"
                                    alt="Foto Profil"
                                    class="img-fluid rounded-circle img-thumbnail mb-3"
                                    width="220">

                                <h4>Kayila Nur Fadilah</h4>

                                <p class="text-muted">
                                    Siswa Rekayasa Perangkat Lunak
                                </p>
                            </div>

                            <!-- Informasi Profil -->
                            <div class="col-md-8">

                                <h5 class="text-primary mb-3">
                                    Tentang Saya
                                </h5>

                                <p>
                                    Halo! Perkenalkan, nama saya Kayila Nur Fadilah.
                                    Saya merupakan siswa jurusan Rekayasa Perangkat
                                    Lunak (RPL) yang tertarik mempelajari teknologi
                                    dan pengembangan aplikasi berbasis web.
                                </p>

                                <hr>

                                <h5 class="text-primary mb-3">
                                    Informasi Pribadi
                                </h5>

                                <table class="table table-bordered">
                                    <tr>
                                        <th width="35%">Nama</th>
                                        <td>Kayila Nur Fadilah</td>
                                    </tr>

                                    <tr>
                                        <th>Sekolah</th>
                                        <td>SMK Muhammadiyah Kota Tasikmalaya</td>
                                    </tr>

                                    <tr>
                                        <th>Kelas</th>
                                        <td>XI RPL 1</td>
                                    </tr>

                                    <tr>
                                        <th>Jurusan</th>
                                        <td>Rekayasa Perangkat Lunak</td>
                                    </tr>
                                </table>

                                <hr>

                                <h5 class="text-primary mb-3">
                                    Keahlian
                                </h5>

                                <span class="badge bg-primary">HTML</span>
                                <span class="badge bg-primary">CSS</span>
                                <span class="badge bg-primary">PHP</span>
                                <span class="badge bg-primary">MySQL</span>
                                <span class="badge bg-primary">Bootstrap</span>

                            </div>

                        </div>

                        <hr>

                        <!-- Tentang Aplikasi -->
                        <h5 class="text-primary mb-3">
                            Tentang Aplikasi
                        </h5>

                        <p>
                            Aplikasi ini merupakan sistem pengelolaan pelanggaran
                            siswa yang dibuat untuk membantu proses pengelolaan
                            data kategori pelanggaran, jenis pelanggaran, dan
                            informasi terkait secara lebih terstruktur dan efisien.
                        </p>

                    </div>

                    <div class="card-footer text-center text-muted">
                        &copy; <?= date('Y'); ?> Kayila Nur Fadilah
                    </div>

                </div>

            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
