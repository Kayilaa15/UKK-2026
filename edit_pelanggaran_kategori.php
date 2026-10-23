<?php
// edit_pelanggaran_kategori.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM t_pelanggaran_kategori WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    $_SESSION['pesan_error'] = "Data kategori pelanggaran tidak ditemukan.";
    header("Location: kelola_pelanggaran_kategori.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori Pelanggaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php include 'layout/sidebar.php'; ?>

            <main class="col-md-9 col-lg-10 p-4">

                <!-- Judul Halaman -->
                <h2 class="mb-3">Edit Kategori Pelanggaran</h2>

                <!-- Tombol Kembali -->
                <div class="mb-4">
                    <a href="kelola_pelanggaran_kategori.php" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

                <!-- Notifikasi Error -->
                <?php if (!empty($_SESSION['pesan_error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_SESSION['pesan_error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Tutup"></button>
                    </div>
                    <?php unset($_SESSION['pesan_error']); ?>
                <?php endif; ?>

                <!-- Card Form -->
                <div class="card shadow-sm">

                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Form Edit Kategori Pelanggaran</h5>
                    </div>

                    <div class="card-body">

                        <form action="proses_edit_pelanggaran_kategori.php" method="POST">

                            <input type="hidden" name="id"
                                value="<?= htmlspecialchars((string) $data['id']); ?>">

                            <!-- Nama Kategori -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Kategori</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="nama"
                                    name="nama"
                                    value="<?= htmlspecialchars($data['nama'] ?? ''); ?>"
                                    required>
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea
                                    class="form-control"
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="4"><?= htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>
                            </div>

                            <!-- Status Aktif -->
                            <div class="mb-4">
                                <label for="status_aktif" class="form-label">Status Aktif</label>
                                <select
                                    class="form-select"
                                    id="status_aktif"
                                    name="status_aktif"
                                    required>

                                    <option value="1"
                                        <?= ($data['status_aktif'] == 1) ? 'selected' : ''; ?>>
                                        Aktif
                                    </option>

                                    <option value="0"
                                        <?= ($data['status_aktif'] == 0) ? 'selected' : ''; ?>>
                                        Tidak Aktif
                                    </option>

                                </select>
                            </div>

                            <!-- Tombol -->
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>

                            <a href="kelola_pelanggaran_kategori.php" class="btn btn-secondary">
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
