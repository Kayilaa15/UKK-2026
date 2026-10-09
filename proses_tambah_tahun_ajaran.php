
<?php
// proses_tambah_tahun_ajaran.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Pastikan data dikirim menggunakan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: tambah_tahun_ajaran.php");
    exit;
}

// Ambil data dari form
$nama = trim($_POST['nama'] ?? '');
$tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
$tanggal_selesai = $_POST['tanggal_selesai'] ?? '';
$status_aktif = $_POST['status_aktif'] ?? '';

// Validasi data
if (
    $nama === '' ||
    strlen($nama) > 20 ||
    $tanggal_mulai === '' ||
    $tanggal_selesai === '' ||
    !in_array($status_aktif, ['0', '1'], true)
) {
    die("Data tidak valid. Silakan periksa kembali form.");
}

// Validasi tanggal
$mulai = DateTime::createFromFormat('!Y-m-d', $tanggal_mulai);
$selesai = DateTime::createFromFormat('!Y-m-d', $tanggal_selesai);

if (
    !$mulai ||
    !$selesai ||
    $mulai->format('Y-m-d') !== $tanggal_mulai ||
    $selesai->format('Y-m-d') !== $tanggal_selesai
) {
    die("Format tanggal tidak valid.");
}

if ($tanggal_mulai > $tanggal_selesai) {
    die("Tanggal mulai tidak boleh melebihi tanggal selesai.");
}

// Simpan data ke database
$sql = "INSERT INTO t_tahun_ajaran
        (nama, tanggal_mulai, tanggal_selesai, status_aktif)
        VALUES (?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    die("Gagal menyiapkan query: " .
        htmlspecialchars(mysqli_error($koneksi)));
}

mysqli_stmt_bind_param(
    $stmt,
    "sssi",
    $nama,
    $tanggal_mulai,
    $tanggal_selesai,
    $status_aktif
);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);

    echo "<script>
        alert('Tahun ajaran berhasil ditambahkan!');
        window.location.href = 'kelola_tahun_ajaran.php';
    </script>";
    exit;
} else {
    $pesan = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);

    die("Gagal menambahkan tahun ajaran: " .
        htmlspecialchars($pesan));
}
?>

