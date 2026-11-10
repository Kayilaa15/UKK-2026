<?php
// tindakan.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// ====================================
// FUNGSI TINDAKAN OTOMATIS
// ====================================

function tentukanTindakan($namaPelanggaran)
{
    $nama = strtolower(trim($namaPelanggaran));

    if (strpos($nama, 'rambut') !== false) {
        return 'Menegur siswa dan meminta siswa merapikan rambut sesuai aturan sekolah.';
    }

    elseif (
        strpos($nama, 'rokok') !== false ||
        strpos($nama, 'vape') !== false
    ) {
        return 'Memberikan pembinaan dan memanggil orang tua siswa.';
    }

    elseif (
        strpos($nama, 'tidak masuk') !== false ||
        strpos($nama, 'absen') !== false
    ) {
        return 'Memberikan teguran dan meminta surat keterangan dari orang tua.';
    }

    elseif (
        strpos($nama, 'sampah') !== false ||
        strpos($nama, 'membuang sampah') !== false
    ) {
        return 'Memberikan teguran dan meminta siswa membersihkan lingkungan sekolah.';
    }

    elseif (
        strpos($nama, 'gaduh') !== false ||
        strpos($nama, 'ribut') !== false
    ) {
        return 'Memberikan teguran dan pembinaan agar siswa tidak mengulangi perbuatannya.';
    }

    elseif (
        strpos($nama, 'terlambat') !== false
    ) {
        return 'Memberikan teguran dan pembinaan kedisiplinan kepada siswa.';
    }

    elseif (
        strpos($nama, 'meninggalkan kelas') !== false
    ) {
        return 'Memberikan teguran dan meminta siswa mengikuti kegiatan belajar dengan tertib.';
    }

    elseif (
        strpos($nama, 'tidak mengerjakan tugas') !== false ||
        strpos($nama, 'tugas') !== false
    ) {
        return 'Meminta siswa menyelesaikan tugas dan memberikan pembinaan.';
    }

    else {
        return 'Memberikan teguran dan pembinaan kepada siswa agar tidak mengulangi pelanggaran.';
    }
}


// ====================================
// SIMPAN TINDAKAN
// ====================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) ($_POST['id'] ?? 0);
    $tindakan = trim($_POST['tindakan'] ?? '');

    if ($id <= 0 || $tindakan === '') {

        $_SESSION['pesan_error'] = 'Data tindakan tidak boleh kosong.';

        header('Location: tindakan.php');
        exit;
    }

    $stmt = mysqli_prepare(
        $koneksi,
        "UPDATE t_pelanggaran_siswa
         SET tindakan = ?, status = 'selesai'
         WHERE id = ?
         AND (tindakan IS NULL OR TRIM(tindakan) = '')"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $tindakan,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $_SESSION['pesan_sukses'] = 'Tindakan berhasil disimpan.';
        } else {
            $_SESSION['pesan_error'] = 'Data tidak ditemukan atau tindakan sudah diisi.';
        }

    } else {

        $_SESSION['pesan_error'] = 'Gagal menyimpan tindakan: ' . mysqli_stmt_error($stmt);

    }

    mysqli_stmt_close($stmt);

    header('Location: tindakan.php');
    exit;
}


// ====================================
// AMBIL DATA PELANGGARAN BELUM DITINDAK
// ====================================

$query = "SELECT
            ps.id,
            ps.nama_siswa,
            ps.nama_kelas,
            ps.nama_pelanggaran,
            ps.tanggal,
            ps.keterangan,
            ps.tindakan,
            ps.poin,
            ps.status
          FROM t_pelanggaran_siswa ps
          WHERE ps.tindakan IS NULL
             OR TRIM(ps.tindakan) = ''
          ORDER BY ps.tanggal DESC, ps.id DESC";

$hasil = mysqli_query($koneksi, $query);

if (!$hasil) {
    die('Gagal mengambil data: ' . mysqli_error($koneksi));
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tindakan Pelanggaran Siswa</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <?php include 'layout/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4">

            <!-- JUDUL -->
            <h2 class="mb-1">Tindakan Pelanggaran Siswa</h2>

            <p class="text-muted">
                Kelola tindakan untuk setiap pelanggaran siswa.
            </p>

            <a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">
                Kembali ke Dashboard
            </a>


            <!-- PESAN SUKSES -->
            <?php if (isset($_SESSION['pesan_sukses'])) { ?>

                <div class="alert alert-success">
                    <?php
                    echo htmlspecialchars($_SESSION['pesan_sukses']);
                    unset($_SESSION['pesan_sukses']);
                    ?>
                </div>

            <?php } ?>


            <!-- PESAN ERROR -->
            <?php if (isset($_SESSION['pesan_error'])) { ?>

                <div class="alert alert-danger">
                    <?php
                    echo htmlspecialchars($_SESSION['pesan_error']);
                    unset($_SESSION['pesan_error']);
                    ?>
                </div>

            <?php } ?>


            <!-- DATA PELANGGARAN -->
            <div class="card">

                <div class="card-header bg-primary text-white">

                    <strong>Data Pelanggaran yang Belum Ditindak</strong>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="tabelTindakan"
                               class="table table-bordered table-striped align-middle">

                            <thead class="table-dark">

                                <tr>
                                    <th>No.</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Pelanggaran</th>
                                    <th>Tanggal</th>
                                    <th>Poin</th>
                                    <th>Keterangan</th>
                                    <th>Tindakan</th>
                                    <th>Aksi</th>
                                </tr>

                            </thead>

                            <tbody>

                            <?php $no = 1; ?>

                            <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>

                                <?php
                                // Tentukan tindakan otomatis
                                $tindakanOtomatis = tentukanTindakan(
                                    $row['nama_pelanggaran']
                                );
                                ?>

                                <tr>

                                    <td>
                                        <?php echo $no++; ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['nama_siswa'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['nama_kelas'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['nama_pelanggaran'] ?? '-'); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['tanggal'] ?? '-'); ?>
                                    </td>

                                    <td class="text-center">

                                        <span class="badge bg-warning text-dark">
                                            <?php echo htmlspecialchars($row['poin'] ?? '0'); ?>
                                        </span>

                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['keterangan'] ?? '-'); ?>
                                    </td>

                                    <!-- TINDAKAN OTOMATIS -->
                                    <td style="min-width: 280px;">

                                        <form method="POST"
                                              action="tindakan.php">

                                            <input type="hidden"
                                                   name="id"
                                                   value="<?php echo $row['id']; ?>">

                                            <textarea
                                                name="tindakan"
                                                class="form-control"
                                                rows="2"
                                                required><?php echo htmlspecialchars($tindakanOtomatis); ?></textarea>

                                    </td>

                                    <td>

                                            <button type="submit"
                                                    class="btn btn-success btn-sm">

                                                Simpan

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            <?php } ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </main>

    </div>

</div>


<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<script>

$(document).ready(function () {

    $('#tabelTindakan').DataTable({

        pageLength: 10,

        language: {

            search: "Cari:",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data",

            zeroRecords: "Data tidak ditemukan",

            paginate: {

                first: "Pertama",

                last: "Terakhir",

                next: "Berikutnya",

                previous: "Sebelumnya"

            }

        }

    });

});

</script>

</body>
</html>