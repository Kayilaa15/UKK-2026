<?php
// tambah_wali_kelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// 1. Mengambil tahun ajaran yang aktif
$tahun = mysqli_query(
    $koneksi,
    "SELECT id, nama
     FROM t_tahun_ajaran
     WHERE status_aktif = 1
     ORDER BY id DESC"
);

// 2. Mengambil kelas yang belum memiliki wali kelas
$kelas = mysqli_query(
    $koneksi,
    "SELECT id, nama
     FROM t_kelas
     WHERE id NOT IN (
         SELECT kelas_id
         FROM t_wali_kelas
         WHERE status_aktif = 1
     )
     ORDER BY nama ASC"
);

// 3. Mengambil guru yang belum menjadi wali kelas
$guru = mysqli_query(
    $koneksi,
    "SELECT id, nama
     FROM t_guru
     WHERE id NOT IN (
         SELECT guru_id
         FROM t_wali_kelas
         WHERE status_aktif = 1
     )
     ORDER BY nama ASC"
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

        <!-- SIDEBAR -->
        <?php include 'layout/sidebar.php'; ?>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">

            <h1 class="mb-4">Tambah Wali Kelas</h1>

            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    Form Tambah Wali Kelas
                </div>

                <div class="card-body">

                    <form action="proses_tambah_wali_kelas.php"
                          method="POST"
                          id="formTambahWaliKelas">

                        <!-- TAHUN AJARAN -->
                        <div class="mb-3">
                            <label for="tahun_ajaran_id" class="form-label">
                                Tahun Ajaran
                            </label>

                            <select name="tahun_ajaran_id"
                                    id="tahun_ajaran_id"
                                    class="form-select"
                                    required>

                                <option value="">-- Pilih Tahun Ajaran --</option>

                                <?php while ($row = mysqli_fetch_assoc($tahun)) { ?>
                                    <option value="<?= htmlspecialchars((string)$row['id']) ?>">
                                        <?= htmlspecialchars($row['nama']) ?>
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

                                <option value="">-- Pilih Kelas --</option>

                                <?php while ($row = mysqli_fetch_assoc($kelas)) { ?>
                                    <option value="<?= htmlspecialchars((string)$row['id']) ?>">
                                        <?= htmlspecialchars($row['nama']) ?>
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

                                <option value="">-- Pilih Guru --</option>

                                <?php while ($row = mysqli_fetch_assoc($guru)) { ?>
                                    <option value="<?= htmlspecialchars((string)$row['id']) ?>">
                                        <?= htmlspecialchars($row['nama']) ?>
                                    </option>
                                <?php } ?>

                            </select>
                        </div>

                        <!-- TANGGAL MULAI -->
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">
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
                            <label for="tanggal_selesai" class="form-label">
                                Tanggal Selesai
                            </label>

                            <input type="date"
                                   name="tanggal_selesai"
                                   id="tanggal_selesai"
                                   class="form-control"
                                   required>
                        </div>

                        <!-- STATUS -->
                        <div class="mb-4">
                            <label for="status_aktif" class="form-label">
                                Status
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
                            Kembali
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