<?php 


function query($query) {
global $con;

	$result = mysqli_query($con, $query);
	$rows = [];
	while ($berita = mysqli_fetch_assoc($result) ) {
		$rows[] = $berita;
	}
	return $rows;

}

function edit_kat($data) {
	
	global $con;

	$id_kategori=$data['id_kategori'];
	$kategori=$data['kategori'];

	$query="UPDATE kategori SET kategori = '$kategori' WHERE id_kategori= '$id_kategori'";

	mysqli_query($con, $query);
	return mysqli_affected_rows($con);

}


function edit_user($data) {
	global $con;

	$id=$data['id'];
	$name=$data['name'];
	$username=$data['username'];
	$email=$data['email'];

	$query="UPDATE users SET name = '$name', username = '$username', email = '$email' WHERE id = '$id' ";

	mysqli_query($con, $query);
	return mysqli_affected_rows($con);
}

function delete_user($id){
	global $con;

	$query="DELETE FROM users WHERE id=$id";
	if(mysqli_query($con,$query)) return true;
	else return false;
}

 ?>