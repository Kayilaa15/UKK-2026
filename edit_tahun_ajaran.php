<?php
// edit_tahun_ajaran.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil ID tahun ajaran
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['pesan_error'] = "ID tahun ajaran tidak valid.";
    header("Location: kelola_tahun_ajaran.php");
    exit;
}

// Ambil data tahun ajaran
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM t_tahun_ajaran WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    $_SESSION['pesan_error'] = "Data tahun ajaran tidak ditemukan.";
    header("Location: kelola_tahun_ajaran.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Tahun Ajaran</title>

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
                <h2 class="mb-3">Edit Tahun Ajaran</h2>

                <a href="kelola_tahun_ajaran.php"
                   class="btn btn-secondary">
                    Kembali ke Kelola Tahun Ajaran
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

            <!-- Form Edit Tahun Ajaran -->
            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    Form Edit Tahun Ajaran
                </div>

                <div class="card-body">

                    <form action="proses_edit_tahun_ajaran.php"
                          method="POST">

                        <input type="hidden"
                               name="id"
                               value="<?= (int) $data['id']; ?>">

                        <!-- Nama Tahun Ajaran -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                Nama Tahun Ajaran
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="nama"
                                   name="nama"
                                   value="<?= htmlspecialchars($data['nama']); ?>"
                                   placeholder="Contoh: 2026/2027"
                                   required>
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">
                                Tanggal Mulai
                            </label>

                            <input type="date"
                                   class="form-control"
                                   id="tanggal_mulai"
                                   name="tanggal_mulai"
                                   value="<?= htmlspecialchars($data['tanggal_mulai']); ?>"
                                   required>
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">
                                Tanggal Selesai
                            </label>

                            <input type="date"
                                   class="form-control"
                                   id="tanggal_selesai"
                                   name="tanggal_selesai"
                                   value="<?= htmlspecialchars($data['tanggal_selesai']); ?>"
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
                                Update Tahun Ajaran
                            </button>

                            <a href="kelola_tahun_ajaran.php"
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
