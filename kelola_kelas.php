<?php
// kelola_kelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$sql = "SELECT * FROM t_kelas ORDER BY nama ASC";
$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Kelola Kelas</title>
</head>

<body>

    <h1>Kelola Kelas</h1>

    <p>
        <a href="dashboard.php">Kembali ke Dashboard</a> |
        <a href="tambah_kelas.php">Tambah Kelas</a>
    </p>

    <table border="1" cellpadding="6" cellspacing="0">

        <tr>
            <th>ID</th>
            <th>Nama Kelas</th>
            <th>Tingkat</th>
            <th>Jurusan</th>
            <th>Status Aktif</th>
            <th>Dibuat</th>
            <th>Diubah</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>

        <tr>

            <td><?php echo $row['id']; ?></td>

            <td><?php echo $row['nama']; ?></td>

            <td><?php echo $row['tingkat']; ?></td>

            <td><?php echo $row['jurusan']; ?></td>

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
                <a href="edit_kelas.php?id=<?php echo $row['id']; ?>">
                    Edit
                </a>

                |

                <a href="hapus_kelas.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Yakin ingin menghapus data kelas ini?');">
                    Hapus
                </a>
            </td>

        </tr>

        <?php } ?>

    </table>

</body>
</html>