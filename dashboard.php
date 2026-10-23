<?php
// Memeriksa session login
include "includes/cek_session.php";

// Mengambil data pengguna
$nama = $_SESSION['nama'] ?? $_SESSION['nama_lengkap'] ?? '';
$email = $_SESSION['email'] ?? '-';
$role = $_SESSION['role'] ?? '-';

// Menghubungkan database
include "config/koneksi.php";

// Menghitung jumlah data dari database
function hitungData($koneksi, $tabel)
{
    $tabelDiizinkan = ['t_siswa', 't_guru', 't_kelas'];

    if (!in_array($tabel, $tabelDiizinkan, true)) {
        return 0;
    }

    $sql = "SELECT COUNT(*) AS total FROM `$tabel`";
    $hasil = mysqli_query($koneksi, $sql);

    if (!$hasil) {
        die(
            "Gagal menghitung data pada tabel " .
            htmlspecialchars($tabel) .
            ". Periksa nama tabel di database. Error: " .
            htmlspecialchars(mysqli_error($koneksi))
        );
    }

    $data = mysqli_fetch_assoc($hasil);

    return (int) $data['total'];
}

// Jumlah data otomatis
$total_siswa = hitungData($koneksi, 't_siswa');
$total_guru = hitungData($koneksi, 't_guru');
$total_kelas = hitungData($koneksi, 't_kelas');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">

    <title>Dashboard</title>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php
        include "layout/sidebar.php";
        ?>

        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">

            <h2>Dashboard</h2>

            <!-- Menampilkan data pengguna -->
            <p>Selamat datang di halaman dashboard <b><?php echo htmlspecialchars($nama); ?></b></p>

            <?php if ($role == 'admin') { ?>

                <div class="row">

                    <!-- CARD DATA SISWA -->
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Data Siswa</h5>

                                <h2><?php echo $total_siswa; ?></h2>

                                <a href="kelola_siswa.php"
                                   class="btn btn-primary">
                                    Lihat Data
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- CARD DATA GURU -->
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Data Guru</h5>

                                <h2><?php echo $total_guru; ?></h2>

                                <a href="kelola_guru.php"
                                   class="btn btn-primary">
                                    Lihat Data
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- CARD KELAS -->
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Kelas</h5>

                                <h2><?php echo $total_kelas; ?></h2>

                                <a href="kelola_kelas.php"
                                   class="btn btn-primary">
                                    Lihat Data
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            <?php } elseif ($role == 'guru') { ?>

                <!-- DASHBOARD GURU -->
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5>Catat Pelanggaran</h5>
                                <p>Mencatat pelanggaran siswa.</p>

                                <a href="catat_pelanggaran.php"
                                   class="btn btn-primary">
                                    Catat Sekarang
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5>Riwayat Pelanggaran</h5>
                                <p>Melihat riwayat pelanggaran siswa.</p>

                                <a href="riwayat.php"
                                   class="btn btn-primary">
                                    Lihat Riwayat
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5>Rekap Poin</h5>
                                <p>Melihat jumlah poin pelanggaran.</p>

                                <a href="rekap_poin.php"
                                   class="btn btn-primary">
                                    Lihat Rekap
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            <?php } else { ?>

                <div class="alert alert-danger">
                    Role pengguna tidak dikenali.
                </div>

            <?php } ?>

        </main>

    </div>
</div>

</body>
</html>