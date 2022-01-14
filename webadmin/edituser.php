<?php 
include 'header.php';

$id = $_GET["id"];

$a = query("SELECT * FROM users WHERE id= '$id'")[0];

if(isset($_POST['submit'])) {

$name=$_POST['name'];
$username=$_POST['username'];
$email=$_POST['email'];

if (edit_user($_POST) > 0 ) {
  
    echo '<div class="alert alert-success">Data berhasil di update</div>';
    header("location:kelolauser.php");
    exit;

}else{

  echo '<div class="alert alert-danger">Data gagal di update</div>';
  mysqli_error($con);

}



}

 ?>
<div class="col-lg-10 main-content">
  <div class="panel panel-default">
  <div class="panel-body">
  <div class="row">
    <div class="col-md-12">
      <h2 class="page-header"><i class="fa fa-folder-o"></i> Edit User</h2>
    </div>
<div class="row">
  <div class="col-md-12">
    <div class="col-md-12">
<form action="" method="post">
  <div class="form-group">
    <label for="name">Nama Lengkap</label>
    <input type="hidden" name="id" value="<?= $a['id']; ?>">
    <input type="text" class="form-control" name="name" placeholder="nama" value="<?= $a['name']; ?>">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">username</label>
    <input type="username" class="form-control" name="username" value="<?= $a['username']; ?>">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">E-mail</label>
    <input type="email" class="form-control" name="email" value="<?= $a['email']; ?>">
  </div>

  <div>
  <button type="submit" name="submit" style="float:right;" class="btn btn-md btn-success"><i class="fa fa-edit"></i></button>
  </div>

  <div>
  <button onclick="document.location.href='kelolauser.php'" type="button" class="btn btn-md btn-danger" style="float:right;"><i class="fa fa-times" aria-hidden="true"></i></button>
  </div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>