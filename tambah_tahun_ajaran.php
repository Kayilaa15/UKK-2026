
<?php
// tambah_tahun_ajaran.php

include 'includes/cek_session.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Tahun Ajaran</title>
</head>
<body>

    <h1>Tambah Tahun Ajaran</h1>

    <form action="proses_tambah_tahun_ajaran.php" method="POST">

        <table>

            <tr>
                <td>Nama Tahun Ajaran</td>
                <td>:</td>
                <td>
                    <input type="text" name="nama"
                           placeholder="Contoh: 2026/2027"
                           maxlength="20" required>
                </td>
            </tr>

            <tr>
                <td>Tanggal Mulai</td>
                <td>:</td>
                <td>
                    <input type="date" name="tanggal_mulai"
                           required>
                </td>
            </tr>

            <tr>
                <td>Tanggal Selesai</td>
                <td>:</td>
                <td>
                    <input type="date" name="tanggal_selesai"
                           required>
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
        <a href="kelola_tahun_ajaran.php">Kembali</a>
    </p>

</body>
</html>

