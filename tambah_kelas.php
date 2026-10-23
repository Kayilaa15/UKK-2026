<?php
// tambah_kelas.php
include 'includes/cek_session.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Kelas</title>

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

            <h1 class="mb-4">Tambah Kelas</h1>

            <div class="mb-3">
                <a href="kelola_kelas.php" class="btn btn-secondary">
                    Kembali ke Data Kelas
                </a>
            </div>

            <!-- FORM TAMBAH KELAS -->
            <div class="card shadow-sm mb-4">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Tambah Kelas</h5>
                </div>

                <div class="card-body">

                    <form action="proses_tambah_kelas.php" method="POST">

                        <!-- Nama Kelas -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                Nama Kelas
                            </label>

                            <input type="text"
                                   name="nama"
                                   id="nama"
                                   class="form-control"
                                   maxlength="100"
                                   placeholder="Contoh: XII RPL 1"
                                   required>
                        </div>

                        <!-- Tingkat -->
                        <div class="mb-3">
                            <label for="tingkat" class="form-label">
                                Tingkat
                            </label>

                            <select name="tingkat"
                                    id="tingkat"
                                    class="form-select"
                                    required>
                                <option value="">-- Pilih Tingkat --</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>

                        <!-- Jurusan -->
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">
                                Jurusan
                            </label>

                            <input type="text"
                                   name="jurusan"
                                   id="jurusan"
                                   class="form-control"
                                   maxlength="100"
                                   placeholder="Contoh: RPL"
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

                        <!-- Tombol -->
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>

                        <a href="kelola_kelas.php" class="btn btn-secondary">
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
