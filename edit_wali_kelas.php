<?php
// edit_wali_kelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil ID wali kelas
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['pesan_error'] = "ID wali kelas tidak valid.";
    header("Location: kelola_wali_kelas.php");
    exit;
}

// Ambil data wali kelas
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM t_wali_kelas WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    $_SESSION['pesan_error'] = "Data wali kelas tidak ditemukan.";
    header("Location: kelola_wali_kelas.php");
    exit;
}

// Ambil data tahun ajaran
$tahun = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM t_tahun_ajaran ORDER BY id DESC"
);

// Ambil data kelas
$kelas = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM t_kelas ORDER BY nama ASC"
);

// Ambil data guru
$guru = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM t_guru ORDER BY nama ASC"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Wali Kelas</title>

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
                <h2 class="mb-3">Edit Wali Kelas</h2>

                <a href="kelola_wali_kelas.php"
                   class="btn btn-secondary">
                    Kembali ke Kelola Wali Kelas
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

            <!-- Form Edit Wali Kelas -->
            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    Form Edit Wali Kelas
                </div>

                <div class="card-body">

                    <form action="proses_edit_wali_kelas.php"
                          method="POST">

                        <input type="hidden"
                               name="id"
                               value="<?= (int) $data['id']; ?>">

                        <!-- Tahun Ajaran -->
                        <div class="mb-3">
                            <label for="tahun_ajaran_id"
                                   class="form-label">
                                Tahun Ajaran
                            </label>

                            <select name="tahun_ajaran_id"
                                    id="tahun_ajaran_id"
                                    class="form-select"
                                    required>

                                <option value="">
                                    -- Pilih Tahun Ajaran --
                                </option>

                                <?php while ($row = mysqli_fetch_assoc($tahun)): ?>
                                    <option value="<?= (int) $row['id']; ?>"
                                        <?= ($row['id'] == $data['tahun_ajaran_id']) ? 'selected' : ''; ?>>

                                        <?= htmlspecialchars($row['nama']); ?>

                                    </option>
                                <?php endwhile; ?>

                            </select>
                        </div>

                        <!-- Kelas -->
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">
                                Kelas
                            </label>

                            <select name="kelas_id"
                                    id="kelas_id"
                                    class="form-select"
                                    required>

                                <option value="">
                                    -- Pilih Kelas --
                                </option>

                                <?php while ($row = mysqli_fetch_assoc($kelas)): ?>
                                    <option value="<?= (int) $row['id']; ?>"
                                        <?= ($row['id'] == $data['kelas_id']) ? 'selected' : ''; ?>>

                                        <?= htmlspecialchars($row['nama']); ?>

                                    </option>
                                <?php endwhile; ?>

                            </select>
                        </div>

                        <!-- Guru -->
                        <div class="mb-3">
                            <label for="guru_id" class="form-label">
                                Guru
                            </label>

                            <select name="guru_id"
                                    id="guru_id"
                                    class="form-select"
                                    required>

                                <option value="">
                                    -- Pilih Guru --
                                </option>

                                <?php while ($row = mysqli_fetch_assoc($guru)): ?>
                                    <option value="<?= (int) $row['id']; ?>"
                                        <?= ($row['id'] == $data['guru_id']) ? 'selected' : ''; ?>>

                                        <?= htmlspecialchars($row['nama']); ?>

                                    </option>
                                <?php endwhile; ?>

                            </select>
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
                                   value="<?= htmlspecialchars($data['tanggal_mulai'] ?? ''); ?>"
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
                                   value="<?= htmlspecialchars($data['tanggal_selesai'] ?? ''); ?>"
                                   required>
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-3">
                            <label for="status_aktif" class="form-label">
                                Status
                            </label>

                            <select name="status_aktif"
                                    id="status_aktif"
                                    class="form-select"
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
                                Update Wali Kelas
                            </button>

                            <a href="kelola_wali_kelas.php"
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
