
<?php
// edit_catat_pelanggaran.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// ==========================================
// AMBIL ID CATATAN
// ==========================================
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['pesan_error'] = 'ID catatan pelanggaran tidak valid.';
    header('Location: catat_pelanggaran.php');
    exit;
}

// ==========================================
// AMBIL DATA CATATAN PELANGGARAN
// ==========================================
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM t_pelanggaran_siswa
     WHERE id = ?
     LIMIT 1"
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

// ==========================================
// CEK STATUS
// ==========================================
if (strcasecmp(trim($data['status'] ?? ''), 'Selesai') === 0) {
    $_SESSION['pesan_error'] = 'Catatan berstatus Selesai tidak dapat diedit.';
    header('Location: catat_pelanggaran.php');
    exit;
}

// ==========================================
// TAHUN AJARAN TETAP MENGIKUTI CATATAN LAMA
// ==========================================
$tahun_ajaran_id = (int) $data['tahun_ajaran_id'];

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT nama
     FROM t_tahun_ajaran
     WHERE id = ?
     LIMIT 1"
);

mysqli_stmt_bind_param($stmt, "i", $tahun_ajaran_id);
mysqli_stmt_execute($stmt);

$tahun_data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

mysqli_stmt_close($stmt);

// ==========================================
// PROSES UPDATE
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Cek ulang status dari database
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT status, guru_id
         FROM t_pelanggaran_siswa
         WHERE id = ?
         LIMIT 1"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $status_db = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    mysqli_stmt_close($stmt);

    if (
        !$status_db ||
        strcasecmp(trim($status_db['status']), 'Selesai') === 0
    ) {
        $_SESSION['pesan_error'] = 'Catatan berstatus Selesai tidak dapat diedit.';
        header('Location: catat_pelanggaran.php');
        exit;
    }

    // Ambil input form
    $siswa_id = filter_input(INPUT_POST, 'siswa_id', FILTER_VALIDATE_INT);

    $pelanggaran_id = filter_input(
        INPUT_POST,
        'pelanggaran_id',
        FILTER_VALIDATE_INT
    );

    $tanggal = trim($_POST['tanggal'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    // ======================================
    // VALIDASI INPUT
    // ======================================
    $status_diizinkan = [
        'Ditindaklanjuti',
        'Proses',
        'Selesai'
    ];

    $format_tanggal = DateTime::createFromFormat('!Y-m-d', $tanggal);

    if (
        !$siswa_id ||
        !$pelanggaran_id ||
        !in_array($status, $status_diizinkan, true) ||
        !$format_tanggal ||
        $format_tanggal->format('Y-m-d') !== $tanggal
    ) {
        $_SESSION['pesan_error'] = 'Data perubahan tidak valid.';
        header("Location: edit_catat_pelanggaran.php?id=" . $id);
        exit;
    }

    // ======================================
    // CEK SISWA AKTIF
    // ======================================
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT id, nama
         FROM t_siswa
         WHERE id = ?
         AND (status_aktif = 1 OR id = ?)
         LIMIT 1"
    );

    mysqli_stmt_bind_param($stmt, "ii", $siswa_id, $data['siswa_id']);
    mysqli_stmt_execute($stmt);

    $data_siswa = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    mysqli_stmt_close($stmt);

    // ======================================
    // AMBIL KELAS OTOMATIS DARI PENEMPATAN
    // ======================================
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT
            ks.kelas_id,
            k.nama AS nama_kelas,
            k.tingkat,
            k.jurusan
         FROM t_kelas_siswa ks
         INNER JOIN t_kelas k
            ON ks.kelas_id = k.id
         WHERE ks.siswa_id = ?
         AND ks.tahun_ajaran_id = ?
         AND ks.status_aktif = 1
         AND k.status_aktif = 1
         LIMIT 1"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $siswa_id,
        $tahun_ajaran_id
    );

    mysqli_stmt_execute($stmt);

    $data_penempatan = mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    mysqli_stmt_close($stmt);

    // ======================================
    // AMBIL JENIS PELANGGARAN
    // ======================================
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT nama, poin, pelanggaran_kategori_id
         FROM t_pelanggaran
         WHERE id = ?
         AND status_aktif = 1
         LIMIT 1"
    );

    mysqli_stmt_bind_param($stmt, "i", $pelanggaran_id);
    mysqli_stmt_execute($stmt);

    $data_pelanggaran = mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    mysqli_stmt_close($stmt);

    // ======================================
    // VALIDASI DATA
    // ======================================
    if (!$data_siswa) {

        $_SESSION['pesan_error'] = 'Data siswa tidak ditemukan atau tidak aktif.';

    } elseif (!$data_penempatan) {

        $_SESSION['pesan_error'] =
            'Siswa belum memiliki penempatan kelas aktif pada tahun ajaran catatan ini.';

    } elseif (!$data_pelanggaran) {

        $_SESSION['pesan_error'] =
            'Jenis pelanggaran tidak ditemukan atau tidak aktif.';

    } else {

        // ==================================
        // DATA OTOMATIS
        // ==================================
        $nama_siswa = $data_siswa['nama'];

        $kelas_id = (int) $data_penempatan['kelas_id'];

        $nama_kelas =
            $data_penempatan['nama_kelas'] .
            ' - ' .
            $data_penempatan['tingkat'] .
            ' - ' .
            $data_penempatan['jurusan'];

        $nama_pelanggaran = $data_pelanggaran['nama'];

        $kategori_id = (int) $data_pelanggaran['pelanggaran_kategori_id'];

        $poin = (int) $data_pelanggaran['poin'];

        // Guru pelapor dan tahun ajaran TIDAK diubah.
        // Kolom tindakan juga tetap dipertahankan.

        // ==================================
        // UPDATE DATABASE
        // ==================================
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
                keterangan = ?
             WHERE id = ?
             AND status <> 'Selesai'"
        );

        if (!$stmt) {

            $_SESSION['pesan_error'] =
                'Query update gagal: ' . mysqli_error($koneksi);

        } else {

            mysqli_stmt_bind_param(
                $stmt,
                "isisisiisssi",
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
                $id
            );

            if (mysqli_stmt_execute($stmt)) {

                $_SESSION['pesan_sukses'] =
                    'Catatan pelanggaran berhasil diperbarui.';

                mysqli_stmt_close($stmt);

                header('Location: catat_pelanggaran.php');
                exit;

            } else {

                $_SESSION['pesan_error'] =
                    'Gagal memperbarui catatan: ' .
                    mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        }
    }
}

// ==========================================
// DAFTAR SISWA AKTIF
// SISWA LAMA TETAP DITAMPILKAN
// ==========================================
$siswa = mysqli_query(
    $koneksi,
    "SELECT id, nis, nama
     FROM t_siswa
     WHERE status_aktif = 1
     OR id = " . (int) $data['siswa_id'] . "
     ORDER BY nama ASC"
);

// ==========================================
// DAFTAR PENEMPATAN KELAS
// BERDASARKAN TAHUN AJARAN CATATAN
// ==========================================
$daftar_penempatan = [];

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT
        ks.siswa_id,
        ks.kelas_id,
        k.nama AS nama_kelas,
        k.tingkat,
        k.jurusan
     FROM t_kelas_siswa ks
     INNER JOIN t_kelas k
        ON ks.kelas_id = k.id
     WHERE ks.tahun_ajaran_id = ?
     AND ks.status_aktif = 1
     AND k.status_aktif = 1"
);

mysqli_stmt_bind_param($stmt, "i", $tahun_ajaran_id);
mysqli_stmt_execute($stmt);

$result_penempatan = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result_penempatan)) {

    $daftar_penempatan[$row['siswa_id']] = [
        'kelas_id' => $row['kelas_id'],
        'nama_kelas' => $row['nama_kelas'],
        'tingkat' => $row['tingkat'],
        'jurusan' => $row['jurusan']
    ];
}

mysqli_stmt_close($stmt);

// ==========================================
// DAFTAR JENIS PELANGGARAN
// ==========================================
$pelanggaran = mysqli_query(
    $koneksi,
    "SELECT id, nama, poin, pelanggaran_kategori_id
     FROM t_pelanggaran
     WHERE status_aktif = 1
     OR id = " . (int) $data['pelanggaran_id'] . "
     ORDER BY nama ASC"
);

// ==========================================
// KELAS SISWA YANG SEDANG DIPILIH
// ==========================================
$kelas_awal = $daftar_penempatan[$data['siswa_id']] ?? null;

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Catatan Pelanggaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.bootstrap5.min.css"
          rel="stylesheet">

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4">

            <h2 class="mb-4">Edit Catatan Pelanggaran</h2>

            <!-- PESAN ERROR -->
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

                    <form method="POST" id="formEditPelanggaran">

                        <div class="row">

                            <!-- SISWA -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Siswa
                                </label>

                                <select name="siswa_id"
                                        id="siswa"
                                        class="form-select"
                                        required>

                                    <option value="">
                                        -- Pilih Siswa --
                                    </option>

                                    <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>

                                        <option
                                            value="<?= (int) $s['id']; ?>"
                                            <?= (int) $data['siswa_id'] === (int) $s['id'] ? 'selected' : ''; ?>>

                                            <?= htmlspecialchars(
                                                $s['nis'] . ' - ' . $s['nama']
                                            ); ?>

                                        </option>

                                    <?php } ?>

                                </select>

                            </div>

                            <!-- TAHUN AJARAN -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Tahun Ajaran
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="<?= htmlspecialchars($tahun_data['nama'] ?? '-'); ?>"
                                       readonly>

                                <small class="text-muted">
                                    Tahun ajaran tetap mengikuti catatan sebelumnya.
                                </small>

                            </div>

                            <!-- KELAS OTOMATIS -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Kelas
                                </label>

                                <input type="text"
                                       id="nama_kelas"
                                       class="form-control"
                                       value="<?= $kelas_awal
                                           ? htmlspecialchars(
                                               $kelas_awal['nama_kelas'] .
                                               ' - ' .
                                               $kelas_awal['tingkat'] .
                                               ' - ' .
                                               $kelas_awal['jurusan']
                                           )
                                           : 'Siswa belum memiliki penempatan kelas aktif'; ?>"
                                       placeholder="Kelas akan terisi otomatis"
                                       readonly>

                                <input type="hidden"
                                       name="kelas_id"
                                       id="kelas_id"
                                       value="<?= (int) ($kelas_awal['kelas_id'] ?? 0); ?>">

                                <small class="text-muted">
                                    Kelas otomatis mengikuti penempatan siswa pada tahun ajaran catatan ini.
                                </small>

                            </div>

                            <!-- JENIS PELANGGARAN -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Jenis Pelanggaran
                                </label>

                                <select name="pelanggaran_id"
                                        id="pelanggaran"
                                        class="form-select"
                                        required>

                                    <option value="">
                                        -- Pilih Jenis Pelanggaran --
                                    </option>

                                    <?php while ($p = mysqli_fetch_assoc($pelanggaran)) { ?>

                                        <option
                                            value="<?= (int) $p['id']; ?>"
                                            data-poin="<?= (int) $p['poin']; ?>"
                                            data-kategori="<?= (int) $p['pelanggaran_kategori_id']; ?>"
                                            <?= (int) $data['pelanggaran_id'] === (int) $p['id'] ? 'selected' : ''; ?>>

                                            <?= htmlspecialchars($p['nama']); ?>

                                        </option>

                                    <?php } ?>

                                </select>

                                <input type="hidden"
                                       name="pelanggaran_kategori_id"
                                       id="kategori"
                                       value="<?= (int) $data['pelanggaran_kategori_id']; ?>">

                                <small class="text-muted">
                                    Ketik nama pelanggaran untuk mencari.
                                </small>

                            </div>

                            <!-- POIN -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Poin Pelanggaran
                                </label>

                                <input type="number"
                                       id="poin"
                                       class="form-control"
                                       value="<?= (int) $data['poin']; ?>"
                                       readonly>

                            </div>

                            <!-- TANGGAL -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Tanggal
                                </label>

                                <input type="date"
                                       name="tanggal"
                                       class="form-control"
                                       value="<?= htmlspecialchars($data['tanggal']); ?>"
                                       required>

                            </div>

                            <!-- STATUS -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Status
                                </label>

                                <select name="status"
                                        class="form-select"
                                        required>

                                    <?php foreach (
                                        ['Ditindaklanjuti', 'Proses', 'Selesai']
                                        as $st
                                    ) { ?>

                                        <option
                                            value="<?= $st; ?>"
                                            <?= $data['status'] === $st ? 'selected' : ''; ?>>

                                            <?= $st; ?>

                                        </option>

                                    <?php } ?>

                                </select>

                            </div>

                            <!-- KETERANGAN -->
                            <div class="col-md-12 mb-3">

                                <label class="form-label">
                                    Keterangan
                                </label>

                                <textarea name="keterangan"
                                          class="form-control"
                                          rows="3"><?= htmlspecialchars($data['keterangan'] ?? ''); ?></textarea>

                            </div>

                        </div>

                        <!-- TOMBOL -->
                        <button type="submit"
                                class="btn btn-primary">

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

<!-- TOM SELECT -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>

<script>

// ==========================================
// DATA PENEMPATAN SISWA DARI PHP
// ==========================================
const dataPenempatan = <?= json_encode(
    $daftar_penempatan,
    JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
); ?>;


// ==========================================
// PENCARIAN SISWA DAN KELAS OTOMATIS
// ==========================================
const pilihanSiswa = new TomSelect("#siswa", {

    create: false,

    placeholder: "Cari nama atau NIS siswa...",

    onChange: function(value) {

        const kelas = dataPenempatan[value];

        const inputNamaKelas =
            document.getElementById('nama_kelas');

        const inputKelasId =
            document.getElementById('kelas_id');

        if (kelas) {

            inputNamaKelas.value =
                kelas.nama_kelas + ' - ' +
                kelas.tingkat + ' - ' +
                kelas.jurusan;

            inputKelasId.value = kelas.kelas_id;

        } else {

            inputNamaKelas.value =
                'Siswa belum memiliki penempatan kelas aktif';

            inputKelasId.value = '';

        }

    }

});


// ==========================================
// PENCARIAN JENIS PELANGGARAN
// DAN POIN OTOMATIS
// ==========================================
const pilihanPelanggaran = new TomSelect("#pelanggaran", {

    create: false,

    placeholder: "Cari jenis pelanggaran...",

    onChange: function(value) {

        const opsi = document.querySelector(
            '#pelanggaran option[value="' + value + '"]'
        );

        document.getElementById('kategori').value =
            opsi ? opsi.dataset.kategori : '';

        document.getElementById('poin').value =
            opsi ? opsi.dataset.poin : '';

    }

});


// ==========================================
// VALIDASI SEBELUM SIMPAN
// ==========================================
document.getElementById('formEditPelanggaran')
.addEventListener('submit', function(e) {

    const kelasId =
        document.getElementById('kelas_id').value;

    if (!kelasId) {

        e.preventDefault();

        alert(
            'Siswa belum memiliki penempatan kelas aktif pada tahun ajaran catatan ini!'
        );

        return false;

    }

});

</script>

</body>
</html>
