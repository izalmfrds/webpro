<?php 
session_start();

require('koneksi.php');
require('config.php');
require_once 'lib/site_title.php';
require_once 'lib/redirect.php';

if (!isset($_GET['id'])) redirect('404');
$limit = 5;
if(isset($_GET['p'])){
    $noPage = $con->real_escape_string($_GET['p']);
}
else $noPage = 1;

$offset = ($noPage - 1) * $limit;

$sqlKategori = "SELECT kategori FROM kategori WHERE id_kategori='".$con->real_escape_string($_GET['id'])."'";

$qryKategori = $con->query($sqlKategori);

$jumlah = $qryKategori->num_rows;

if ($jumlah > 0) {
	$kategori = $qryKategori->fetch_assoc();

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

	$sqlIndex = "SELECT
	berita.id_berita,
	berita.judul,
	berita.gambar,
	berita.teks_berita,
	berita.tgl_posting,
	berita.status,
	berita.dilihat,
	admin.id_admin,
	admin.nama_lengkap,
	kategori.id_kategori,
	kategori.kategori
	FROM
	admin
	INNER JOIN berita ON admin.id_admin = berita.id_admin
	INNER JOIN kategori ON kategori.id_kategori = berita.id_kategori
	WHERE kategori.id_kategori = '".$con->real_escape_string($_GET['id'])."'
	ORDER BY
	berita.tgl_posting DESC
	LIMIT ".$con->real_escape_string($offset).",". $con->real_escape_string($limit);

	$sql_rec = "SELECT id_berita FROM berita WHERE id_kategori = '".$con->real_escape_string($_GET['id'])."'";

	$total_rec = $con->query($sql_rec);

	$total_rec_num = $total_rec->num_rows;

	$qryIndex = $con->query($sqlIndex);

	$total_page = ceil($total_rec_num/$limit);
} else {
	echo "<script>window.location = '404.php'</script>";
}
?>
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
			              <a class="nav-link" href="login.php" style="color: white;background-color: #4646b4; border-radius: 5px; font-size: 12px; font-weight: bold; margin-right: 5px;">Login</a>
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

            <li class="nav-item active">
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

						<h4>Berita dengan kategori "<strong><?php echo $kategori['kategori']; ?></strong>"</h4>
						<?php while ($post_kat = $qryIndex->fetch_assoc()) { ?>
							<?php if($post_kat['status'] == 'ya') { ?>
						<div class="post">
							<div class="row post-title">
								<div class="col-sm-12">
									<a href="<?php echo $base_url."Berita/berita.php?id_berita=".$post_kat['id_berita']."&amp;judul=".strtolower(str_replace(" ", "-",$post_kat['judul'])); ?>">
										<h2><?php echo ($post_kat['judul']); ?></h2>
									</a>
								</div>
							</div>
							<div class="row post-meta">
								<div class="col-sm-3">
									<i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;
									<a href="<?php echo $base_url."author.php?id=".$post_kat['id_admin']; ?>">
										<?php echo $post_kat['nama_lengkap']; ?>
									</a>
								</div>
								<div class="col-sm-3">
									<i class="glyphicon glyphicon-calendar"></i>&nbsp;&nbsp;
									<?php echo $post_kat['tgl_posting']; ?>
								</div>
								<div class="col-sm-3">
									<i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;<em><?php echo $post_kat['kategori']; ?></em>
								</div>
							</div>
							<div class="row post-content">
								<div class="col-sm-12 excerpt">
									<img src="<?php echo $base_url."images/".$post_kat['gambar']; ?>" class="wow fadeIn">
									<?php echo substr($post_kat['teks_berita'], 0,200); ?>...
									<a href="<?php echo $base_url."Berita/berita.php?id_berita=".$post_kat['id_berita']; ?>">
										Selengkapnya <i class="glyphicon glyphicon-chevron-right"></i>
									</a>
								</div>
							</div>
						</div>
					<?php } ?>
						<?php } ?>
					</div>
					
					<div class="col-md-12">
						<ul class="pagination">
						<?php if ($total_rec_num > $limit): ?>
						<?php if ($noPage > 1) { ?>
							<li>
								<a href="<?php echo $base_url."kategori.php?id=".$_GET['id']."&amp;p=".($noPage-1);?>">
									<i class="glyphicon glyphicon-chevron-left"></i>
								</a>
							</li>
						<?php } ?>
						<?php for ($page=1; $page <= $total_page ; $page++) { ?>
							<?php if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $total_page)) { ?>
								<?php
									$showPage = $page;
									if ($page==$total_page && $noPage <= $total_page-5) echo "<li class='active'><a>...</a></li>";
            						if ($page == $noPage) echo "<li class='active'><a href='#'>".$page."</a></li> ";
            						else echo " <li><a href='".$_SERVER['PHP_SELF']."?id=".$_GET['id']."&amp;p=".$page."'>".$page."</a></li> ";
            						if ($page == 1 && $noPage >=6) echo "<li class='active'><a>...</a></li>";
								?>
							<?php } ?>
						<?php } ?>
						<?php if ($noPage < $total_page) { ?>
							<li>
								<a href="<?php echo $base_url."kategori.php?id=".$_GET['id']."&amp;p=".($noPage+1); ?>">
									<i class="glyphicon glyphicon-chevron-right"></i>
								</a>
							</li>
						<?php } ?>
						<?php endif ?>
						</ul>

					</div>
				</div>
				<?php include 'sidebar.php'; ?>
			</div>
<div class="footer">
                <p class="copy">@Copyright By Kelompok Berita Bencana</p>
        </div>