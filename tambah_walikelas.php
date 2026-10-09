<?php
// tambah_walikelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$tahun = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM t_tahun_ajaran ORDER BY id DESC"
);

$kelas = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM t_kelas ORDER BY nama ASC"
);

$guru = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM t_guru ORDER BY nama ASC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Wali Kelas</title>
</head>
<body>

<h1>Tambah Wali Kelas</h1>

<form action="proses_tambah_walikelas.php" method="POST">
    <table>
        <tr>
            <td>Tahun Ajaran</td>
            <td>:</td>
            <td>
                <select name="tahun_ajaran_id" required>
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    <?php while ($row = mysqli_fetch_assoc($tahun)) { ?>
                        <option value="<?php echo $row['id']; ?>">
                            <?php echo htmlspecialchars($row['nama']); ?>
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
                    <?php while ($row = mysqli_fetch_assoc($kelas)) { ?>
                        <option value="<?php echo $row['id']; ?>">
                            <?php echo htmlspecialchars($row['nama']); ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Guru</td>
            <td>:</td>
            <td>
                <select name="guru_id" required>
                    <option value="">-- Pilih Guru --</option>
                    <?php while ($row = mysqli_fetch_assoc($guru)) { ?>
                        <option value="<?php echo $row['id']; ?>">
                            <?php echo htmlspecialchars($row['nama']); ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Tanggal Mulai</td>
            <td>:</td>
            <td><input type="date" name="tanggal_mulai" required></td>
        </tr>

        <tr>
            <td>Tanggal Selesai</td>
            <td>:</td>
            <td><input type="date" name="tanggal_selesai" required></td>
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
                <input type="submit" value="Simpan">
            </td>
        </tr>
    </table>
</form>

<p><a href="kelola_walikelas.php">Kembali</a></p>

</body>
</html>