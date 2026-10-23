<?php
// edit_guru.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil ID guru
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['pesan_error'] = "ID guru tidak valid.";
    header("Location: kelola_guru.php");
    exit;
}

// Ambil data guru
$stmt = mysqli_prepare($koneksi, "SELECT * FROM t_guru WHERE id = ?");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    $_SESSION['pesan_error'] = "Data guru tidak ditemukan.";
    header("Location: kelola_guru.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Guru</title>

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
                <h2 class="mb-3">Edit Guru</h2>

                <a href="kelola_guru.php" class="btn btn-secondary">
                    Kembali ke Kelola Guru
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

            <!-- Form Edit Guru -->
            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    Form Edit Guru
                </div>

                <div class="card-body">

                    <form action="proses_edit_guru.php" method="POST">

                        <input type="hidden"
                               name="id"
                               value="<?= (int) $data['id']; ?>">

                        <!-- NIP -->
                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>

                            <input type="text"
                                   class="form-control"
                                   id="nip"
                                   name="nip"
                                   value="<?= htmlspecialchars($data['nip'] ?? ''); ?>"
                                   required>
                        </div>

                        <!-- Nama Guru -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                Nama Guru
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="nama"
                                   name="nama"
                                   value="<?= htmlspecialchars($data['nama'] ?? ''); ?>"
                                   required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>

                            <input type="email"
                                   class="form-control"
                                   id="email"
                                   name="email"
                                   value="<?= htmlspecialchars($data['email'] ?? ''); ?>"
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

                        <!-- User ID -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">
                                User ID
                            </label>

                            <input type="number"
                                   class="form-control"
                                   id="user_id"
                                   name="user_id"
                                   min="1"
                                   value="<?= htmlspecialchars((string) ($data['user_id'] ?? '')); ?>"
                                   placeholder="Masukkan User ID jika tersedia">

                            <div class="form-text">
                                Kosongkan jika guru tidak dikaitkan dengan akun pengguna.
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Update Guru
                            </button>

                            <a href="kelola_guru.php" class="btn btn-secondary">
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
