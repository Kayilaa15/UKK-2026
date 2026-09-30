<?php
//buat_user_guru.php
//jalankan file ini satu kali saja lewat browser untuk membuat user awal
include 'config/koneksi.php';

$name = 'Guru';
$email= 'guru@gmail.com';
$password = password_hash('guru123', PASSWORD_DEFAULT);
$role = 'guru';

$sql = "INSERT INTO t_users(name,email,password,role)";
$sql .= "VALUES('$name','$email','$password','$role')";

if (mysqli_query($koneksi, $sql)) {
    echo 'User admin berhasil dibuat, silakan hapus file ini';
} else{
    echo 'Gagal memuat user: '. mysqli_error($koneksi);
}
?>