<?php
// proses_login.php
session_start();
include 'config/koneksi.php';

// Ambil input
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi input
if ($email === '' || $password === '') {
    $_SESSION['pesan_error'] = 'Email dan password wajib diisi!';
    header('Location: login.php');
    exit;
}

// Cari pengguna berdasarkan email
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM t_users WHERE email = ? LIMIT 1"
);

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($hasil) === 1) {

    $data = mysqli_fetch_assoc($hasil);

    if (password_verify($password, $data['password'])) {

        // Buat session login
        session_regenerate_id(true);

        $_SESSION['login'] = true;

        // ID pengguna
        $_SESSION['id_user'] = (int) $data['id'];

        // Session lama tetap dipertahankan
        $_SESSION['id'] = (int) $data['id'];

        // Nama pengguna
        $_SESSION['name'] = $data['name'];

        // Role pengguna
        $_SESSION['role'] = $data['role'];

        mysqli_stmt_close($stmt);

        header('Location: dashboard.php');
        exit;

    } else {
        $_SESSION['pesan_error'] = 'Password salah!';
        mysqli_stmt_close($stmt);
        header('Location: login.php');
        exit;
    }

} else {
    $_SESSION['pesan_error'] = 'Email tidak ditemukan!';
    mysqli_stmt_close($stmt);
    header('Location: login.php');
    exit;
}
?>
