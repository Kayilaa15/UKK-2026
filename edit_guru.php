<?php
// edit_guru.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = $_GET['id'];

$sql = "SELECT * FROM t_guru WHERE id = '$id'";
$hasil = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($hasil);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Guru</title>
</head>

<body>

    <h1>Edit Guru</h1>

    <form action="proses_edit_guru.php" method="POST">

        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

        <table>

            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>
                    <input type="text" name="nip"
                        value="<?php echo $data['nip']; ?>" required>
                </td>
            </tr>

            <tr>
                <td>Nama Guru</td>
                <td>:</td>
                <td>
                    <input type="text" name="nama"
                        value="<?php echo $data['nama']; ?>" required>
                </td>
            </tr>

            <tr>
                <td>Email</td>
                <td>:</td>
                <td>
                    <input type="email" name="email"
                        value="<?php echo $data['email']; ?>" required>
                </td>
            </tr>

            <tr>
                <td>Status Aktif</td>
                <td>:</td>
                <td>
                    <select name="status_aktif" required>

                        <option value="1"
                            <?php if ($data['status_aktif'] == 1) echo 'selected'; ?>>
                            Aktif
                        </option>

                        <option value="0"
                            <?php if ($data['status_aktif'] == 0) echo 'selected'; ?>>
                            Tidak Aktif
                        </option>

                    </select>
                </td>
            </tr>

            <tr>
                <td>User ID</td>
                <td>:</td>
                <td>
                    <input type="number" name="user_id"
                        value="<?php echo $data['user_id']; ?>">
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
        <a href="kelola_guru.php">Kembali ke Kelola Guru</a>
    </p>

</body>
</html>