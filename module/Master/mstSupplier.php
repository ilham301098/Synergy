<div class="header bg-primary pb-6">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row py-4">
				<div class="col-lg-8 col-md-5 col-sm-12">
					<!-- <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6> -->
					<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
						<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
							<li class="breadcrumb-item"><a href="main-access.php"><i class="fas fa-home"></i></a></li>
							<!-- <li class="breadcrumb-item"><a href="#">Components</a></li> -->
							<li class="breadcrumb-item active" aria-current="page">Master Data</li>
						</ol>
					</nav>
				</div>
				<div class="col-lg-4 col-md-7 col-sm-12 text-right" >
					<form action="" method="post">
						<div class="row align-items-center" align="right">
							<button class="btn btn-primary" type="button" data-toggle="modal" data-target=".bs-modalNew"><i class="fa fa-plus"></i> Supplier</button>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class="col-sm-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">

				<div class="card-body">
					<div class="card-title">
						<h2>Supplier</h2>
					</div>
					<?php
					if(isset($_POST['addNew'])){

						$data = mysqli_query($con,"INSERT INTO supplier (`IDSUPPLIER`,`SUPPLIER`,`ALAMAT`,`PHONE`,`VCREABY`) VALUES ('".$_POST['IDSUPPLIER']."','".$_POST['SUPPLIER']."','".$_POST['ALAMAT']."','".$_POST['PHONE']."','".$_SESSION['CABANG_CODENAME']."')");
							echo basicSweetAlert('Data Berhasil disimpan','Data Gagal disimpan.',$data);

						}
						?>


						<div class="table-responsive">

							<table class="table table-striped table-hover ">
								<thead class="thead-dark">
									<tr>
										<th>Kode Supplier</th>
										<th>Nama Supplier</th>
										<th>Alamat</th>
										<th>Phone</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$res=mysqli_query($con,"SELECT * FROM supplier");
									foreach ($res as $res) { ?>
										<tr>
											<td><?= $res['IDSUPPLIER'] ?></td>
											<td><?= $res['SUPPLIER'] ?></td>
											<td><?= $res['ALAMAT'] ?></td>
											<td><?= $res['PHONE'] ?></td>
										</tr>
									<?php }	?>
									
								</tbody>
								<tfoot>
									<tr>
										<th>Kode Supplier</th>
										<th>Nama Supplier</th>
										<th>Alamat</th>
										<th>Phone</th>
									</tr>
								</tfoot>
							</table>


						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include('module/footer.php') ?>
	</div>



	<div class="modal fade bs-modalNew" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">

			<div class="modal-content">

				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel" align="center">Tambah Supplier</h4>
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="" method="post" autocomplete="off">
						<?php
						require_once('config/db.php');
						$cek=mysqli_fetch_assoc(mysqli_query($con,"SELECT MAX(IDSUPPLIER)AS IDSUPPLIER FROM Supplier WHERE IDSUPPLIER LIKE '%SUP001%'"));
						$temp=$cek['IDSUPPLIER'];
						$fixed = substr($temp,0,5);
						$IDP=sprintf("%05d", $fixed+1)."SUP901";
						?>
						<div class="form-group" align="center">
							<div class="form-input">
								<label>Kode Supplier</label>
								<input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control" value="<?php echo $IDP; ?>" disabled="" />
								<input type="hidden" name="IDSUPPLIER" value="<?php echo $IDP; ?>">
							</div>
						</div>
						<div class="form-group" align="center">
							<div class="form-input">
								<label>Nama Supplier</label>
								<input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control" name="SUPPLIER" value="" placeholder="Deskripsi Supplier" required/>
							</div>
						</div>
						<div class="form-group" align="center">
							<div class="form-input">
								<label>Alamat</label>
								<input type="text" class="form-control" name="ALAMAT" />
							</div>
						</div>
						<div class="form-group" align="center">
							<div class="form-input">
								<label>Phone</label>
								<input type="text" class="form-control" name="PHONE" />
							</div>
						</div>

						<div class="form-group" align="center">
							<input type="hidden" name="idSupplier" value="<?php echo $IDP; ?>">
							<button class="btn btn-md btn-primary" type="submit" name="addNew">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

