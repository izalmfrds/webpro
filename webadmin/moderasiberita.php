<?php include 'header.php'; ?>
<?php
$limit = 5;
if(isset($_GET['p']))
{
    $noPage = $_GET['p'];
}
else $noPage = 1;

$offset = ($noPage - 1) * $limit;

$sql = "SELECT
berita.id_berita,
berita.judul,
admin.id_admin,
berita.gambar,
berita.status,
berita.tgl_posting,
admin.nama_lengkap,
kategori.kategori
FROM
berita
INNER JOIN admin ON berita.id_admin = admin.id_admin
INNER JOIN kategori ON kategori.id_kategori = berita.id_kategori
ORDER BY berita.tgl_posting DESC
LIMIT ".$offset.",". $limit;
$qry = $con->query($sql);

$sql_rec = "SELECT id_berita FROM berita";

$total_rec = $con->query($sql_rec);

$total_rec_num = $total_rec->num_rows;

$total_page = ceil($total_rec_num/$limit);

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
							<h2 class="page-header"><i class="fa fa-newspaper-o"></i> Berita</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="clear"></div>
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Gambar</th>
										<th>Judul</th>
										<th>Status</th>
										<th>Pilihan</th>
									</tr>
								</thead>
								<tbody>
								<?php while ($news_list = $qry->fetch_assoc()) { ?>
									<tr>
										<td>
											<img src="../images/<?php echo $news_list['gambar']; ?>" height="75" width="75">
										</td>
										<td>
											<strong><?php echo $news_list['judul']; ?></strong>
										</td>
										<td>
											<?php if ($news_list['status']=='tidak') { ?>
											<label class="label label-danger">PERLU MODERASI</label>
											<?php } else { ?>
											<label class="label label-success">DITERIMA</label>
											<?php } ?>
								        </td>
										<td>
											<?php if ($news_list['id_admin'] == $_SESSION['id_admin'] or $_SESSION['level']=='admin') { ?>
											<a data-toggle="tooltip" data-placement="bottom" title="Ubah Status" href="ubahberitastatus.php?id_berita=<?= $news_list['id_berita']; ?>" class="btn btn-sm btn-success">
												<i class="fa fa-edit"></i>
											</a>
											<?php } else { ?>
											
											<?php } ?>
										</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
						<div class="col-md-12">
							<ul class="pagination">
							<?php if ($noPage > 1) { ?>

								<li>
									<a href="<?php echo "moderasiberita.php?p=".($noPage-1);?>">
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
            							else echo " <li><a href='".$_SERVER['PHP_SELF']."?p=".$page."'>".$page."</a></li> ";
            							if ($page == 1 && $noPage >=6) echo "<li class='active'><a>...</a></li>";
									?>
								<?php } ?>
							<?php } ?>

							<?php if ($noPage < $total_page) { ?>
								<li>
									<a href="<?php echo "moderasiberita.php?p=".($noPage+1); ?>">
										<i class="glyphicon glyphicon-chevron-right"></i>
									</a>
								</li>
							<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>