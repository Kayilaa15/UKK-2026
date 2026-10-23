<?php
// tambah_tahun_ajaran.php
include 'includes/cek_session.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Tahun Ajaran</title>

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

            <h1 class="mb-4">Tambah Tahun Ajaran</h1>

            <div class="mb-3">
                <a href="kelola_tahun_ajaran.php" class="btn btn-secondary">
                    Kembali ke Data Tahun Ajaran
                </a>
            </div>

            <!-- FORM TAMBAH TAHUN AJARAN -->
            <div class="card shadow-sm mb-4">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Tambah Tahun Ajaran</h5>
                </div>

                <div class="card-body">

                    <form action="proses_tambah_tahun_ajaran.php" method="POST">

                        <!-- Nama Tahun Ajaran -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                Nama Tahun Ajaran
                            </label>

                            <input type="text"
                                   name="nama"
                                   id="nama"
                                   class="form-control"
                                   placeholder="Contoh: 2026/2027"
                                   maxlength="20"
                                   required>
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">
                                Tanggal Mulai
                            </label>

                            <input type="date"
                                   name="tanggal_mulai"
                                   id="tanggal_mulai"
                                   class="form-control"
                                   required>
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">
                                Tanggal Selesai
                            </label>

                            <input type="date"
                                   name="tanggal_selesai"
                                   id="tanggal_selesai"
                                   class="form-control"
                                   required>
                        </div>

                        <!-- Status Aktif -->
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

                        <!-- Tombol Simpan -->
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>

                        <a href="kelola_tahun_ajaran.php"
                           class="btn btn-secondary">
                            Batal
                        </a>

                    </form>

                </div>
            </div>

        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
