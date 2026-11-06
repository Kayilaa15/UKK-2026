
<?php
// proses_tambah_tahun_ajaran.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Pastikan menggunakan POST
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
    $_SESSION['pesan_error'] = "Data tidak valid. Periksa kembali form.";
    header("Location: tambah_tahun_ajaran.php");
    exit;
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
    $_SESSION['pesan_error'] = "Format tanggal tidak valid.";
    header("Location: tambah_tahun_ajaran.php");
    exit;
}

if ($tanggal_mulai > $tanggal_selesai) {
    $_SESSION['pesan_error'] =
        "Tanggal mulai tidak boleh melebihi tanggal selesai.";
    header("Location: tambah_tahun_ajaran.php");
    exit;
}

// Mulai transaksi database
mysqli_begin_transaction($koneksi);

try {

    // Jika ingin menambahkan tahun ajaran aktif,
    // periksa apakah sudah ada tahun ajaran aktif.
    if ($status_aktif === '1') {

        $cek = mysqli_query(
            $koneksi,
            "SELECT id FROM t_tahun_ajaran
             WHERE status_aktif = 1
             LIMIT 1
             FOR UPDATE"
        );

        if (!$cek) {
            throw new Exception(mysqli_error($koneksi));
        }

        if (mysqli_num_rows($cek) > 0) {
            throw new Exception(
                "Gagal menambahkan! Sudah ada tahun ajaran yang aktif. 
                Nonaktifkan tahun ajaran sebelumnya terlebih dahulu."
            );
        }
    }

    // Simpan data tahun ajaran
    $sql = "INSERT INTO t_tahun_ajaran
            (nama, tanggal_mulai, tanggal_selesai, status_aktif)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($koneksi, $sql);

    if (!$stmt) {
        throw new Exception(mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sssi",
        $nama,
        $tanggal_mulai,
        $tanggal_selesai,
        $status_aktif
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);

    mysqli_commit($koneksi);

    $_SESSION['pesan_sukses'] =
        "Tahun ajaran berhasil ditambahkan!";

    header("Location: kelola_tahun_ajaran.php");
    exit;

} catch (Exception $e) {

    mysqli_rollback($koneksi);

    $_SESSION['pesan_error'] = $e->getMessage();

    header("Location: tambah_tahun_ajaran.php");
    exit;
}
?>
