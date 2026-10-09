
<?php
// kelola_tahun_ajaran.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

$sql = "SELECT * FROM t_tahun_ajaran ORDER BY tanggal_mulai DESC";
$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Tahun Ajaran</title>
</head>
<body>

    <h1>Kelola Tahun Ajaran</h1>

    <p>
        <a href="dashboard.php">Kembali ke Dashboard</a> |
        <a href="tambah_tahun_ajaran.php">Tambah Tahun Ajaran</a>
    </p>

    <table border="1" cellpadding="6" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nama Tahun Ajaran</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Status Aktif</th>
            <th>Dibuat</th>
            <th>Diubah</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>
        <tr>
            <td>
                <?php echo htmlspecialchars($row['id']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['nama']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['tanggal_mulai']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['tanggal_selesai']); ?>
            </td>

            <td>
                <?php
                if ($row['status_aktif'] == 1) {
                    echo "Aktif";
                } else {
                    echo "Tidak Aktif";
                }
                ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['created_at']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['updated_at']); ?>
            </td>

            <td>
                <a href="edit_tahun_ajaran.php?id=<?php
                    echo urlencode($row['id']);
                ?>">Edit</a>

                |

                <a href="hapus_tahun_ajaran.php?id=<?php
                    echo urlencode($row['id']);
                ?>"
                   onclick="return confirm(
                       'Yakin ingin menghapus tahun ajaran ini?'
                   );">
                    Hapus
                </a>
            </td>
        </tr>
        <?php } ?>

    </table>

</body>
</html>
