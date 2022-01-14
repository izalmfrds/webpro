<?php
session_start();

require('koneksi.php');
require('config.php');
require_once 'lib/site_title.php';
require_once 'lib/redirect.php';

$limit = 5;
if(isset($_GET['p']))
{
    $noPage = $_GET['p'];
}
else $noPage = 1;

$offset = ($noPage - 1) * $limit;

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

$sql = "SELECT
berita.id_berita,
berita.judul,
berita.gambar,
berita.teks_berita,
berita.tgl_posting,
berita.dilihat,
berita.status,
admin.id_admin,
admin.nama_lengkap,
kategori.id_kategori,
kategori.kategori
FROM
admin
INNER JOIN berita ON admin.id_admin = berita.id_admin
INNER JOIN kategori ON kategori.id_kategori = berita.id_kategori
ORDER BY
berita.tgl_posting DESC
LIMIT ".$con->real_escape_string($offset).",". $limit;

$result = mysqli_query($con, $sql);

//data untuk dihitung
$sql_rec = "SELECT id_berita FROM berita";

$total_rec = $con->query($sql_rec);

//Menghitung data yang diambil
$total_rec_num = $total_rec->num_rows;

$qryIndex = $con->query($sql);

//Total semua data
$total_page = ceil($total_rec_num/$limit);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Berita Kita</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/hover-min.css">
    <link rel="stylesheet" href="assets_2/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="stylesheet" href="assets_2/wow/css/animate.css">
    <script src="<?php echo $base_url; ?>assets_2/jquery/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.js"></script>

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
            <img src="assets/beritakita.png" alt="logo" style="width: 40px;" class="rounded-circle">
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
			              <a class="nav-link" href="login/login.php" style="color: white;background-color: #4646b4; border-radius: 5px; font-size: 12px; font-weight: bold; margin-right: 5px;">Login</a>
			            </li>
			      <?php } ?>


			      <?php 
				      if (isset($_SESSION['username']) ) {
				          echo " ";
				      }else{?>
						<li class="nav-item">
	              			<a class="nav-link" href="register.php" style="color: white;background-color: #4646b4; border-radius: 5px; font-size: 12px; font-weight: bold; margin-right: 5px;">Daftar</a>
	            		</li>
			      <?php } ?>


			        <?php 
			      	if(!isset($_SESSION['username'])) { 
			      		echo ""; 
			      	} else{ ?>

			      	<li class="nav-item">
	          			<a class="nav-link" href="logout.php" style="color: white;background-color: #4646b4; border-radius: 5px; font-size: 12px; font-weight: bold; margin-right: 5px;">Logout</a>
	       			</li>
	       			<?php } ?>

                    <?php 
                    if(!isset($_SESSION['username'])) { 
                        echo ""; 
                    } else{ ?>

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
            <img src="assets/beritakita.png" style="width: 200px;">
        </a>
        <ul class="nav nav-tabs" style="background-color: #000000; border-radius: 5px;">
            
            <li class="nav-item active">
              <a class="nav-link" href="index.php" style="color: white; font-weight: bold;" >Home</a>
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
 <main class="container-md p-5" style="background-color: white;">
        <div class="row">
            <div class="col-md-8 themed-grid-col" style="padding-right: 50px;">
                <div class="row">

                    <!-- MAIN CONTENT -->

                    <?php $no=1; while ($row=mysqli_fetch_assoc($result)) {
                            
                    ?>
                    <div class="col-md-12">
                        <?php if($row['status'] == 'ya') { ?>
                        <a href="Berita/berita.php?id_berita=<?= $row['id_berita']; ?>" style="text-decoration: none;"><h2><?= $row['judul']; ?></h2></a> 
                        <br>
                        <h5><?= $row['tgl_posting']; ?></h5>
                        <h5><?= $row['kategori'];  ?></h5>
                        <br>
                        <p><img src="images/<?= $row['gambar']; ?>" style="width: 250px; float: left;">
                        	<?= substr($row['teks_berita'],0, 500); ?> <!-- pemecah artikel -->
                         <a href="Berita/berita.php?id_berita=<?= $row['id_berita']; ?>" style="text-decoration: none; color: blue;">...Read More</a></p><br><br>
                        
                        <?php } ?>
                    </div>
                    

                	 <?php $no++; }?>


                    <div class="col-md-12">
                        <ul class="pagination">
                        <?php if ($total_rec_num > $limit) { ?>
                        <?php if ($noPage > 1 ) { ?>

                            <!-- navigasi previous -->
                             <li class=""><a href="<?php echo $base_url."index.php?p=".($noPage-1);?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                            <!-- end navigasi previous  -->
                        <?php } ?>

                        <?php for ($page=1; $page <= $total_page ; $page++) { ?>
                            <?php if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $total_page)) { ?>
                                <?php
                                    $showPage = $page;
                                    if ($page==$total_page && $noPage <= $total_page-5) echo "<li class='active'><a>...</a></li>";
                                    if ($page == $noPage) echo "<li class='active'><a href='#'>".$page."</a></li> ";
                                    else echo " <li><a href='".$_SERVER['PHP_SELF']."?p=".$page."'>".$page."</a></li> ";
                                    if ($page == 1 && $noPage >=6) echo "<li class='active'><a>...</a></li>";
                                ?>
                            <?php } ?>
                        <?php } ?>

                        <?php if ($noPage < $total_page) { ?>
                            <!-- navigasi next -->
                            <li class=""><a href="<?php echo $base_url."index.php?p=".($noPage+1);?>" aria-label="Previous"><span aria-hidden="true">&raquo;</span></a></li>
                            <!-- end navigasi next -->
                        <?php } ?>
                        <?php } ?>
                        </ul>
                    </div>
                </div>

            </div>
            <?php include 'sidebar.php'; ?>

            		<!-- end content -->

            <!-- SIDE BAR -->
            <!-- <div class="col-md-4 themed-grid-col">
                <p><img src="assets/Logo.png" width="150px" style="float: left;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis a</p>

                <h6>Update terbaru</h6>
                <div class="linksidebar">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="#">Bencana banjir melanda negri China</a><br><hr>
                        </div>
                        <div class="col-md-12">
                            <a href="#">Bencana banjir melanda negri China 21-okt-2021</a><br><hr>
                        </div>
                        <div class="col-md-12">
                            <a href="#">Bencana banjir melanda negri China 21-okt-2021</a><br><hr>
                        </div>
                        <div class="col-md-12">
                            <a href="#">Bencana banjir melanda negri China 21-okt-2021</a><br><hr>
                        </div>
                    </div>
                </div>

                <br>
                <h6>Berita Terpopuler</h6>
                <div class="linksidebar">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="#">Bencana banjir melanda negri China</a><br><hr>
                        </div>
                        <div class="col-md-12">
                            <a href="#">Bencana banjir melanda negri China 21-okt-2021</a><br><hr>
                        </div>
                        <div class="col-md-12">
                            <a href="#">Bencana banjir melanda negri China 21-okt-2021</a><br><hr>
                        </div>
                        <div class="col-md-12">
                            <a href="#">Bencana banjir melanda negri China 21-okt-2021</a><br><hr>
                        </div>
                    </div>
                </div>

                <br>
                <h6>Berita Terpopuler</h6>
                <div class="linksidebar">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="#">Bencana banjir melanda negri China</a><br><hr>
                        </div>
                        <div class="col-md-12">
                            <a href="#">Bencana banjir melanda negri China 21-okt-2021</a><br><hr>
                        </div>
                        <div class="col-md-12">
                            <a href="#">Bencana banjir melanda negri China 21-okt-2021</a><br><hr>
                        </div>
                        <div class="col-md-12">
                            <a href="#">Bencana banjir melanda negri China 21-okt-2021</a><br><hr>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="footer">
                <p class="copy">@Copyright By Kelompok Berita Bencana</p>
        </div>
</main>     

</body>
</html>

