<?php
// tambah_jenis_pelanggaran.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$sql_kategori = "SELECT id, nama
                 FROM t_pelanggaran_kategori
                 WHERE status_aktif = 1
                 ORDER BY nama ASC";

$kategori = mysqli_query($koneksi, $sql_kategori);

if (!$kategori) {
    die("Gagal mengambil kategori: " .
        htmlspecialchars(mysqli_error($koneksi)));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jenis Pelanggaran</title>

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

            <!-- Judul dan Tombol Kembali -->
            <div class="mb-4">
                <h2 class="mb-3">Tambah Jenis Pelanggaran</h2>

                <a href="kelola_jenis_pelanggaran.php"
                   class="btn btn-secondary">
                    Kembali ke Jenis Pelanggaran
                </a>
            </div>

            <!-- Pesan Error -->
            <?php if (isset($_SESSION['pesan_error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show"
                     role="alert">

                    <?= htmlspecialchars($_SESSION['pesan_error']); ?>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>

                <?php unset($_SESSION['pesan_error']); ?>
            <?php endif; ?>

            <!-- Form Tambah Jenis Pelanggaran -->
            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    Form Tambah Jenis Pelanggaran
                </div>

                <div class="card-body">

                    <form action="proses_tambah_jenis_pelanggaran.php"
                          method="POST">

                        <!-- Kategori Pelanggaran -->
                        <div class="mb-3">
                            <label for="pelanggaran_kategori_id"
                                   class="form-label">
                                Kategori Pelanggaran
                            </label>

                            <select name="pelanggaran_kategori_id"
                                    id="pelanggaran_kategori_id"
                                    class="form-select"
                                    required>

                                <option value="">-- Pilih Kategori --</option>

                                <?php while ($kat = mysqli_fetch_assoc($kategori)): ?>
                                    <option value="<?= (int) $kat['id']; ?>">
                                        <?= htmlspecialchars($kat['nama']); ?>
                                    </option>
                                <?php endwhile; ?>

                            </select>
                        </div>

                        <!-- Kode Pelanggaran -->
                        <div class="mb-3">
                            <label for="kode" class="form-label">
                                Kode Pelanggaran
                            </label>

                            <input type="text"
                                   name="kode"
                                   id="kode"
                                   class="form-control"
                                   maxlength="30"
                                   placeholder="Contoh: PLG001"
                                   required>
                        </div>

                        <!-- Nama Pelanggaran -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                Nama Pelanggaran
                            </label>

                            <input type="text"
                                   name="nama"
                                   id="nama"
                                   class="form-control"
                                   maxlength="150"
                                   placeholder="Masukkan nama pelanggaran"
                                   required>
                        </div>

                        <!-- Poin -->
                        <div class="mb-3">
                            <label for="poin" class="form-label">
                                Poin
                            </label>

                            <input type="number"
                                   name="poin"
                                   id="poin"
                                   class="form-control"
                                   min="0"
                                   placeholder="Masukkan jumlah poin"
                                   required>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">
                                Deskripsi
                            </label>

                            <textarea name="deskripsi"
                                      id="deskripsi"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Masukkan deskripsi pelanggaran"></textarea>
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
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Simpan Jenis Pelanggaran
                            </button>

                            <a href="kelola_jenis_pelanggaran.php"
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
