<?php
// kelola_walikelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$sql = "SELECT
            w.*,
            k.nama AS nama_kelas,
            g.nama AS nama_guru
        FROM t_wali_kelas w
        LEFT JOIN t_kelas k ON w.kelas_id = k.id
        LEFT JOIN t_guru g ON w.guru_id = g.id
        ORDER BY w.id DESC";

$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Wali Kelas</title>
</head>
<body>

<h1>Kelola Wali Kelas</h1>

<p>
    <a href="dashboard.php">Kembali ke Dashboard</a> |
    <a href="tambah_walikelas.php">Tambah Wali Kelas</a>
</p>

<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Tahun Ajaran ID</th>
        <th>Kelas</th>
        <th>Guru</th>
        <th>Tanggal Mulai</th>
        <th>Tanggal Selesai</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['tahun_ajaran_id']; ?></td>
        <td><?php echo htmlspecialchars($row['nama_kelas'] ?? '-'); ?></td>
        <td><?php echo htmlspecialchars($row['nama_guru'] ?? '-'); ?></td>
        <td><?php echo $row['tanggal_mulai']; ?></td>
        <td><?php echo $row['tanggal_selesai']; ?></td>
        <td>
            <?php echo $row['status_aktif'] == 1
                ? 'Aktif' : 'Tidak Aktif'; ?>
        </td>
        <td>
            <a href="edit_walikelas.php?id=<?php echo $row['id']; ?>">
                Edit
            </a>
            |
            <a href="hapus_walikelas.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Yakin ingin menghapus data wali kelas ini?');">
                Hapus
            </a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>