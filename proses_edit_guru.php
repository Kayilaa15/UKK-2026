
<?php
// proses_edit_guru.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Pastikan request menggunakan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: kelola_guru.php");
    exit;
}

// Ambil data dari form
$id = (int) ($_POST['id'] ?? 0);
$nip = trim($_POST['nip'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$status_aktif = $_POST['status_aktif'] ?? '';

$password = $_POST['password'] ?? '';
$konfirmasi_password = $_POST['konfirmasi_password'] ?? '';

// Validasi data
if (
    $id <= 0 ||
    $nip === '' ||
    !preg_match('/^[0-9]{1,18}$/', $nip) ||
    $nama === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    !in_array($status_aktif, ['0', '1'], true)
) {
    $_SESSION['pesan_error'] = "Data guru tidak valid.";
    header("Location: edit_guru.php?id=" . $id);
    exit;
}

// Validasi password
if ($password !== '' || $konfirmasi_password !== '') {

    if ($password === '' || $konfirmasi_password === '') {
        $_SESSION['pesan_error'] =
            "Password dan konfirmasi password harus diisi.";
        header("Location: edit_guru.php?id=" . $id);
        exit;
    }

    if ($password !== $konfirmasi_password) {
        $_SESSION['pesan_error'] =
            "Password dan konfirmasi password tidak sama.";
        header("Location: edit_guru.php?id=" . $id);
        exit;
    }

    if (strlen($password) < 8) {
        $_SESSION['pesan_error'] =
            "Password minimal harus 8 karakter.";
        header("Location: edit_guru.php?id=" . $id);
        exit;
    }
}

// Mulai transaksi
mysqli_begin_transaction($koneksi);

try {

    // Ambil user_id dari database, bukan dari form
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT user_id FROM t_guru WHERE id = ? FOR UPDATE"
    );

    if (!$stmt) {
        throw new Exception(mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $hasil = mysqli_stmt_get_result($stmt);
    $guru = mysqli_fetch_assoc($hasil);

    mysqli_stmt_close($stmt);

    if (!$guru) {
        throw new Exception("Data guru tidak ditemukan.");
    }

    $user_id = $guru['user_id'];

    // Update data guru
    $sql = "UPDATE t_guru SET
            nip = ?,
            nama = ?,
            email = ?,
            status_aktif = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($koneksi, $sql);

    if (!$stmt) {
        throw new Exception(mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sssii",
        $nip,
        $nama,
        $email,
        $status_aktif,
        $id
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);

    // Jika password diisi, update password akun pengguna
    if ($password !== '') {

        if (empty($user_id)) {
            throw new Exception(
                "Guru ini belum memiliki akun pengguna. Password tidak dapat diperbarui."
            );
        }

        $password_hash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $sql = "UPDATE tbl_user
                SET password = ?
                WHERE id_user = ?";

        $stmt = mysqli_prepare($koneksi, $sql);

        if (!$stmt) {
            throw new Exception(mysqli_error($koneksi));
        }

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $password_hash,
            $user_id
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception(mysqli_stmt_error($stmt));
        }

        // Pastikan akun pengguna ditemukan
        if (mysqli_stmt_affected_rows($stmt) === 0) {
            // Password bisa saja sama dengan hash sebelumnya,
            // jadi periksa keberadaan akun secara terpisah.
            $cek = mysqli_prepare(
                $koneksi,
                "SELECT id_user FROM tbl_user WHERE id_user = ?"
            );

            mysqli_stmt_bind_param($cek, "i", $user_id);
            mysqli_stmt_execute($cek);

            $cek_hasil = mysqli_stmt_get_result($cek);
            $akun = mysqli_fetch_assoc($cek_hasil);

            mysqli_stmt_close($cek);

            if (!$akun) {
                throw new Exception("Akun pengguna tidak ditemukan.");
            }
        }

        mysqli_stmt_close($stmt);
    }

    // Simpan perubahan
    mysqli_commit($koneksi);

    $_SESSION['pesan_sukses'] =
        "Data guru berhasil diperbarui.";

    header("Location: kelola_guru.php");
    exit;

} catch (Exception $e) {

    mysqli_rollback($koneksi);

    $_SESSION['pesan_error'] = $e->getMessage();

    header("Location: edit_guru.php?id=" . $id);
    exit;
}
?>
