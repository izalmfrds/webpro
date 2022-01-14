<?php
session_start();

require('../koneksi.php');
require('../config.php');
require_once '../lib/site_title.php';
require_once '../lib/redirect.php';

$sqlKat = 'SELECT
kategori.id_kategori,
kategori.kategori
FROM
kategori
INNER JOIN berita ON kategori.id_kategori = berita.id_kategori
GROUP BY
kategori.kategori
ORDER BY
kategori.id_kategori ASC
LIMIT 0, 5';
$qryKat = $con->query($sqlKat) or die($con->error);

$id = $_GET['id_berita'];

$sql = "SELECT * FROM berita WHERE id_berita = '$id' ";

$result=mysqli_query($con,$sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Berita Bencana Alam</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/bootstrap.js"></script>

    <style type="text/css">
        img{
            padding: 5px;
        }
    </style>
</head>
<body style="background-color: #f8f8f8;">

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-white">
      <div class="container-fluid">
        <a class="navbar-brand text-black" href="index.php">
            <img src="../assets/logo.png" alt="logo" style="width: 40px;" class="rounded-circle">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-3 mb-md-0">

			      <?php 
				      if (isset($_SESSION['username']) ) {
				          echo " ";
				      }else{?>
				          <li class="nav-item">
			              <a class="nav-link" href="../login.php" style="color: white;background-color: #4646b4; border-radius: 5px; font-size: 12px; font-weight: bold; margin-right: 10px;">Login</a>
			            </li>
			      <?php } ?>


			      <?php 
				      if (isset($_SESSION['username']) ) {
				          echo " ";
				      }else{?>
						<li class="nav-item">
	              			<a class="nav-link" href="../register.php" style="color: white;background-color: #4646b4; border-radius: 5px; font-size: 12px; font-weight: bold; margin-right: 10px;">Daftar</a>
	            		</li>
			      <?php } ?>


			      <?php 
			      	if(!isset($_SESSION['username'])) { 
			      		echo ""; 
			      	} else{ ?>

			      	<li class="nav-item">
	          			<a class="nav-link" href="../logout.php" style="color: white;background-color: #4646b4; margin-right: 2px; border-radius: 5px; font-size: 12px; font-weight: bold;">Logout</a>
	       			</li>
              <li class="nav-item">
                        <a class="nav-link" href="tambah_berita_user.php" style="color: white;background-color: #4646b4; border-radius: 5px; font-size: 12px; font-weight: bold;">Tambah Berita</a>
                    </li>
	       			<?php } ?>
            

          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Cari berita" aria-label="Search">
            <button class="btn btn-outline-success" type="submit" text-black>Cari</button>
          </form>
        </div>
      </div>
    </nav>
    <br>

<main class="container p-5 " style="background-color: #f8f8f8;">
        <a href="index.php">
            <img src="../assets/Logo.png" style="width: 200px;">
        </a>
        <ul class="nav nav-tabs" style="background-color: #000000; border-radius: 5px;">
            
            <li class="nav-item active">
              <a class="nav-link" href="../index.php" style="color: white; font-weight: bold;" >Home</a>
            </li>
            <?php while ($kat_menu=$qryKat->fetch_array()) { ?>

            <?php if (isset($_GET['kat']) && $kat_menu['id_kategori'] == $_GET['id']) { ?>

            <li class="nav-item">
                <a class="nav-link " href="<?php echo $base_url."kategori.php?id=".$kat_menu['id_kategori']."&amp;kat=".strtolower($kat_menu['kategori']); ?>">
                    <?php echo $kat_menu['kategori']; ?>
                </a>
            </li>

              <?php } else { ?>

                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $base_url."kategori.php?id=".$kat_menu['id_kategori']."&amp;kat=".strtolower($kat_menu['kategori']); ?>">
                    <?php echo $kat_menu['kategori']; ?>
                  </a>
                </li>

              <?php } ?>

              <?php } ?>

 <main class="container-sm p-5 " style="background-color: white; ">
        <div class="row">
            <div class="col-md-12 themed-grid-col">
                <div class="row">

                    <!-- MAIN CONTENT -->

                    <?php foreach($result as $row) : ?>

                    <div class="col-md-12 ">
                        <a href="#" style="text-decoration: none; "><h2><?= $row['judul']; ?></h2></a> 
                        <br>
                        <h5><?= $row['tgl_posting']; ?></h5>
                        <br>
                        <p style="text-align:center;">
                          <img src="../images/<?= $row['gambar']; ?>" style="width: 50%;">
                        	<?= $row['teks_berita']; ?> <!-- pemecah artikel -->
                        </p><br><br>
                    </div>

                	<?php endforeach; ?>
                </div>
            </div>

            		<!-- end content -->

            <!-- SIDE BAR -->
            <!-- end sidebar -->
        </div>
        <div class="footer">
                <p class="copy">@Copyright By Kelompok Berita Bencana</p>
        </div>
</main>     

</body>
</html>