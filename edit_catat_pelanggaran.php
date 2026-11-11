<?php
// edit_catat_pelanggaran.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['pesan_error'] = 'ID catatan pelanggaran tidak valid.';
    header('Location: catat_pelanggaran.php');
    exit;
}

// Ambil catatan dan pastikan belum selesai
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM t_pelanggaran_siswa WHERE id = ? LIMIT 1"
);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$data) {
    $_SESSION['pesan_error'] = 'Data catatan pelanggaran tidak ditemukan.';
    header('Location: catat_pelanggaran.php');
    exit;
}

if (strcasecmp(trim($data['status'] ?? ''), 'Selesai') === 0) {
    $_SESSION['pesan_error'] = 'Catatan berstatus Selesai tidak dapat diedit.';
    header('Location: catat_pelanggaran.php');
    exit;
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cek ulang status dari database untuk mencegah edit melalui request langsung
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT status FROM t_pelanggaran_siswa WHERE id = ? LIMIT 1"
    );
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $status_db = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if (!$status_db || strcasecmp(trim($status_db['status']), 'Selesai') === 0) {
        $_SESSION['pesan_error'] = 'Catatan berstatus Selesai tidak dapat diedit.';
        header('Location: catat_pelanggaran.php');
        exit;
    }

    $siswa_id = filter_input(INPUT_POST, 'siswa_id', FILTER_VALIDATE_INT);
    $kelas_id = filter_input(INPUT_POST, 'kelas_id', FILTER_VALIDATE_INT);
    $pelanggaran_id = filter_input(INPUT_POST, 'pelanggaran_id', FILTER_VALIDATE_INT);
    $tanggal = trim($_POST['tanggal'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    $status_diizinkan = ['Ditindaklanjuti', 'Proses', 'Selesai'];
    $format_tanggal = DateTime::createFromFormat('!Y-m-d', $tanggal);

    if (
        !$siswa_id || !$kelas_id || !$pelanggaran_id ||
        !in_array($status, $status_diizinkan, true) ||
        !$format_tanggal || $format_tanggal->format('Y-m-d') !== $tanggal
    ) {
        $_SESSION['pesan_error'] = 'Data perubahan tidak valid.';
        header("Location: edit_catat_pelanggaran.php?id=" . $id);
        exit;
    }

    // Ambil data pilihan aktif
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT nama FROM t_siswa WHERE id = ? AND status_aktif = 1"
    );
    mysqli_stmt_bind_param($stmt, "i", $siswa_id);
    mysqli_stmt_execute($stmt);
    $data_siswa = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT nama FROM t_kelas WHERE id = ? AND status_aktif = 1"
    );
    mysqli_stmt_bind_param($stmt, "i", $kelas_id);
    mysqli_stmt_execute($stmt);
    $data_kelas = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT nama, poin, pelanggaran_kategori_id
         FROM t_pelanggaran
         WHERE id = ? AND status_aktif = 1"
    );
    mysqli_stmt_bind_param($stmt, "i", $pelanggaran_id);
    mysqli_stmt_execute($stmt);
    $data_pelanggaran = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if (!$data_siswa || !$data_kelas || !$data_pelanggaran) {
        $_SESSION['pesan_error'] = 'Siswa, kelas, atau jenis pelanggaran tidak ditemukan atau tidak aktif.';
        header("Location: edit_catat_pelanggaran.php?id=" . $id);
        exit;
    }

    $nama_siswa = $data_siswa['nama'];
    $nama_kelas = $data_kelas['nama'];
    $nama_pelanggaran = $data_pelanggaran['nama'];
    $kategori_id = (int) $data_pelanggaran['pelanggaran_kategori_id'];
    $poin = (int) $data_pelanggaran['poin'];

    // Guru pelapor tetap mengikuti catatan awal; tidak dapat diganti dari form.
    $guru_id = (int) $data['guru_id'];
    $nama_guru = $data['nama_guru'] ?? '';

    // Tindakan tidak digunakan lagi pada form.
    $tindakan = '';

    $stmt = mysqli_prepare(
        $koneksi,
        "UPDATE t_pelanggaran_siswa SET
            siswa_id = ?,
            nama_siswa = ?,
            kelas_id = ?,
            nama_kelas = ?,
            pelanggaran_id = ?,
            nama_pelanggaran = ?,
            pelanggaran_kategori_id = ?,
            poin = ?,
            tanggal = ?,
            status = ?,
            keterangan = ?,
            tindakan = ?
         WHERE id = ?
         AND status <> 'Selesai'"
    );

    if (!$stmt) {
        $_SESSION['pesan_error'] = 'Query update gagal diproses: ' . mysqli_error($koneksi);
        header("Location: edit_catat_pelanggaran.php?id=" . $id);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "isisisiissssi",
        $siswa_id,
        $nama_siswa,
        $kelas_id,
        $nama_kelas,
        $pelanggaran_id,
        $nama_pelanggaran,
        $kategori_id,
        $poin,
        $tanggal,
        $status,
        $keterangan,
        $tindakan,
        $id
    );

    if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) >= 0) {
        $_SESSION['pesan_sukses'] = 'Catatan pelanggaran berhasil diperbarui.';
        mysqli_stmt_close($stmt);
        header('Location: catat_pelanggaran.php');
        exit;
    }

    $_SESSION['pesan_error'] = 'Gagal memperbarui catatan pelanggaran: ' . mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
}

// Daftar pilihan, termasuk data lama agar tetap bisa ditampilkan saat edit
$siswa = mysqli_query(
    $koneksi,
    "SELECT id, nis, nama FROM t_siswa
     WHERE status_aktif = 1 OR id = " . (int) $data['siswa_id'] . "
     ORDER BY nama ASC"
);

$kelas = mysqli_query(
    $koneksi,
    "SELECT id, nama, tingkat, jurusan FROM t_kelas
     WHERE status_aktif = 1 OR id = " . (int) $data['kelas_id'] . "
     ORDER BY nama ASC"
);

$pelanggaran = mysqli_query(
    $koneksi,
    "SELECT id, nama, poin, pelanggaran_kategori_id
     FROM t_pelanggaran
     WHERE status_aktif = 1 OR id = " . (int) $data['pelanggaran_id'] . "
     ORDER BY nama ASC"
);

// Ambil nama tahun ajaran yang tersimpan pada catatan
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT nama FROM t_tahun_ajaran WHERE id = ? LIMIT 1"
);
mysqli_stmt_bind_param($stmt, "i", $data['tahun_ajaran_id']);
mysqli_stmt_execute($stmt);
$tahun_data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Catatan Pelanggaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
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
                <div class="card-header bg-dark text-white">Form Edit Pelanggaran</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Siswa</label>
                                <select name="siswa_id" id="siswa" class="form-select" required>
                                    <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
                                        <option value="<?= (int) $s['id']; ?>"
                                            <?= (int) $data['siswa_id'] === (int) $s['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($s['nis'] . ' - ' . $s['nama']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Ajaran</label>
                                <input type="text" class="form-control"
                                       value="<?= htmlspecialchars($tahun_data['nama'] ?? '-'); ?>" readonly>
                                <small class="text-muted">Tahun ajaran catatan ini tidak diubah saat mengedit.</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas_id" id="kelas" class="form-select" required>
                                    <?php while ($k = mysqli_fetch_assoc($kelas)) { ?>
                                        <option value="<?= (int) $k['id']; ?>"
                                            <?= (int) $data['kelas_id'] === (int) $k['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($k['nama'] . ' - ' . $k['tingkat'] . ' - ' . $k['jurusan']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Pelanggaran</label>
                                <select name="pelanggaran_id" id="pelanggaran" class="form-select" required>
                                    <?php while ($p = mysqli_fetch_assoc($pelanggaran)) { ?>
                                        <option value="<?= (int) $p['id']; ?>"
                                            <?= (int) $data['pelanggaran_id'] === (int) $p['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($p['nama']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <small class="text-muted">Ketik nama pelanggaran untuk mencari.</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guru Pelapor</label>
                                <input type="text" class="form-control"
                                       value="<?= htmlspecialchars($data['nama_guru'] ?? '-'); ?>" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control"
                                       value="<?= htmlspecialchars($data['tanggal']); ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <?php foreach (['Ditindaklanjuti', 'Proses', 'Selesai'] as $st) { ?>
                                        <option value="<?= $st; ?>"
                                            <?= $data['status'] === $st ? 'selected' : ''; ?>>
                                            <?= $st; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="3"><?= htmlspecialchars($data['keterangan'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="catat_pelanggaran.php" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
<script>
new TomSelect("#siswa", {
    create: false,
    placeholder: "Cari nama atau NIS siswa..."
});

new TomSelect("#kelas", {
    create: false,
    placeholder: "Cari kelas..."
});

new TomSelect("#pelanggaran", {
    create: false,
    placeholder: "Cari jenis pelanggaran..."
});
</script>
</body>
</html>