<?php
// kelola_guru.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$sql = "SELECT * FROM t_guru ORDER BY nama ASC";
$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Guru</title>
</head>

<body>

    <h1>Kelola Guru</h1>

    <p>
        <a href="dashboard.php">Kembali ke Dashboard</a> |
        <a href="tambah_guru.php">Tambah Guru</a>
    </p>

    <table border="1" cellpadding="6" cellspacing="0">

        <tr>
            <th>ID</th>
            <th>NIP</th>
            <th>Nama Guru</th>
            <th>Email</th>
            <th>Status Aktif</th>
            <th>Dibuat</th>
            <th>Diubah</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>

        <tr>

            <td><?php echo $row['id']; ?></td>

            <td><?php echo $row['nip']; ?></td>

            <td><?php echo $row['nama']; ?></td>

            <td><?php echo $row['email']; ?></td>

            <td>
                <?php
                if ($row['status_aktif'] == 1) {
                    echo "Aktif";
                } else {
                    echo "Tidak Aktif";
                }
                ?>
            </td>

            <td><?php echo $row['created_at']; ?></td>

            <td><?php echo $row['updated_at']; ?></td>

            <td>
                <a href="edit_guru.php?id=<?php echo $row['id']; ?>">
                    Edit
                </a>

                |

                <a href="hapus_guru.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Yakin ingin menghapus data guru ini?');">
                    Hapus
                </a>
            </td>

        </tr>

        <?php } ?>

    </table>

</body>
</html>