<?php
// hapus_walikelas.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

// Ambil data sebelum dihapus
$sql = "SELECT
            w.id,
            w.kelas_id,
            k.nama AS nama_kelas
        FROM t_walikelas w
        LEFT JOIN t_kelas k ON w.kelas_id = k.id
        WHERE w.id = ?";

$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    exit('Data wali kelas tidak ditemukan.');
}

// Hapus data
$hapus = mysqli_prepare(
    $koneksi,
    "DELETE FROM t_walikelas WHERE id = ?"
);
mysqli_stmt_bind_param($hapus, "i", $id);

if (mysqli_stmt_execute($hapus)) {
    $id_user = $_SESSION['id_user'] ?? null;
    $waktu = date('Y-m-d H:i:s');
    $nama_kelas = $data['nama_kelas'] ?? 'Tidak diketahui';
    $aktivitas = "hapus wali kelas untuk kelas: " . $nama_kelas;

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
    }

    header('Location: kelola_walikelas.php');
    exit;
} else {
    echo "Gagal menghapus wali kelas: " . mysqli_error($koneksi);
}
?>