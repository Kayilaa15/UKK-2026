<?php
//proses_login.php
session_start();
include 'config/koneksi.php';

$email = mysqli_real_escape_string($koneksi, $_POST['email']);
$password = $_POST['password'];

$sql = "SELECT * FROM t_users WHERE email = '$email'";
$hasil = mysqli_query($koneksi,$sql);

if (mysqli_num_rows($hasil) == 1) {
    $data = mysqli_fetch_assoc($hasil);

    if (password_verify($password,$data['password'])) {
        //password cocok,buat session
        $_SESSION['login']=true;
        $_SESSION['id']=$data['id'];
        $_SESSION['name']=$data['name'];
        $_SESSION['role']=$data['role'];


        header('Location: dashboard.php');
        exit;
    } else {
        $_SESSION['pesan_error'] = 'password salah!';
        header('Location: login.php');
       exit;
    }
}else {
    $_SESSION['pesan_eror'] = 'Email tidak ditemukan!';
    header('Location: login.php');
    exit;
}
?>