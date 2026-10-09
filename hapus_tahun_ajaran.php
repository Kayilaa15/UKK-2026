
<?php
// hapus_tahun_ajaran.php

session_start();

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'] ?? '';

if (!ctype_digit((string) $id) || $id === '') {
    header('Location: kelola_tahun_ajaran.php');
    exit;
}

// Ambil nama tahun ajaran sebelum dihapus
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT nama FROM t_tahun_ajaran WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);
mysqli_stmt_close($stmt);

// Periksa apakah data ditemukan
if (!$data) {
    echo "<script>
        alert('Data tahun ajaran tidak ditemukan!');
        window.location.href = 'kelola_tahun_ajaran.php';
    </script>";
    exit;
}

// Hapus data tahun ajaran
$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM t_tahun_ajaran WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    // Ambil ID pengguna yang sedang login
    $id_user = $_SESSION['id_user'] ?? null;
    $waktu = date('Y-m-d H:i:s');

    $aktivitas = "hapus tahun ajaran: " . $data['nama'];

    // Simpan aktivitas ke tabel log
    if ($id_user !== null) {
        $log = mysqli_prepare(
            $koneksi,
            "INSERT INTO tbl_log (id_user, aktivitas, waktu)
             VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $log,
            "iss",
            $id_user,
            $aktivitas,
            $waktu
        );

        mysqli_stmt_execute($log);
        mysqli_stmt_close($log);
    }

    mysqli_stmt_close($stmt);

    echo "<script>
        alert('Tahun ajaran berhasil dihapus!');
        window.location.href = 'kelola_tahun_ajaran.php';
    </script>";
    exit;

} else {

    $pesan = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);

    echo "<script>
        alert('Gagal menghapus tahun ajaran!');
        window.location.href = 'kelola_tahun_ajaran.php';
    </script>";
    exit;
}
?>

