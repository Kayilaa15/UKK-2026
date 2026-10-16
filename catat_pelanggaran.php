
<?php
// catat_pelanggaran.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// Daftar siswa
$siswa = mysqli_query(
    $koneksi,
    "SELECT id, nis, nama
     FROM t_siswa
     WHERE status_aktif = 1
     ORDER BY nama ASC"
);

// Daftar tahun ajaran
$tahun = mysqli_query(
    $koneksi,
    "SELECT id, nama
     FROM t_tahun_ajaran
     WHERE status_aktif = 1
     ORDER BY id DESC"
);

// Daftar kelas
$kelas = mysqli_query(
    $koneksi,
    "SELECT id, nama, tingkat, jurusan
     FROM t_kelas
     WHERE status_aktif = 1
     ORDER BY nama ASC"
);

// Daftar pelanggaran
$pelanggaran = mysqli_query(
    $koneksi,
    "SELECT id, nama, poin, pelanggaran_kategori_id
     FROM t_pelanggaran
     WHERE status_aktif = 1
     ORDER BY nama ASC"
);

// Daftar guru
$guru = mysqli_query(
    $koneksi,
    "SELECT id, nama
     FROM t_guru
     WHERE status_aktif = 1
     ORDER BY nama ASC"
);

// Data catatan pelanggaran
$sql = "SELECT
            ps.*,
            ta.nama AS tahun_ajaran,
            s.nis,
            k.tingkat,
            k.jurusan
        FROM t_pelanggaran_siswa ps
        LEFT JOIN t_tahun_ajaran ta
            ON ps.tahun_ajaran_id = ta.id
        LEFT JOIN t_siswa s
            ON ps.siswa_id = s.id
        LEFT JOIN t_kelas k
            ON ps.kelas_id = k.id
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
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <?php include 'layout/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4">

            <h2 class="mb-4">Catat Pelanggaran Siswa</h2>

            <?php if (isset($_SESSION['pesan_sukses'])) { ?>
                <div class="alert alert-success">
                    <?php
                    echo htmlspecialchars($_SESSION['pesan_sukses']);
                    unset($_SESSION['pesan_sukses']);
                    ?>
                </div>
            <?php } ?>

            <?php if (isset($_SESSION['pesan_error'])) { ?>
                <div class="alert alert-danger">
                    <?php
                    echo htmlspecialchars($_SESSION['pesan_error']);
                    unset($_SESSION['pesan_error']);
                    ?>
                </div>
            <?php } ?>

            <div class="card mb-4">
                <div class="card-header">
                    Form Catat Pelanggaran
                </div>

                <div class="card-body">
                    <form action="proses_simpan_pelanggaran.php"
                          method="POST">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Siswa</label>
                                <select name="siswa_id"
                                        class="form-select" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
                                        <option value="<?php echo $s['id']; ?>">
                                            <?php echo htmlspecialchars(
                                                $s['nis'] . ' - ' . $s['nama']
                                            ); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Ajaran</label>
                                <select name="tahun_ajaran_id"
                                        class="form-select" required>
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    <?php while ($ta = mysqli_fetch_assoc($tahun)) { ?>
                                        <option value="<?php echo $ta['id']; ?>">
                                            <?php echo htmlspecialchars($ta['nama']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas_id"
                                        class="form-select" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php while ($k = mysqli_fetch_assoc($kelas)) { ?>
                                        <option value="<?php echo $k['id']; ?>">
                                            <?php echo htmlspecialchars(
                                                $k['nama'] . ' - ' .
                                                $k['tingkat'] . ' - ' .
                                                $k['jurusan']
                                            ); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Pelanggaran</label>
                                <select name="pelanggaran_id"
                                        id="pelanggaran"
                                        class="form-select" required>
                                    <option value="">-- Pilih Pelanggaran --</option>
                                    <?php while ($p = mysqli_fetch_assoc($pelanggaran)) { ?>
                                        <option
                                            value="<?php echo $p['id']; ?>"
                                            data-poin="<?php echo $p['poin']; ?>"
                                            data-kategori="<?php echo $p['pelanggaran_kategori_id']; ?>">
                                            <?php echo htmlspecialchars(
                                                $p['nama'] . ' (' .
                                                $p['poin'] . ' poin)'
                                            ); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <input type="hidden"
                                       name="pelanggaran_kategori_id"
                                       id="kategori">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guru Pelapor</label>
                                <select name="guru_id"
                                        class="form-select" required>
                                    <option value="">-- Pilih Guru --</option>
                                    <?php while ($g = mysqli_fetch_assoc($guru)) { ?>
                                        <option value="<?php echo $g['id']; ?>">
                                            <?php echo htmlspecialchars($g['nama']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal"
                                       class="form-control"
                                       value="<?php echo date('Y-m-d'); ?>"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Poin Pelanggaran</label>
                                <input type="number" name="poin"
                                       id="poin" class="form-control"
                                       min="0" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status"
                                        class="form-select" required>
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

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan"
                                          class="form-control"
                                          rows="3"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tindakan</label>
                                <textarea name="tindakan"
                                          class="form-control"
                                          rows="3"></textarea>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Simpan Pelanggaran
                        </button>

                        <a href="dashboard.php"
                           class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>

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
                                    <th>Poin</th>
                                    <th>Tindakan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php $no = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tahun_ajaran']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_pelanggaran']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_guru']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                                    <td><?php echo (int) $row['poin']; ?></td>
                                    <td><?php echo htmlspecialchars($row['tindakan']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
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

</body>
</html>
