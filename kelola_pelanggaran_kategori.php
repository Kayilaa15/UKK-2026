<?php

// kelola_pelanggaran_kategori.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

$sql = "SELECT * FROM t_pelanggaran_kategori ORDER BY id DESC";
$hasil = mysqli_query($koneksi, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kategori Pelanggaran</title>
</head>
<body>

    <h1>Kelola Kategori Pelanggaran</h1>

    <p>
        <a href="dashboard.php">Kembali ke Dashboard</a> |
        <a href="tambah_pelanggaran_kategori.php">
            Tambah Kategori Pelanggaran
        </a>
    </p>

    <table border="1" cellpadding="6" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nama Kategori</th>
            <th>Deskripsi</th>
            <th>Status Aktif</th>
            <th>Dibuat</th>
            <th>Diubah</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>
        <tr>
            <td>
                <?php echo $row['id']; ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['nama']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['deskripsi'] ?? ''); ?>
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
                <?php echo $row['created_at']; ?>
            </td>

            <td>
                <?php echo $row['updated_at']; ?>
            </td>

            <td>
                <a href="edit_pelanggaran_kategori.php?id=<?php echo $row['id']; ?>">
                    Edit
                </a>
                |
                <a href="hapus_pelanggaran_kategori.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Yakin ingin menghapus kategori pelanggaran ini?');">
                    Hapus
                </a>
            </td>
        </tr>
        <?php } ?>

    </table>

</body>
</html>