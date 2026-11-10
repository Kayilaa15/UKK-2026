<?php
// proses_simpan_pelanggaran.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: catat_pelanggaran.php');
    exit;
}

// Ambil ID user dari akun yang sedang login
$id_user = (int) ($_SESSION['id'] ?? 0);

// Ambil data dari form
$siswa_id = filter_input(INPUT_POST, 'siswa_id', FILTER_VALIDATE_INT);
$kelas_id = filter_input(INPUT_POST, 'kelas_id', FILTER_VALIDATE_INT);
$pelanggaran_id = filter_input(INPUT_POST, 'pelanggaran_id', FILTER_VALIDATE_INT);
$tanggal = trim($_POST['tanggal'] ?? '');
$keterangan = trim($_POST['keterangan'] ?? '');
$status = trim($_POST['status'] ?? '');

$status_diizinkan = ['Ditindaklanjuti', 'Proses', 'Selesai'];

if (
    $id_user <= 0 ||
    !$siswa_id ||
    !$kelas_id ||
    !$pelanggaran_id ||
    !in_array($status, $status_diizinkan, true)
) {
    $_SESSION['pesan_error'] = 'Data pelanggaran tidak valid atau akun guru belum terhubung.';
    header('Location: catat_pelanggaran.php');
    exit;
}

// Validasi tanggal
$format_tanggal = DateTime::createFromFormat('!Y-m-d', $tanggal);
if (!$format_tanggal || $format_tanggal->format('Y-m-d') !== $tanggal) {
    $_SESSION['pesan_error'] = 'Tanggal pelanggaran tidak valid.';
    header('Location: catat_pelanggaran.php');
    exit;
}

// Ambil tahun ajaran aktif dari database, bukan dari input form
$result_tahun = mysqli_query(
    $koneksi,
    "SELECT id FROM t_tahun_ajaran WHERE status_aktif = 1 LIMIT 1"
);
$tahun_aktif = $result_tahun ? mysqli_fetch_assoc($result_tahun) : null;

// Ambil guru berdasarkan akun yang sedang login
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id, nama FROM t_guru
     WHERE user_id = ? AND status_aktif = 1
     LIMIT 1"
);
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$data_guru = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

// Ambil siswa aktif
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT nama FROM t_siswa WHERE id = ? AND status_aktif = 1"
);
mysqli_stmt_bind_param($stmt, "i", $siswa_id);
mysqli_stmt_execute($stmt);
$data_siswa = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

// Ambil kelas aktif
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT nama FROM t_kelas WHERE id = ? AND status_aktif = 1"
);
mysqli_stmt_bind_param($stmt, "i", $kelas_id);
mysqli_stmt_execute($stmt);
$data_kelas = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

// Ambil nama, poin, dan kategori dari jenis pelanggaran
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT nama, poin, pelanggaran_kategori_id
     FROM t_pelanggaran
     WHERE id = ? AND status_aktif = 1"
);
mysqli_stmt_bind_param($stmt, "i", $pelanggaran_id);
mysqli_stmt_execute($stmt);
$data_pelanggaran = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$tahun_aktif || !$data_guru || !$data_siswa || !$data_kelas || !$data_pelanggaran) {
    $_SESSION['pesan_error'] = 'Data siswa, kelas, jenis pelanggaran, guru, atau tahun ajaran aktif tidak ditemukan.';
    header('Location: catat_pelanggaran.php');
    exit;
}

$tahun_id = (int) $tahun_aktif['id'];
$kategori_id = (int) $data_pelanggaran['pelanggaran_kategori_id'];
$poin = (int) $data_pelanggaran['poin'];

$nama_siswa = $data_siswa['nama'];
$nama_kelas = $data_kelas['nama'];
$nama_pelanggaran = $data_pelanggaran['nama'];
$guru_id = (int) $data_guru['id'];
$nama_guru = $data_guru['nama'];

// Kolom tindakan masih diisi string kosong agar tetap kompatibel
// jika kolom database belum dihapus dan tidak mengizinkan NULL.
$tindakan = '';

$sql = "INSERT INTO t_pelanggaran_siswa (
            tahun_ajaran_id, siswa_id, nama_siswa,
            kelas_id, nama_kelas, pelanggaran_id,
            nama_pelanggaran, pelanggaran_kategori_id,
            guru_id, nama_guru, tanggal, keterangan,
            poin, tindakan, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    $_SESSION['pesan_error'] = 'Gagal menyiapkan query: ' . mysqli_error($koneksi);
    header('Location: catat_pelanggaran.php');
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "iisisisiisssiss",
    $tahun_id,
    $siswa_id,
    $nama_siswa,
    $kelas_id,
    $nama_kelas,
    $pelanggaran_id,
    $nama_pelanggaran,
    $kategori_id,
    $guru_id,
    $nama_guru,
    $tanggal,
    $keterangan,
    $poin,
    $tindakan,
    $status
);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['pesan_sukses'] = 'Data pelanggaran siswa berhasil disimpan.';
} else {
    $_SESSION['pesan_error'] = 'Gagal menyimpan data pelanggaran: ' . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);
header('Location: catat_pelanggaran.php');
exit;
?>
