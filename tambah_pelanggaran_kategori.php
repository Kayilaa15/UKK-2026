<?php
// tambah_pelanggaran_kategori.php

include 'includes/cek_session.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Kategori Pelanggaran</title>
</head>

<body>

    <h1>Tambah Kategori Pelanggaran</h1>

    <form action="proses_tambah_pelanggaran_kategori.php" method="POST">

        <table>

            <tr>
                <td>Nama Kategori</td>
                <td>:</td>
                <td>
                    <input type="text" name="nama"
                           placeholder="Contoh: Pelanggaran Ringan"
                           maxlength="100"
                           required>
                </td>
            </tr>

            <tr>
                <td>Deskripsi</td>
                <td>:</td>
                <td>
                    <textarea name="deskripsi"
                              rows="4"
                              cols="30"
                              placeholder="Masukkan deskripsi kategori pelanggaran"></textarea>
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
        <a href="kelola_pelanggaran_kategori.php">Kembali</a>
    </p>

</body>
</html>