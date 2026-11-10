
<?php
// catat_pelanggaran.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// ==========================================
// DAFTAR SISWA AKTIF
// ==========================================
$siswa = mysqli_query(
    $koneksi,
    "SELECT id, nis, nama
     FROM t_siswa
     WHERE status_aktif = 1
     ORDER BY nama ASC"
);

// ==========================================
// TAHUN AJARAN AKTIF
// ==========================================
$tahun = mysqli_query(
    $koneksi,
    "SELECT id, nama
     FROM t_tahun_ajaran
     WHERE status_aktif = 1
     LIMIT 1"
);

$tahun_aktif = mysqli_fetch_assoc($tahun);

// ==========================================
// DAFTAR KELAS AKTIF
// ==========================================
$kelas = mysqli_query(
    $koneksi,
    "SELECT id, nama, tingkat, jurusan
     FROM t_kelas
     WHERE status_aktif = 1
     ORDER BY nama ASC"
);

// ==========================================
// DAFTAR JENIS PELANGGARAN
// ==========================================
$pelanggaran = mysqli_query(
    $koneksi,
    "SELECT id, nama, poin, pelanggaran_kategori_id
     FROM t_pelanggaran
     WHERE status_aktif = 1
     ORDER BY nama ASC"
);

// ==========================================
// GURU YANG SEDANG LOGIN
// ==========================================
$id_user = (int) $_SESSION['id'];

$stmt_guru = mysqli_prepare(
    $koneksi,
    "SELECT id, nama
     FROM t_guru
     WHERE user_id = ?
     AND status_aktif = 1
     LIMIT 1"
);

mysqli_stmt_bind_param($stmt_guru, "i", $id_user);
mysqli_stmt_execute($stmt_guru);

$result_guru = mysqli_stmt_get_result($stmt_guru);
$data_guru = mysqli_fetch_assoc($result_guru);

$guru_id_login = $data_guru['id'] ?? 0;

// ==========================================
// DATA CATATAN PELANGGARAN
// ==========================================
$sql = "SELECT
            ps.*,
            ta.nama AS tahun_ajaran,
            s.nama AS nama_siswa,
            k.nama AS nama_kelas,
            p.nama AS nama_pelanggaran,
            g.nama AS nama_guru

        FROM t_pelanggaran_siswa ps

        LEFT JOIN t_tahun_ajaran ta
            ON ps.tahun_ajaran_id = ta.id

        LEFT JOIN t_siswa s
            ON ps.siswa_id = s.id

        LEFT JOIN t_kelas k
            ON ps.kelas_id = k.id

        LEFT JOIN t_pelanggaran p
            ON ps.pelanggaran_id = p.id

        LEFT JOIN t_guru g
            ON ps.guru_id = g.id

        ORDER BY ps.id DESC";

$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Catat Pelanggaran Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Tom Select untuk pencarian dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.bootstrap5.min.css"
          rel="stylesheet">

</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4">

            <h2 class="mb-4">Catat Pelanggaran Siswa</h2>

            <?php if (isset($_SESSION['pesan_sukses'])) { ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['pesan_sukses']); ?>
                </div>
                <?php unset($_SESSION['pesan_sukses']); ?>
            <?php } ?>

            <?php if (isset($_SESSION['pesan_error'])) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['pesan_error']); ?>
                </div>
                <?php unset($_SESSION['pesan_error']); ?>
            <?php } ?>

            <?php if (!$tahun_aktif) { ?>
                <div class="alert alert-warning">
                    Belum ada tahun ajaran yang aktif.
                    Silakan aktifkan tahun ajaran terlebih dahulu.
                </div>
            <?php } ?>

            <?php if (!$data_guru) { ?>
                <div class="alert alert-danger">
                    Akun yang sedang login belum terhubung dengan
                    data guru atau status guru tidak aktif.
                </div>
            <?php } ?>

            <!-- FORM CATAT PELANGGARAN -->
            <div class="card mb-4">

                <div class="card-header">
                    Form Catat Pelanggaran
                </div>

                <div class="card-body">

                    <form action="proses_simpan_pelanggaran.php"
                          method="POST">

                        <div class="row">

                            <!-- SISWA -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">Siswa</label>

                                <select name="siswa_id"
                                        id="siswa"
                                        class="form-select"
                                        required>

                                    <option value="">-- Pilih Siswa --</option>

                                    <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>

                                        <option value="<?= $s['id']; ?>">
                                            <?= htmlspecialchars(
                                                $s['nis'] . ' - ' . $s['nama']
                                            ); ?>
                                        </option>

                                    <?php } ?>

                                </select>

                            </div>

                            <!-- TAHUN AJARAN OTOMATIS -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">Tahun Ajaran</label>

                                <?php if ($tahun_aktif) { ?>

                                    <input type="text"
                                           class="form-control"
                                           value="<?= htmlspecialchars($tahun_aktif['nama']); ?>"
                                           readonly>

                                    <input type="hidden"
                                           name="tahun_ajaran_id"
                                           value="<?= (int) $tahun_aktif['id']; ?>">

                                <?php } else { ?>

                                    <input type="text"
                                           class="form-control"
                                           value="Belum ada tahun ajaran aktif"
                                           readonly>

                                <?php } ?>

                            </div>

                            <!-- KELAS -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">Kelas</label>

                                <select name="kelas_id"
                                        id="kelas"
                                        class="form-select"
                                        required>

                                    <option value="">-- Pilih Kelas --</option>

                                    <?php while ($k = mysqli_fetch_assoc($kelas)) { ?>

                                        <option value="<?= $k['id']; ?>">
                                            <?= htmlspecialchars(
                                                $k['nama'] . ' - ' .
                                                $k['tingkat'] . ' - ' .
                                                $k['jurusan']
                                            ); ?>
                                        </option>

                                    <?php } ?>

                                </select>

                            </div>

                            <!-- JENIS PELANGGARAN SEARCH -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Jenis Pelanggaran
                                </label>

                                <select name="pelanggaran_id"
                                        id="pelanggaran"
                                        class="form-select"
                                        required>

                                    <option value="">-- Cari Jenis Pelanggaran --</option>

                                    <?php while ($p = mysqli_fetch_assoc($pelanggaran)) { ?>

                                        <option
                                            value="<?= $p['id']; ?>"
                                            data-poin="<?= $p['poin']; ?>"
                                            data-kategori="<?= $p['pelanggaran_kategori_id']; ?>">

                                            <?= htmlspecialchars($p['nama']); ?>

                                        </option>

                                    <?php } ?>

                                </select>

                                <input type="hidden"
                                       name="pelanggaran_kategori_id"
                                       id="kategori">

                                <small class="text-muted">
                                    Ketik nama pelanggaran untuk mencari.
                                </small>

                            </div>

                            <!-- GURU OTOMATIS -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">Guru Pelapor</label>

                                <input type="text"
                                       class="form-control"
                                       value="<?= htmlspecialchars($data_guru['nama'] ?? 'Guru tidak ditemukan'); ?>"
                                       readonly>

                                <input type="hidden"
                                       name="guru_id"
                                       value="<?= (int) $guru_id_login; ?>">

                            </div>

                            <!-- TANGGAL -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">Tanggal</label>

                                <input type="date"
                                       name="tanggal"
                                       class="form-control"
                                       value="<?= date('Y-m-d'); ?>"
                                       required>

                            </div>

                            <!-- STATUS -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">Status</label>

                                <select name="status"
                                        class="form-select"
                                        required>

                                    <option value="Ditindaklanjuti">
                                        Ditindaklanjuti
                                    </option>

                                    <option value="Proses">
                                        Proses
                                    </option>

                                    <option value="Selesai">
                                        Selesai
                                    </option>

                                </select>

                            </div>

                            <!-- KETERANGAN -->
                            <div class="col-md-12 mb-3">

                                <label class="form-label">Keterangan</label>

                                <textarea name="keterangan"
                                          class="form-control"
                                          rows="3"></textarea>

                            </div>

                        </div>

                        <button type="submit"
                                class="btn btn-primary"
                                <?= (!$tahun_aktif || !$data_guru) ? 'disabled' : ''; ?>>

                            Simpan Pelanggaran

                        </button>

                        <a href="dashboard.php"
                           class="btn btn-secondary">

                            Kembali

                        </a>

                    </form>

                </div>
            </div>


            <!-- TABEL DATA PELANGGARAN -->
            <div class="card">

                <div class="card-header">
                    Data Catatan Pelanggaran
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead class="table-dark">

                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Pelanggaran</th>
                                    <th>Guru</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php $no = 1; ?>

                                <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>

                                    <tr>

                                        <td><?= $no++; ?></td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_siswa'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_kelas'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['tahun_ajaran'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_pelanggaran'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['nama_guru'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['tanggal'] ?? '-'); ?>
                                        </td>

                                        <td>

                                            <?php if ($row['status'] == 'Selesai') { ?>

                                                <span class="badge bg-success">
                                                    Selesai
                                                </span>

                                            <?php } elseif ($row['status'] == 'Proses') { ?>

                                                <span class="badge bg-warning text-dark">
                                                    Proses
                                                </span>

                                            <?php } else { ?>

                                                <span class="badge bg-primary">
                                                    Ditindaklanjuti
                                                </span>

                                            <?php } ?>

                                        </td>

                                        <td>

                                            <?php if ($row['status'] != 'Selesai') { ?>

                                                <div class="d-flex gap-2">

                                                    <a href="edit_catat_pelanggaran.php?id=<?= (int) $row['id']; ?>"
                                                       class="btn btn-warning btn-sm">

                                                        Edit

                                                    </a>

                                                    <a href="hapus_catat_pelanggaran.php?id=<?= (int) $row['id']; ?>"
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Yakin ingin menghapus catatan pelanggaran ini?');">

                                                        Hapus

                                                    </a>

                                                </div>

                                            <?php } else { ?>

                                                <span class="text-muted">
                                                    Tidak tersedia
                                                </span>

                                            <?php } ?>

                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </main>

    </div>
</div>


<!-- TOM SELECT -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>

<script>

// Pencarian siswa
new TomSelect("#siswa", {
    create: false,
    placeholder: "Cari nama atau NIS siswa..."
});

// Pencarian kelas
new TomSelect("#kelas", {
    create: false,
    placeholder: "Cari kelas..."
});

// Pencarian jenis pelanggaran
const pilihanPelanggaran = new TomSelect("#pelanggaran", {
    create: false,
    placeholder: "Cari jenis pelanggaran...",
    onChange: function(value) {

        const opsi = document.querySelector(
            '#pelanggaran option[value="' + value + '"]'
        );

        document.getElementById('kategori').value =
            opsi ? opsi.dataset.kategori : '';

    }
});

</script>

</body>
</html>
