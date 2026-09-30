<?php
//buat_user_admin.php
//jalankan file ini satu kali saja lewat browser untuk membuat user awal
include 'config/koneksi.php';

$name = 'Administator';
$email= 'admin@gmail.com';
$password = password_hash('admin123', PASSWORD_DEFAULT);
$role = 'admin';

$sql = "INSERT INTO t_users(name,email,password,role)";
$sql .= "VALUES('$name','$email','$password','$role')";

if (mysqli_query($koneksi, $sql)) {
    echo 'User admin berhasil dibuat, silakan hapus file ini';
} else{
    echo 'Gagal memuat user: '. mysqli_error($koneksi);
}
?>