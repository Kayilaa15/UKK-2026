<?php
// edit_kelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil ID kelas
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['pesan_error'] = "ID kelas tidak valid.";
    header("Location: kelola_kelas.php");
    exit;
}

// Ambil data kelas
$stmt = mysqli_prepare($koneksi, "SELECT * FROM t_kelas WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    $_SESSION['pesan_error'] = "Data kelas tidak ditemukan.";
    header("Location: kelola_kelas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Kelas</title>

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
                <h2 class="mb-3">Edit Kelas</h2>

                <a href="kelola_kelas.php" class="btn btn-secondary">
                    Kembali ke Kelola Kelas
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

            <!-- Form Edit Kelas -->
            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    Form Edit Kelas
                </div>

                <div class="card-body">

                    <form action="proses_edit_kelas.php" method="POST">

                        <input type="hidden"
                               name="id"
                               value="<?= (int) $data['id']; ?>">

                        <!-- Nama Kelas -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                Nama Kelas
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="nama"
                                   name="nama"
                                   value="<?= htmlspecialchars($data['nama'] ?? ''); ?>"
                                   placeholder="Contoh: XI RPL 1"
                                   required>
                        </div>

                        <!-- Tingkat -->
                        <div class="mb-3">
                            <label for="tingkat" class="form-label">
                                Tingkat
                            </label>

                            <select class="form-select"
                                    id="tingkat"
                                    name="tingkat"
                                    required>

                                <option value="">-- Pilih Tingkat --</option>

                                <option value="X"
                                    <?= ($data['tingkat'] == 'X') ? 'selected' : ''; ?>>
                                    X
                                </option>

                                <option value="XI"
                                    <?= ($data['tingkat'] == 'XI') ? 'selected' : ''; ?>>
                                    XI
                                </option>

                                <option value="XII"
                                    <?= ($data['tingkat'] == 'XII') ? 'selected' : ''; ?>>
                                    XII
                                </option>

                            </select>
                        </div>

                        <!-- Jurusan -->
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">
                                Jurusan
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="jurusan"
                                   name="jurusan"
                                   value="<?= htmlspecialchars($data['jurusan'] ?? ''); ?>"
                                   placeholder="Contoh: RPL"
                                   required>
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
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Update Kelas
                            </button>

                            <a href="kelola_kelas.php"
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
