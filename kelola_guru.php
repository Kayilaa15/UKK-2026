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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Kelola Guru</title>
</head>

<body>
    <div class="container-fluid">
    <div class="row">
        <?php
            include 'layout/sidebar.php';
        ?>
        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">
            
            <div class="row"></div>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <h1>Kelola Guru</h1>

    <p>
        <a href="dashboard.php">Kembali ke Dashboard</a> |
        <a href="tambah_guru.php">Tambah Guru</a>
    </p>

    <table  class="table">

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
                    <button type="button" class="btn btn-warning">Edit</button>
                </a>

                |

                <a href="hapus_guru.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Yakin ingin menghapus data guru ini?');">
                    <button type="button" class="btn btn-danger">Hapus</button>
                </a>
            </td>

        </tr>

        <?php } ?>
</table>
</body>
</html>