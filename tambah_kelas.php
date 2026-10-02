<?php
// tambah_kelas.php
include 'includes/cek_session.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Kelas</title>
</head>

<body>

    <h1>Tambah Kelas</h1>

    <form action="proses_tambah_kelas.php" method="POST">

        <table>

            <tr>
                <td>Nama Kelas</td>
                <td>:</td>
                <td>
                    <input type="text" name="nama" required>
                </td>
            </tr>

            <tr>
                <td>Tingkat</td>
                <td>:</td>
                <td>
                    <input type="text" name="tingkat" required>
                </td>
            </tr>

            <tr>
                <td>Jurusan</td>
                <td>:</td>
                <td>
                    <input type="text" name="jurusan" required>
                </td>
            </tr>

            <tr>
                <td>Status Aktif</td>
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

    <p>
        <a href="kelola_kelas.php">Kembali</a>
    </p>

</body>
</html>