<?php
// edit_siswa.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil ID siswa
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['pesan_error'] = "ID siswa tidak valid.";
    header("Location: kelola_siswa.php");
    exit;
}

// Ambil data siswa
$stmt = mysqli_prepare($koneksi, "SELECT * FROM t_siswa WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    $_SESSION['pesan_error'] = "Data siswa tidak ditemukan.";
    header("Location: kelola_siswa.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Siswa</title>

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
                <h2 class="mb-3">Edit Siswa</h2>

                <a href="kelola_siswa.php" class="btn btn-secondary">
                    Kembali ke Kelola Siswa
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

            <!-- Form Edit Siswa -->
            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    Form Edit Siswa
                </div>

                <div class="card-body">

                    <form action="proses_edit_siswa.php" method="POST">

                        <input type="hidden"
                               name="id"
                               value="<?= (int) $data['id']; ?>">

                        <!-- NIS -->
                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS</label>

                            <input type="text"
                                   class="form-control"
                                   id="nis"
                                   name="nis"
                                   value="<?= htmlspecialchars($data['nis'] ?? ''); ?>"
                                   required>
                        </div>

                        <!-- NISN -->
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>

                            <input type="text"
                                   class="form-control"
                                   id="nisn"
                                   name="nisn"
                                   value="<?= htmlspecialchars($data['nisn'] ?? ''); ?>"
                                   required>
                        </div>

                        <!-- Nama Siswa -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                Nama Siswa
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="nama"
                                   name="nama"
                                   value="<?= htmlspecialchars($data['nama'] ?? ''); ?>"
                                   required>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">
                                Jenis Kelamin
                            </label>

                            <select class="form-select"
                                    id="jenis_kelamin"
                                    name="jenis_kelamin"
                                    required>

                                <option value="L"
                                    <?= ($data['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>
                                    Laki-laki
                                </option>

                                <option value="P"
                                    <?= ($data['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>
                                    Perempuan
                                </option>

                            </select>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">
                                Tanggal Lahir
                            </label>

                            <input type="date"
                                   class="form-control"
                                   id="tanggal_lahir"
                                   name="tanggal_lahir"
                                   value="<?= htmlspecialchars($data['tanggal_lahir'] ?? ''); ?>"
                                   required>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label">
                                Alamat
                            </label>

                            <textarea class="form-control"
                                      id="alamat"
                                      name="alamat"
                                      rows="4"
                                      required><?= htmlspecialchars($data['alamat'] ?? ''); ?></textarea>
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
                                Update Siswa
                            </button>

                            <a href="kelola_siswa.php"
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
