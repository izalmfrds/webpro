<?php

include 'header.php';

if(isset($_GET['id'])){
	if(delete_user($_GET['id'])){
		echo "<script>document.location.href = 'kelolauser.php';</script>";
	}else echo "gagal menghapus data";
}

?>