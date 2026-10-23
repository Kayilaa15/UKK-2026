<?php
// tambah_wali_kelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

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

    <title>Tambah Wali Kelas</title>

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

            <h1 class="mb-4">Tambah Wali Kelas</h1>

            <div class="mb-3">
                <a href="kelola_wali_kelas.php" class="btn btn-secondary">
                    Kembali ke Data Wali Kelas
                </a>
            </div>

            <!-- PESAN ERROR -->
            <?php if (isset($_SESSION['pesan_error'])) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['pesan_error']); ?>
                </div>

                <?php unset($_SESSION['pesan_error']); ?>
            <?php } ?>

            <!-- FORM TAMBAH WALI KELAS -->
            <div class="card shadow-sm mb-4">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Tambah Wali Kelas</h5>
                </div>

                <div class="card-body">

                    <form action="proses_tambah_walikelas.php"
                          method="POST">

                        <!-- TAHUN AJARAN -->
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

                                <?php while ($row = mysqli_fetch_assoc($tahun)) { ?>
                                    <option value="<?= htmlspecialchars($row['id']); ?>">
                                        <?= htmlspecialchars($row['nama']); ?>
                                    </option>
                                <?php } ?>

                            </select>
                        </div>

                        <!-- KELAS -->
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

                                <?php while ($row = mysqli_fetch_assoc($kelas)) { ?>
                                    <option value="<?= htmlspecialchars($row['id']); ?>">
                                        <?= htmlspecialchars($row['nama']); ?>
                                    </option>
                                <?php } ?>

                            </select>
                        </div>

                        <!-- GURU -->
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

                                <?php while ($row = mysqli_fetch_assoc($guru)) { ?>
                                    <option value="<?= htmlspecialchars($row['id']); ?>">
                                        <?= htmlspecialchars($row['nama']); ?>
                                    </option>
                                <?php } ?>

                            </select>
                        </div>

                        <!-- TANGGAL MULAI -->
                        <div class="mb-3">
                            <label for="tanggal_mulai"
                                   class="form-label">
                                Tanggal Mulai
                            </label>

                            <input type="date"
                                   name="tanggal_mulai"
                                   id="tanggal_mulai"
                                   class="form-control"
                                   required>
                        </div>

                        <!-- TANGGAL SELESAI -->
                        <div class="mb-3">
                            <label for="tanggal_selesai"
                                   class="form-label">
                                Tanggal Selesai
                            </label>

                            <input type="date"
                                   name="tanggal_selesai"
                                   id="tanggal_selesai"
                                   class="form-control"
                                   required>
                        </div>

                        <!-- STATUS AKTIF -->
                        <div class="mb-3">
                            <label for="status_aktif"
                                   class="form-label">
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

                        <!-- TOMBOL -->
                        <button type="submit" class="btn btn-primary">
                            Simpan Wali Kelas
                        </button>

                        <a href="kelola_wali_kelas.php"
                           class="btn btn-secondary">
                            Batal
                        </a>

                    </form>

                </div>
            </div>

        </main>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>