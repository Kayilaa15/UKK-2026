<?php
// edit_walikelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM t_walikelas WHERE id = ?"
);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    exit('Data wali kelas tidak ditemukan.');
}

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
    <title>Edit Wali Kelas</title>
</head>
<body>

<h1>Edit Wali Kelas</h1>

<form action="proses_edit_walikelas.php" method="POST">
    <input type="hidden" name="id"
           value="<?php echo $data['id']; ?>">

    <table>
        <tr>
            <td>Tahun Ajaran</td>
            <td>:</td>
            <td>
                <select name="tahun_ajaran_id" required>
                    <?php while ($row = mysqli_fetch_assoc($tahun)) { ?>
                        <option value="<?php echo $row['id']; ?>"
                            <?php echo $row['id'] == $data['tahun_ajaran_id']
                                ? 'selected' : ''; ?>>
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
                    <?php while ($row = mysqli_fetch_assoc($kelas)) { ?>
                        <option value="<?php echo $row['id']; ?>"
                            <?php echo $row['id'] == $data['kelas_id']
                                ? 'selected' : ''; ?>>
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
                    <?php while ($row = mysqli_fetch_assoc($guru)) { ?>
                        <option value="<?php echo $row['id']; ?>"
                            <?php echo $row['id'] == $data['guru_id']
                                ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($row['nama']); ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Tanggal Mulai</td>
            <td>:</td>
            <td>
                <input type="date" name="tanggal_mulai"
                    value="<?php echo $data['tanggal_mulai']; ?>"
                    required>
            </td>
        </tr>

        <tr>
            <td>Tanggal Selesai</td>
            <td>:</td>
            <td>
                <input type="date" name="tanggal_selesai"
                    value="<?php echo $data['tanggal_selesai']; ?>"
                    required>
            </td>
        </tr>

        <tr>
            <td>Status</td>
            <td>:</td>
            <td>
                <select name="status_aktif" required>
                    <option value="1"
                        <?php echo $data['status_aktif'] == 1
                            ? 'selected' : ''; ?>>
                        Aktif
                    </option>
                    <option value="0"
                        <?php echo $data['status_aktif'] == 0
                            ? 'selected' : ''; ?>>
                        Tidak Aktif
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="3">
                <input type="submit" value="Update">
            </td>
        </tr>
    </table>
</form>

<p><a href="kelola_walikelas.php">Kembali</a></p>

</body>
</html>