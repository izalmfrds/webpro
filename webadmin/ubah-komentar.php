<?php
include '../koneksi.php';

$data_qry = $con->query("SELECT komentar_status FROM buku_tamu WHERE komentar_id = '$_GET[komentar_id]'") or die ($con->error);
$data = $data_qry->fetch_assoc();

if ($data['komentar_status']=='tidak') {
	$update_qry = $con->query("UPDATE buku_tamu SET komentar_status = 'ya' WHERE komentar_id = '$_GET[komentar_id]'");
} else {
	$update_qry = $con->query("UPDATE buku_tamu SET komentar_status = 'tidak' WHERE komentar_id = '$_GET[komentar_id]'");
}

if (!$update_qry) {
	die("Error updating 'buku_tamu': ".$con->error);
} else {
	header("location:buku-tamu.php");
}