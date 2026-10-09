
<?php
// penempatan_siswa.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil daftar siswa
$siswa = mysqli_query(
    $koneksi,
    "SELECT id, nis, nama
     FROM t_siswa
     WHERE status_aktif = 1
     ORDER BY nama ASC"
);

// Ambil daftar tahun ajaran
$tahun = mysqli_query(
    $koneksi,
    "SELECT id, nama
     FROM t_tahun_ajaran
     WHERE status_aktif = 1
     ORDER BY id DESC"
);

// Ambil daftar kelas
$kelas = mysqli_query(
    $koneksi,
    "SELECT id, nama, tingkat, jurusan
     FROM t_kelas
     WHERE status_aktif = 1
     ORDER BY nama ASC"
);

// Ambil data penempatan siswa
$sql = "SELECT
            ks.id,
            s.nis,
            s.nama AS nama_siswa,
            ta.nama AS tahun_ajaran,
            k.nama AS nama_kelas,
            k.tingkat,
            k.jurusan,
            ks.tanggal_mulai,
            ks.tanggal_selesai,
            ks.status_aktif
        FROM t_kelas_siswa ks
        LEFT JOIN t_siswa s ON ks.siswa_id = s.id
        LEFT JOIN t_tahun_ajaran ta ON ks.tahun_ajaran_id = ta.id
        LEFT JOIN t_kelas k ON ks.kelas_id = k.id
        ORDER BY ks.id DESC";

$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Penempatan Siswa</title>
</head>
<body>

    <h1>Penempatan Siswa</h1>

    <p>
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </p>

    <?php if (isset($_SESSION['pesan_sukses'])) { ?>
        <p>
            <?php
            echo htmlspecialchars($_SESSION['pesan_sukses']);
            unset($_SESSION['pesan_sukses']);
            ?>
        </p>
    <?php } ?>

    <?php if (isset($_SESSION['pesan_error'])) { ?>
        <p>
            <?php
            echo htmlspecialchars($_SESSION['pesan_error']);
            unset($_SESSION['pesan_error']);
            ?>
        </p>
    <?php } ?>

    <h3>Form Penempatan Siswa</h3>

    <form action="proses_simpan_penempatan.php" method="POST">
        <table cellpadding="6">

            <tr>
                <td>Siswa</td>
                <td>:</td>
                <td>
                    <select name="siswa_id" required>
                        <option value="">-- Pilih Siswa --</option>

                        <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
                            <option value="<?php echo $s['id']; ?>">
                                <?php
                                echo htmlspecialchars(
                                    $s['nis'] . ' - ' . $s['nama']
                                );
                                ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Tahun Ajaran</td>
                <td>:</td>
                <td>
                    <select name="tahun_ajaran_id" required>
                        <option value="">-- Pilih Tahun Ajaran --</option>

                        <?php while ($ta = mysqli_fetch_assoc($tahun)) { ?>
                            <option value="<?php echo $ta['id']; ?>">
                                <?php echo htmlspecialchars($ta['nama']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>
                    <select name="kelas_id" required>
                        <option value="">-- Pilih Kelas --</option>

                        <?php while ($k = mysqli_fetch_assoc($kelas)) { ?>
                            <option value="<?php echo $k['id']; ?>">
                                <?php
                                echo htmlspecialchars(
                                    $k['nama'] . ' - Tingkat ' .
                                    $k['tingkat'] . ' - ' . $k['jurusan']
                                );
                                ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Tanggal Mulai</td>
                <td>:</td>
                <td>
                    <input type="date" name="tanggal_mulai" required>
                </td>
            </tr>

            <tr>
                <td>Tanggal Selesai</td>
                <td>:</td>
                <td>
                    <input type="date" name="tanggal_selesai" required>
                </td>
            </tr>

            <tr>
                <td>Status</td>
                <td>:</td>
                <td>
                    <select name="status_aktif" required>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    <input type="submit" value="Simpan Penempatan">
                </td>
            </tr>

        </table>
    </form>

    <hr>

    <h3>Data Penempatan Siswa</h3>

    <table border="1" cellpadding="6" cellspacing="0">
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Tahun Ajaran</th>
            <th>Kelas</th>
            <th>Tingkat</th>
            <th>Jurusan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Status</th>
        </tr>

        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($hasil)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['nis'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($row['nama_siswa'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($row['tahun_ajaran'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($row['nama_kelas'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($row['tingkat'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($row['jurusan'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($row['tanggal_mulai']); ?></td>
                <td><?php echo htmlspecialchars($row['tanggal_selesai']); ?></td>
                <td>
                    <?php
                    echo $row['status_aktif'] == 1
                        ? 'Aktif'
                        : 'Tidak Aktif';
                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>