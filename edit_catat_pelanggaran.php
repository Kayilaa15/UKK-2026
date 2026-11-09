
<?php
// edit_catat_pelanggaran.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['pesan_error'] = "ID catatan pelanggaran tidak valid.";
    header("Location: catat_pelanggaran.php");
    exit;
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $siswa_id = (int) $_POST['siswa_id'];
    $tahun_ajaran_id = (int) $_POST['tahun_ajaran_id'];
    $kelas_id = (int) $_POST['kelas_id'];
    $pelanggaran_id = (int) $_POST['pelanggaran_id'];
    $pelanggaran_kategori_id = (int) $_POST['pelanggaran_kategori_id'];
    $guru_id = (int) $_POST['guru_id'];
    $poin = (int) $_POST['poin'];

    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];
    $keterangan = $_POST['keterangan'];
    $tindakan = $_POST['tindakan'];

    $stmt = mysqli_prepare($koneksi, "
        UPDATE t_pelanggaran_siswa SET
            siswa_id = ?,
            tahun_ajaran_id = ?,
            kelas_id = ?,
            pelanggaran_id = ?,
            pelanggaran_kategori_id = ?,
            guru_id = ?,
            poin = ?,
            tanggal = ?,
            status = ?,
            keterangan = ?,
            tindakan = ?
        WHERE id = ?
    ");

    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt,
            "iiiiiiissssi",
            $siswa_id,
            $tahun_ajaran_id,
            $kelas_id,
            $pelanggaran_id,
            $pelanggaran_kategori_id,
            $guru_id,
            $poin,
            $tanggal,
            $status,
            $keterangan,
            $tindakan,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['pesan_sukses'] = "Catatan pelanggaran berhasil diperbarui.";
            mysqli_stmt_close($stmt);
            header("Location: catat_pelanggaran.php");
            exit;
        } else {
            $_SESSION['pesan_error'] = "Gagal memperbarui catatan pelanggaran.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['pesan_error'] = "Query update gagal diproses.";
    }
}

// Ambil data catatan pelanggaran
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM t_pelanggaran_siswa WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$data) {
    $_SESSION['pesan_error'] = "Data catatan pelanggaran tidak ditemukan.";
    header("Location: catat_pelanggaran.php");
    exit;
}

// Daftar pilihan, termasuk data lama jika sudah tidak aktif
$siswa = mysqli_query($koneksi, "
    SELECT id, nis, nama FROM t_siswa
    WHERE status_aktif = 1 OR id = " . (int)$data['siswa_id'] . "
    ORDER BY nama ASC
");

$tahun = mysqli_query($koneksi, "
    SELECT id, nama FROM t_tahun_ajaran
    WHERE status_aktif = 1 OR id = " . (int)$data['tahun_ajaran_id'] . "
    ORDER BY id DESC
");

$kelas = mysqli_query($koneksi, "
    SELECT id, nama, tingkat, jurusan FROM t_kelas
    WHERE status_aktif = 1 OR id = " . (int)$data['kelas_id'] . "
    ORDER BY nama ASC
");

$pelanggaran = mysqli_query($koneksi, "
    SELECT id, nama, poin, pelanggaran_kategori_id
    FROM t_pelanggaran
    WHERE status_aktif = 1 OR id = " . (int)$data['pelanggaran_id'] . "
    ORDER BY nama ASC
");

$guru = mysqli_query($koneksi, "
    SELECT id, nama FROM t_guru
    WHERE status_aktif = 1 OR id = " . (int)$data['guru_id'] . "
    ORDER BY nama ASC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Catatan Pelanggaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4">

            <h2 class="mb-4">Edit Catatan Pelanggaran</h2>

            <?php if (isset($_SESSION['pesan_error'])) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['pesan_error']); ?>
                </div>
                <?php unset($_SESSION['pesan_error']); ?>
            <?php } ?>

            <div class="card shadow-sm">

                <div class="card-header bg-dark text-white">
                    Form Edit Pelanggaran
                </div>

                <div class="card-body">

                    <form method="POST">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Siswa</label>
                                <select name="siswa_id" class="form-select" required>
                                    <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
                                        <option value="<?= $s['id']; ?>"
                                            <?= $data['siswa_id'] == $s['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($s['nis'] . ' - ' . $s['nama']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Ajaran</label>
                                <select name="tahun_ajaran_id" class="form-select" required>
                                    <?php while ($ta = mysqli_fetch_assoc($tahun)) { ?>
                                        <option value="<?= $ta['id']; ?>"
                                            <?= $data['tahun_ajaran_id'] == $ta['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($ta['nama']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas_id" class="form-select" required>
                                    <?php while ($k = mysqli_fetch_assoc($kelas)) { ?>
                                        <option value="<?= $k['id']; ?>"
                                            <?= $data['kelas_id'] == $k['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($k['nama'] . ' - ' . $k['tingkat'] . ' - ' . $k['jurusan']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Pelanggaran</label>

                                <select name="pelanggaran_id"
                                        id="pelanggaran"
                                        class="form-select" required>

                                    <?php while ($p = mysqli_fetch_assoc($pelanggaran)) { ?>
                                        <option
                                            value="<?= $p['id']; ?>"
                                            data-poin="<?= $p['poin']; ?>"
                                            data-kategori="<?= $p['pelanggaran_kategori_id']; ?>"
                                            <?= $data['pelanggaran_id'] == $p['id'] ? 'selected' : ''; ?>>

                                            <?= htmlspecialchars($p['nama'] . ' (' . $p['poin'] . ' poin)'); ?>

                                        </option>
                                    <?php } ?>

                                </select>

                                <input type="hidden"
                                       name="pelanggaran_kategori_id"
                                       id="kategori"
                                       value="<?= (int)$data['pelanggaran_kategori_id']; ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guru Pelapor</label>

                                <select name="guru_id" class="form-select" required>
                                    <?php while ($g = mysqli_fetch_assoc($guru)) { ?>
                                        <option value="<?= $g['id']; ?>"
                                            <?= $data['guru_id'] == $g['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($g['nama']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date"
                                       name="tanggal"
                                       class="form-control"
                                       value="<?= htmlspecialchars($data['tanggal']); ?>"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Poin Pelanggaran</label>
                                <input type="number"
                                       name="poin"
                                       id="poin"
                                       class="form-control"
                                       min="0"
                                       value="<?= (int)$data['poin']; ?>"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>

                                <select name="status" class="form-select" required>
                                    <?php
                                    $status_list = ['Ditindaklanjuti', 'Proses', 'Selesai'];
                                    foreach ($status_list as $st) {
                                    ?>
                                        <option value="<?= $st; ?>"
                                            <?= $data['status'] == $st ? 'selected' : ''; ?>>
                                            <?= $st; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan"
                                          class="form-control"
                                          rows="3"><?= htmlspecialchars($data['keterangan'] ?? ''); ?></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tindakan</label>
                                <textarea name="tindakan"
                                          class="form-control"
                                          rows="3"><?= htmlspecialchars($data['tindakan'] ?? ''); ?></textarea>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>

                        <a href="catat_pelanggaran.php"
                           class="btn btn-secondary">
                            Kembali
                        </a>

                    </form>

                </div>
            </div>

        </main>
    </div>
</div>

<script>
const pilihanPelanggaran = document.getElementById('pelanggaran');
const inputPoin = document.getElementById('poin');
const inputKategori = document.getElementById('kategori');

pilihanPelanggaran.addEventListener('change', function () {
    const opsi = this.options[this.selectedIndex];

    inputPoin.value = opsi.dataset.poin || '';
    inputKategori.value = opsi.dataset.kategori || '';
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
