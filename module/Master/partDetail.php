<?php
require_once('config/db.php');
$partnum=$_GET['partnum'];


if(isset($_POST['opnamePart'])){
	require_once('config/db.php');
	$query="UPDATE `part` SET `".$_POST['INIT']."`='".$_POST['qtyOpname']."' WHERE `VPARTNUM`='".$_POST['PARTNUM']."'";
	$queryOpn="INSERT INTO `opname`(`INITCODE`,`PARTNUM`, `QTYOLD`, `QTYNEW`, `OPNAMEBY`) VALUES ('".$_POST['INIT']."','".$_POST['PARTNUM']."','".$_POST['qtyOld']."','".$_POST['qtyOpname']."','".$_SESSION['NAME']."')";
		$UPDATE=mysqli_query($con, $query);
		if (!$UPDATE) {
			echo basicSweetAlert('','Data Part '.$_POST['PARTNUM'].' Gagal Terupdate',false);
		}else{
			$opnAction=mysqli_query($con, $queryOpn);

			echo basicSweetAlert('Data Part '.$_POST['PARTNUM'].' Berhasil Terupdate.','Data Part '.$_POST['PARTNUM'].' Terupdate. Opname tidak tercatat! Hubungi Administrator!',$opnAction);
		}
	}



	$query=mysqli_query($con,"SELECT * FROM part WHERE VPARTNUM='$partnum'");
	$row=mysqli_fetch_array($query);
	$spCheck=false;
	if(isset($_GET['sp'])){
		$spCheck=true;
	}
	?>

	<div class="header bg-primary pb-6">
		<div class="container-fluid">
			<div class="header-body">
				<div class="row align-items-center py-4">
					<div class="col-lg-6 col-7">
						<!-- <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6> -->
						<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
							<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
								<li class="breadcrumb-item"><a href="main-access.php"><i class="fas fa-home"></i></a></li>
								<li class="breadcrumb-item"><a href="?module=Master/Part">Master</a></li>
								<li class="breadcrumb-item active" aria-current="page">Part</li>
							</ol>
						</nav>
					</div>
					<div class="col-lg-6 col-5 text-right">

					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="container-fluid mt--6">
		<div class="row justify-content-center">
			<div class="col-sm-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">

					<div class="card-body">
						<div class="card-title">
							<h2 align="center">Part Detail Information</h2>
						</div>


						<?php if($spCheck==false){ ?>
							<a href="?module=Master/mstpart"><button class="btn-lg" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali ke Master Part</button></a>
						<?php }else{ ?> 
							<a href="?module=Master/mstshopee"><button class="btn-lg" ><i class="glyphicon glyphicon-arrow-left"></i> Kembali ke Data Stok</button></a>
						<?php } ?>
						<br>
						<div class="row">

							<div class="col-lg-6">
								<form action="" method="post">
									<h3 align="center">Detail Sparepart</h3>

									<?php
									if(isset($_POST['updPart'])){
										$upd = mysqli_query($con,"UPDATE part SET `VPARTDESC`='".$_POST['VPARTDESC']."',`MHETPART`='".$_POST['MHETPART']."' WHERE `VPARTNUM`='".$_POST['VPARTNUM']."'");

										echo basicSweetAlert('Data Berhasil disimpan','Data Gagal disimpan.',$upd);

									}
									?>

									<div class="form-group">
										<label>Nomor Part</label>
										<input type="hidden" name="VPARTNUM" value="<?php echo $row['VPARTNUM']; ?>">
										<h4><?php echo $row['VPARTNUM']; ?></h4>
									</div> 

									<div class="form-group">
										<label>Nama Part</label>
										<input class="form-control" type="text" name="VPARTDESC" value="<?php echo $row['VPARTDESC']; ?>">
									</div>

									<div class="form-group">
										<label>Harga Part</label>
										<input class="form-control" type="text" name="MHETPART" value="<?php echo $row['MHETPART']; ?>">
									</div>

									<button class="btn btn-primary" type="submit" name="updPart">Simpan</button>

								</form>
							</div>



							<div class="col-lg-6" >
								<h3 align="center">Stok POS Synergy</h3>

								<div class="table-responsive">
									<table class="table table-sm table-bordered table-striped">
										<thead>
											<th>CABANG</th>	
											<th>Stock</th>				
										</thead>
										<tbody>

											<?php
											$qty=mysqli_query($con,"SELECT * FROM `CABANG`");
											foreach ($qty as $key) { ?>
												<tr>
													<th><?php echo $key['NAMA']; ?></th> 
													<td>
														<?php if($userRole=='0'){ ?>
															<a href="" data-toggle="modal" data-target=".bs-example-modal-sm-<?php echo $key['INIT']; ?>"><i class="fa fa-edit"></i> <?php echo $row[$key['INIT']]; ?></a>

														<?php }else{ 
															echo $row[$key['INIT']]; 
														} ?>
													</td> 
												</tr>

											<?php } ?>	

										</tbody>
									</table>
								</div>
							</div>


						</div>	

					</div>
				</div>
			</div>
		</div>
		<?php include('module/footer.php') ?>
	</div>


	<?php
	$qty=mysqli_query($con,"SELECT * FROM `CABANG`");
	foreach ($qty as $key) { ?>
		<div class="modal fade bs-example-modal-sm-<?php echo $key['INIT']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel" align="center">Stock Opname</h4>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body" align="center">
						<form action="" method="post">
							<div class="col-md-12 form-group has-feedback">
								<label>PART DESCRIPTION :</label>
								<h2><?php echo $row['VPARTDESC']; ?></h2>
							</div>

							<div class="col-md-12 form-group has-feedback">
								<label><?php echo $key['INIT']; ?> :</label>
								<h2>
									<?php echo $row[$key['INIT']]; ?>
								</h2>
							</div>

							<div class="col-md-12 form-group has-feedback">
								<label><?php echo $key['INIT']; ?> :</label>
								<input class="form-control" type="number" min="0" name="qtyOpname" value="<?php echo $row[$key['INIT']]; ?>">
							</div>

							<input type="hidden" name="qtyOld" value="<?php echo $row[$key['INIT']]; ?>">
							<input type="hidden" name="INIT" value="<?php echo $key['INIT']; ?>">
							<input type="hidden" name="PARTNUM" value="<?php echo $row['VPARTNUM']; ?>">
							<input type="hidden" name="PARTDESC" value="<?php echo $row['VPARTDESC']; ?>">

							<input class="btn btn-primary btn-lg" name="opnamePart" type="submit" value="Opname">

						</form>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
