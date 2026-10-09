
<?php
// edit_tahun_ajaran.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = $_GET['id'] ?? '';

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM t_tahun_ajaran WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    die("Data tahun ajaran tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Tahun Ajaran</title>
</head>
<body>

    <h1>Edit Tahun Ajaran</h1>

    <form action="proses_edit_tahun_ajaran.php" method="POST">

        <input type="hidden" name="id"
               value="<?php echo htmlspecialchars($data['id']); ?>">

        <table>

            <tr>
                <td>Nama Tahun Ajaran</td>
                <td>:</td>
                <td>
                    <input type="text" name="nama"
                           value="<?php echo htmlspecialchars($data['nama']); ?>"
                           placeholder="Contoh: 2026/2027"
                           required>
                </td>
            </tr>

            <tr>
                <td>Tanggal Mulai</td>
                <td>:</td>
                <td>
                    <input type="date" name="tanggal_mulai"
                           value="<?php echo htmlspecialchars($data['tanggal_mulai']); ?>"
                           required>
                </td>
            </tr>

            <tr>
                <td>Tanggal Selesai</td>
                <td>:</td>
                <td>
                    <input type="date" name="tanggal_selesai"
                           value="<?php echo htmlspecialchars($data['tanggal_selesai']); ?>"
                           required>
                </td>
            </tr>

            <tr>
                <td>Status Aktif</td>
                <td>:</td>
                <td>
                    <select name="status_aktif" required>

                        <option value="1"
                            <?php
                            if ($data['status_aktif'] == 1) {
                                echo 'selected';
                            }
                            ?>>
                            Aktif
                        </option>

                        <option value="0"
                            <?php
                            if ($data['status_aktif'] == 0) {
                                echo 'selected';
                            }
                            ?>>
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

    <p>
        <a href="kelola_tahun_ajaran.php">
            Kembali ke Kelola Tahun Ajaran
        </a>
    </p>

</body>
</html>

