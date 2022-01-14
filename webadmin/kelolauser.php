<?php 
include 'header.php';

$limit = 5;
if(isset($_GET['p']))
{
    $noPage = $_GET['p'];
}
else $noPage = 1;

$offset = ($noPage - 1) * $limit;

$sql = "SELECT * FROM users LIMIT ".$offset.",". $limit;
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
										<th>Nama</th>
										<th>Username</th>
										<th>Email</th>
										<th width="20%" style="text-align:center;">Aksi</th>
									</tr>
								</thead>
								<tbody>
								<?php while ($news_list = $qry->fetch_assoc()) { ?>
									<tr>
										<td><?= $news_list['name']; ?></td>
										<td><?= $news_list['username']; ?></td>
										<td><?= $news_list['email']; ?></td>
										<td align="center">
											<a href="edituser.php?id=<?= $news_list['id']; ?>" class="btn btn-sm btn-primary">
												<i class="fa fa-edit"></i>
											</a>
											<a href="hapususer.php?id=<?= $news_list['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau dihapus?')">
												<i class="fa fa-trash"></i>
											</a>
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
									<a href="<?php echo "kelolauser.php?p=".($noPage-1);?>">
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
									<a href="<?php echo "kelolauser.php?p=".($noPage+1); ?>">
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