<?php
include '../koneksi.php';

$username=$con->real_escape_string(stripslashes(strip_tags(htmlspecialchars($_POST['username'],ENT_QUOTES))));
$password=$con->real_escape_string(stripslashes(strip_tags(htmlspecialchars($_POST['password'],ENT_QUOTES))));

$login = $con->query("SELECT * FROM admin WHERE username='$username'") or die ($con->error);
$data = $login->fetch_assoc();
$user_name = $data['username'];
$user_pass = $data['password'];

if (password_verify($password, $user_pass)) {
	session_start();
	$_SESSION['admin'] = 1;
	$_SESSION['id_admin'] = $data['id_admin'];
	$_SESSION['nm_admin'] = $data['nama_lengkap'];
	$_SESSION['level'] = $data['level'];
	header('location:beranda.php');
} else {
	header('location:index.php?failed=1');
}