<?php
// proses_simpan_penempatan.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Pastikan data dikirim melalui form POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: penempatan_siswa.php");
    exit;
}

// Ambil data dari form
$siswa_id = filter_input(INPUT_POST, 'siswa_id', FILTER_VALIDATE_INT);
$tahun_ajaran_id = filter_input(INPUT_POST, 'tahun_ajaran_id', FILTER_VALIDATE_INT);
$kelas_id = filter_input(INPUT_POST, 'kelas_id', FILTER_VALIDATE_INT);
$tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
$tanggal_selesai = $_POST['tanggal_selesai'] ?? '';
$status_aktif = $_POST['status_aktif'] ?? '';

// Validasi data wajib
if (
    !$siswa_id ||
    !$tahun_ajaran_id ||
    !$kelas_id ||
    empty($tanggal_mulai) ||
    empty($tanggal_selesai) ||
    !in_array((string)$status_aktif, ['0', '1'], true)
) {
    $_SESSION['pesan_error'] = "Semua data penempatan wajib diisi.";
    header("Location: penempatan_siswa.php");
    exit;
}

// Validasi format tanggal
$mulai = DateTime::createFromFormat('!Y-m-d', $tanggal_mulai);
$selesai = DateTime::createFromFormat('!Y-m-d', $tanggal_selesai);

if (
    !$mulai ||
    !$selesai ||
    $mulai->format('Y-m-d') !== $tanggal_mulai ||
    $selesai->format('Y-m-d') !== $tanggal_selesai
) {
    $_SESSION['pesan_error'] = "Format tanggal tidak valid.";
    header("Location: penempatan_siswa.php");
    exit;
}

// Validasi urutan tanggal
if ($tanggal_selesai < $tanggal_mulai) {
    $_SESSION['pesan_error'] =
        "Tanggal selesai tidak boleh sebelum tanggal mulai.";
    header("Location: penempatan_siswa.php");
    exit;
}

// Pastikan siswa tersedia dan aktif
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_siswa
     WHERE id = ? AND status_aktif = 1"
);
mysqli_stmt_bind_param($stmt, "i", $siswa_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

$siswa_valid = mysqli_stmt_num_rows($stmt) > 0;
mysqli_stmt_close($stmt);

if (!$siswa_valid) {
    $_SESSION['pesan_error'] = "Siswa tidak ditemukan atau tidak aktif.";
    header("Location: penempatan_siswa.php");
    exit;
}

// Pastikan tahun ajaran tersedia dan aktif
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_tahun_ajaran
     WHERE id = ? AND status_aktif = 1"
);
mysqli_stmt_bind_param($stmt, "i", $tahun_ajaran_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

$tahun_valid = mysqli_stmt_num_rows($stmt) > 0;
mysqli_stmt_close($stmt);

if (!$tahun_valid) {
    $_SESSION['pesan_error'] = "Tahun ajaran tidak ditemukan atau tidak aktif.";
    header("Location: penempatan_siswa.php");
    exit;
}

// Pastikan kelas tersedia dan aktif
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id FROM t_kelas
     WHERE id = ? AND status_aktif = 1"
);
mysqli_stmt_bind_param($stmt, "i", $kelas_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

$kelas_valid = mysqli_stmt_num_rows($stmt) > 0;
mysqli_stmt_close($stmt);

if (!$kelas_valid) {
    $_SESSION['pesan_error'] = "Kelas tidak ditemukan atau tidak aktif.";
    header("Location: penempatan_siswa.php");
    exit;
}

// Simpan data penempatan siswa
$sql = "INSERT INTO t_kelas_siswa
        (
            siswa_id,
            tahun_ajaran_id,
            kelas_id,
            tanggal_mulai,
            tanggal_selesai,
            status_aktif
        )
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    $_SESSION['pesan_error'] = "Gagal menyiapkan query penyimpanan.";
    header("Location: penempatan_siswa.php");
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "iiissi",
    $siswa_id,
    $tahun_ajaran_id,
    $kelas_id,
    $tanggal_mulai,
    $tanggal_selesai,
    $status_aktif
);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['pesan_sukses'] = "Penempatan siswa berhasil disimpan.";
} else {
    $_SESSION['pesan_error'] =
        "Gagal menyimpan penempatan siswa: " . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);

// Kembali ke halaman penempatan
header("Location: penempatan_siswa.php");
exit;
?>