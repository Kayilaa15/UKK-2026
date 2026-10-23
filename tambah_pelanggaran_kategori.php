<?php
// tambah_pelanggaran_kategori.php
include 'includes/cek_session.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori Pelanggaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <?php include 'layout/sidebar.php'; ?>

        <!-- Konten Utama -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="mb-4">
                <h2 class="mb-3">Tambah Kategori Pelanggaran</h2>

                <a href="kelola_pelanggaran_kategori.php"
                    class="btn btn-secondary">
                    Kembali ke Kategori Pelanggaran
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Form Tambah Kategori Pelanggaran
                </div>

                <div class="card-body">

                    <?php if (isset($_SESSION['pesan_error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= htmlspecialchars($_SESSION['pesan_error']); ?>
                            <button type="button" class="btn-close"
                                    data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['pesan_error']); ?>
                    <?php endif; ?>

                    <form action="proses_tambah_pelanggaran_kategori.php"
                          method="POST">

                        <!-- Nama Kategori -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                Nama Kategori
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="nama"
                                   name="nama"
                                   placeholder="Contoh: Pelanggaran Ringan"
                                   maxlength="100"
                                   required>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">
                                Deskripsi
                            </label>

                            <textarea class="form-control"
                                      id="deskripsi"
                                      name="deskripsi"
                                      rows="4"
                                      placeholder="Masukkan deskripsi kategori pelanggaran"></textarea>
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-3">
                            <label for="status_aktif" class="form-label">
                                Status Aktif
                            </label>

                            <select class="form-select"
                                    id="status_aktif"
                                    name="status_aktif"
                                    required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Simpan Kategori
                            </button>

                            <a href="kelola_pelanggaran_kategori.php"
                               class="btn btn-secondary">
                                Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
