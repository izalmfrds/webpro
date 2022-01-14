<?php
include 'header.php';

$data_qry = $con->query("SELECT status FROM berita WHERE id_berita = '$_GET[id_berita]'") or die ($con->error);
$data = $data_qry->fetch_assoc();

if ($data['status']=='tidak') {
	$update_qry = $con->query("UPDATE berita SET status = 'ya' WHERE id_berita = '$_GET[id_berita]'");
} else {
	$update_qry = $con->query("UPDATE berita SET status = 'tidak' WHERE id_berita = '$_GET[id_berita]'");
}

if (!$update_qry) {
	die("Error updating 'berita': ".$con->error);
} else {
	header("location: moderasiberita.php");
}