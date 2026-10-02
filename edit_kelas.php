<?php
// edit_kelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = $_GET['id'];

$sql = "SELECT * FROM t_kelas WHERE id = '$id'";
$hasil = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($hasil);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Kelas</title>
</head>

<body>

    <h1>Edit Kelas</h1>

    <form action="proses_edit_kelas.php" method="POST">

        <input type="hidden" name="id"
               value="<?php echo $data['id']; ?>">

        <table>

            <tr>
                <td>Nama Kelas</td>
                <td>:</td>
                <td>
                    <input type="text" name="nama"
                           value="<?php echo $data['nama']; ?>"
                           required>
                </td>
            </tr>

            <tr>
                <td>Tingkat</td>
                <td>:</td>
                <td>
                    <input type="text" name="tingkat"
                           value="<?php echo $data['tingkat']; ?>"
                           required>
                </td>
            </tr>

            <tr>
                <td>Jurusan</td>
                <td>:</td>
                <td>
                    <input type="text" name="jurusan"
                           value="<?php echo $data['jurusan']; ?>"
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
        <a href="kelola_kelas.php">Kembali ke Kelola Kelas</a>
    </p>

</body>
</html>