<?php
include '../koneksi.php';

session_start();

$act = $_GET['act'];

switch ($act) {
	case 'tambah':

		if (trim($_POST['kategori'])=="") {
			$message = 'Tidak ada data yang ditambahkan';
		}

		$kategori = $_POST['kategori'];

		if (!isset($message)) {
			$insert_sql = "INSERT INTO kategori VALUES ('','$kategori')";

			$insert_qry = $con->query($insert_sql);

			if ($insert_qry) {
				echo "<script>alert('Data Berhasil Ditambah'); window.location = 'kategori.php'</script>";
			} else {
				echo $con->error;
			}
		} else {

			echo "<script>alert('Data Gagal Ditambah'); window.location = 'kategori.php'</script>";

		}

		break;

	case 'edit':

		$kode = $con->real_escape_string($_GET['id_kategori']);

		$kategori = $con->real_escape_string($_POST['kategori']);

		$edit_sql = "UPDATE kategori SET kategori = '$kategori' WHERE id_kategori = '$kode'";

		$edit_qry = $con->query($edit_sql);

		if ($edit_qry) {
			echo "<script>alert('Data Berhasil Diperbarui'); window.location = 'kategori.php'</script>";
		} else {
			echo "Gagal mengupdate data".$con->error;
		}

		break;

	case 'hapus':

		$jum_sql = "SELECT id_berita FROM berita WHERE id_kategori = '".$con->real_escape_string($_GET['id_kategori'])."'";

		$jum_qry = $con->query($jum_sql);

		$jum_berita = $jum_qry->num_rows;

		if ($jum_berita > 0) {
			if ($_SESSION['level']=='admin') {
				header('location: hapus-kat.php?id_kategori='.$_GET['id_kategori']);
			} else {
				echo "<script>alert('Maaf, dalam kategori ini terdapat berita dari penulis lain!'); window.location = 'kategori.php'</script>";
			}

		} else {
			$del_kat_qry = "DELETE FROM kategori WHERE id_kategori = '".$_GET['id_kategori']."'";

			$del_kat = $con->query($del_kat_qry);

			if ($del_kat) {
				echo "<script>alert('Data Berhasil Dihapus'); window.location = 'kategori.php'</script>";
			} else {
				echo $con->error;
			}
		}

		break;

	default:

		header('location: kategori.php');

		break;
}