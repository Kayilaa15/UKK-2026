<?php
// tambah_guru.php
include 'includes/cek_session.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Guru</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">

            <h1 class="mb-4">Tambah Guru</h1>

            <div class="mb-3">
                <a href="kelola_guru.php" class="btn btn-secondary">
                    Kembali ke Data Guru
                </a>
            </div>

            <!-- PESAN ERROR -->
            <?php if (isset($_SESSION['pesan_error'])) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['pesan_error']); ?>
                </div>
                <?php unset($_SESSION['pesan_error']); ?>
            <?php } ?>

            <!-- FORM TAMBAH GURU -->
            <div class="card shadow-sm mb-4">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Tambah Guru</h5>
                </div>

                <div class="card-body">

                    <form action="proses_tambah_guru.php" method="POST">

            <!-- NIP -->
            <div class="col-md-6">
                <label class="form-label">NIP</label>
                <input type="text" name="nip"
                    class="form-control"
                    placeholder="Masukkan NIP"
                    maxlength="18"
                    required>
                <small class="text-muted">NIP maksimal 18 digit.</small>
            </div>

                        <!-- NAMA GURU -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Guru</label>

                            <input type="text"
                                   name="nama"
                                   id="nama"
                                   class="form-control"
                                   maxlength="150"
                                   required>
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>

                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control"
                                   maxlength="150"
                                   required>
                        </div>
                        <!-- PASSWORD -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password"
                               class="form-control"
                               placeholder="Masukkan Password"
                               minlength="6"
                               required>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_password"
                               class="form-control"
                               placeholder="Ulangi Password"
                               minlength="6"
                               required>
                    </div>

                        <!-- STATUS AKTIF -->
                        <div class="mb-3">
                            <label for="status_aktif" class="form-label">
                                Status Aktif
                            </label>

                            <select name="status_aktif"
                                    id="status_aktif"
                                    class="form-select"
                                    required>

                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>

                            </select>
                        </div>

                        <!-- TOMBOL -->
                        <button type="submit" class="btn btn-primary">
                            Simpan Guru
                        </button>

                        <a href="kelola_guru.php" class="btn btn-secondary">
                            Batal
                        </a>

                    </form>

                </div>
            </div>

        </main>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
