<?php include 'header.php';

$id_kategori = $_GET["id_kategori"];

$sql = "SELECT * FROM kategori WHERE id_kategori= '$id_kategori'";
$result = mysqli_query($con,$sql);

if(isset($_POST['submit'])){

  $id_kategori=$_POST['id_kategori'];
  $kategori=$_POST['kategori'];

  if (edit_kat($_POST) > 0 ) {
    
    echo '<div class="alert alert-success">Data berhasil di update</div>';
    header("location:kategori.php");
    exit;

  }else{

    echo '<div class="alert alert-danger">Data gagal di update</div>';
    mysqli_error($con);

  }

} 

?>
<div class="container-fluid body">
	<div class="row">
		<div class="col-lg-2 sidebar">
		<?php include 'sidebar.php'; ?>
		</div>
		<div class="col-lg-10 main-content">
		<div class="panel panel-default">
		<div class="panel-body">
	<div class="row">
	<div class="col-md-12">
		<h2 class="page-header"><i class="fa fa-folder-o"></i> Kategori</h2>
	</div>
	</div>
<div class="row">
	<div class="col-md-12">
		<div class="col-md-3">
	<form method="POST" action="">
	<div class="form-group">
		<?php foreach($result as $sql) : ?>
		<label>id kategori</label>
		<input type="text" class="form-control" name="id_kategori" value="<?= $sql["id_kategori"]; ?>">
		<label>kategori</label>
		<input type="text" class="form-control" name="kategori" value="<?= $sql["kategori"]; ?>">
		<?php endforeach; ?>
	</div>
	<div class="form-group">
		<button type="submit" name="submit" class="btn btn-sm btn-default"><i class="fa fa-plus-circle"></i>Edit</button>
		<!-- <a href="kategori.php">
		<button class="btn btn-sm btn-default"><i class="fa fa-plus-circle"></i> Kembali</button>
		</a> -->
	</div>
	</form>
		</div>
	</div>
</div>