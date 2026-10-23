<?php
// tambah_siswa.php
include 'includes/cek_session.php';
?>

<!DOCTYPE html>
<html>

<head>

     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Siswa</title>

     <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">

</head>

<body>

    <div class="container-fluid">
    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">

             <h1>Tambah Siswa</h1>

            <div class="mb-3">
                <a href="kelola_siswa.php" class="btn btn-secondary mb-3">
                    Kembali ke Data Siswa
                </a>
            </div>

     
<!-- FORM TAMBAH SISWA -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Form Tambah Siswa</h5>
    </div>

    <div class="card-body">
        <form action="proses_tambah_siswa.php" method="POST">

            <!-- NIS -->
            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" name="nis"
                    id="nis"
                    class="form-control"
                    maxlength="10"
                    pattern="[0-9]{1,10}"
                    inputmode="numeric"
                    title="NIS harus berupa angka maksimal 10 digit"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                    required>
            </div>

            <!-- NISN -->
            <div class="mb-3">
                <label for="nisn" class="form-label">NISN</label>
                <input type="text" name="nisn"
                    id="nisn"
                    class="form-control"
                    maxlength="10"
                    pattern="[0-9]{1,10}"
                    inputmode="numeric"
                    title="NISN harus berupa angka maksimal 10 digit"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                    required>
            </div>

            <!-- Nama Siswa -->
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Siswa</label>
                <input type="text" name="nama"
                    id="nama"
                    class="form-control"
                    required>
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">
                    Jenis Kelamin
                </label>
                <select name="jenis_kelamin"
                    id="jenis_kelamin"
                    class="form-select"
                    required>
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">
                    Tanggal Lahir
                </label>
                <input type="date" name="tanggal_lahir"
                    id="tanggal_lahir"
                    class="form-control"
                    required>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat"
                    id="alamat"
                    class="form-control"
                    rows="4"
                    required></textarea>
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

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>
            <a href="kelola_guru.php" class="btn btn-secondary">
                    Batal
            </a>

        </form>
    </div>
</div>



        </table>

    </form>
</body>
</html>