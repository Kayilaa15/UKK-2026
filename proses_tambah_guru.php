
<?php
// proses_tambah_guru.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Ambil data dari form
    $nip = trim($_POST['nip'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $konfirmasi_password = $_POST['konfirmasi_password'] ?? '';
    $status_aktif = (int) ($_POST['status_aktif'] ?? 1);

    // Validasi
    if ($nip == '' || $nama == '' || $email == '' || $password == '') {
        throw new Exception("Semua data wajib diisi!");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Format email tidak valid!");
    }

    if (strlen($nip) > 18) {
        throw new Exception("NIP maksimal 18 karakter sesuai struktur database!");
    }

    if ($password !== $konfirmasi_password) {
        throw new Exception("Konfirmasi password tidak sama!");
    }

    if (strlen($password) < 6) {
        throw new Exception("Password minimal 6 karakter!");
    }

    // Mulai transaksi database
    mysqli_begin_transaction($koneksi);

    // Cek NIP sudah digunakan
    $cek_nip = mysqli_prepare(
        $koneksi,
        "SELECT id FROM t_guru WHERE nip = ?"
    );
    mysqli_stmt_bind_param($cek_nip, "s", $nip);
    mysqli_stmt_execute($cek_nip);

    if (mysqli_stmt_get_result($cek_nip)->num_rows > 0) {
        throw new Exception("NIP sudah terdaftar!");
    }

    // Cek email sudah digunakan
    $cek_email = mysqli_prepare(
        $koneksi,
        "SELECT id FROM t_users WHERE email = ?"
    );
    mysqli_stmt_bind_param($cek_email, "s", $email);
    mysqli_stmt_execute($cek_email);

    if (mysqli_stmt_get_result($cek_email)->num_rows > 0) {
        throw new Exception("Email sudah digunakan untuk akun lain!");
    }

    // Enkripsi password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 1. Simpan akun ke tabel users
    $role = 'guru';

    $sql_user = "INSERT INTO t_users
                 (name, email, password, role)
                 VALUES (?, ?, ?, ?)";

    $stmt_user = mysqli_prepare($koneksi, $sql_user);
    mysqli_stmt_bind_param(
        $stmt_user,
        "ssss",
        $nama,
        $email,
        $password_hash,
        $role
    );

    mysqli_stmt_execute($stmt_user);

    // Ambil ID akun yang baru dibuat
    $user_id = mysqli_insert_id($koneksi);

    // 2. Simpan data guru ke tabel t_guru
    $sql_guru = "INSERT INTO t_guru
                 (nip, nama, email, status_aktif, user_id)
                 VALUES (?, ?, ?, ?, ?)";

    $stmt_guru = mysqli_prepare($koneksi, $sql_guru);
    mysqli_stmt_bind_param(
        $stmt_guru,
        "sssii",
        $nip,
        $nama,
        $email,
        $status_aktif,
        $user_id
    );

    mysqli_stmt_execute($stmt_guru);

    // Simpan kedua data
    mysqli_commit($koneksi);

    $_SESSION['pesan_sukses'] = "Data guru dan akun login berhasil ditambahkan!";

    header("Location: kelola_guru.php");
    exit;

} catch (Throwable $e) {

    // Batalkan jika terjadi kesalahan
    mysqli_rollback($koneksi);

    $_SESSION['pesan_error'] = "Gagal menambahkan guru: " . $e->getMessage();

    header("Location: tambah_guru.php");
    exit;
}
?>
