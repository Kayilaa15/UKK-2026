<?php
// tambah_siswa.php
include 'includes/cek_session.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Siswa</title>
</head>

<body>

    <h1>Tambah Siswa</h1>

    <form action="proses_tambah_siswa.php" method="POST">

        <table>

            <tr>
                <td>NIS</td>
                <td>:</td>
                <td>
                    <input type="text" name="nis" required>
                </td>
            </tr>

            <tr>
                <td>NISN</td>
                <td>:</td>
                <td>
                    <input type="text" name="nisn" required>
                </td>
            </tr>

            <tr>
                <td>Nama Siswa</td>
                <td>:</td>
                <td>
                    <input type="text" name="nama" required>
                </td>
            </tr>

            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>
                    <select name="jenis_kelamin" required>
                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td>
                    <input type="date" name="tanggal_lahir" required>
                </td>
            </tr>

            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>
                    <textarea name="alamat" rows="4" cols="30" required></textarea>
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
        <a href="kelola_siswa.php">Kembali</a>
    </p>

</body>
</html>