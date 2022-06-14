<?php 
include("function-Transaksi.php"); 


if(isset($_POST['regisBUY'])){
	createBUY($_POST['faktur'],$_POST['nama']);
}

if(isset($_POST['btnBayar'])){
	$pay=bayarBUY($_POST['idtrans']);

	$data=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM buy_part WHERE IDBUYPART='".$_POST['idtrans']."'"));

	echo basicSweetAlert('Data Purchase Order Berhasil di Simpan.','Data Purchase Order Gagal di Simpan.',$pay);
}

if(isset($_POST['CancelBeli'])){
	batalBeli();
}
?>


<div class="header bg-primary pb-6">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
					<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
						<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
							<li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
							<li class="breadcrumb-item active" aria-current="page">Transaksi</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">

				<?php if(isset($_GET['Reprint'])){ ?>

					<div class="card-body">

						<div class="card-title">
							<h2>Cetak Ulang Purchase Order</h2>
						</div>

						<div class="col-md-12">
							<a href="?module=Transaksi/Pembelian">
								<button class="btn-lg" ><i class="glyphicon glyphicon-arrow-left"></i>Kembali ke Transaksi Pembelian</button>
							</a>
							
						</div>
						<br>
						<div class="table-responsive">
							<table id="tableReprint" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Tanggal Transaksi</th>
										<th>ID. Transaksi</th>
										<th>No. Faktur</th>
										<th>Supplier</th>
										<th>Button</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no=0;
									$query="SELECT * FROM buy_part WHERE CABANG='".$_SESSION['CABANG']."' AND STATTRX='1' ";

									$cek=mysqli_query($con,$query);
									foreach ($cek as $cek) { $no++; ?>
										<tr>
											<td><?php echo $cek['DCREA']; ?></td>
											<td><?php echo $cek['IDBUYPART']; ?></td>
											<td><?php echo $cek['FAKTUR']; ?></td>
											<td><?php echo $cek['SUPPLIER']; ?></td>
											<td>
												<form action="config/Print/printFaktur.php" method="post">

													<button type="button" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></button>

													<input type="hidden" name="noCABANG" value="<?php echo $_SESSION['CABANG']; ?>">
													<input type="hidden" name="addrCABANG" value="<?php echo $_SESSION['ADDRESS']; ?>">
													<input type="hidden" name="phoneCABANG" value="<?php echo $_SESSION['PHONE']; ?>">
													<input type="hidden" name="namaCABANG" value="<?php echo $_SESSION['NAME']; ?>">

													<input type="hidden" name="idKWT" value="<?php echo $cek['IDBUYPART']; ?>">
													<button class="btn btn-sm btn-primary " type="submit" name="pdf"><i class="fa fa-print"></i></button>

												</form>
											</td>	
										</tr>
									<?php } ?>						
								</tbody>

								<tfoot>
									<tr>
										<th>Tanggal Transaksi</th>
										<th>ID. Transaksi</th>
										<th>No. Faktur</th>
										<th>Supplier</th>
										<th>Button</th>
									</tr>
								</tfoot>
							</table>
						</div>


					</div>

				<?php }else{ ?>

					<div class="card-body">

						<div class="card-title">
							<h2>Purchase Order</h2>
						</div>
						<?php

						$NewID="";

						if ($result = mysqli_fetch_assoc(checkBUY())) { 
						//NSC ON GOING
							$NewID=$result['IDBUYPART'];
							?>
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label>No. Transaksi Penjualan</label>
										<h2><?php echo $NewID; ?></h2>
									</div>
								</div>

								<div class="col-lg-4">
									<div class='form-group'>
										<label>No. Faktur</label>
										<h2><?php echo $result['FAKTUR']; ?></h2>
									</div>
								</div>

								<div class="col-lg-4">
									<div class='form-group'>
										<label>Nama Supplier</label>
										<h2><?php echo $result['SUPPLIER']; ?></h2>
									</div>
								</div>
							</div>

							<?php include("PembelianPart.php");?>


							<div align="center">
								<form action="" method="post" autocomplete="off">
									<?php if($ind>0){ ?>
										<br>

										<input type="hidden" name="idtrans" value="<?php echo $NewID; ?>">
										<button type="submit" class="btn btn-primary" name="btnBayar" >Proses</button>

									<?php } ?>
									<br>
									<button type="button" style="background-color: transparent;border-color: transparent;"  data-toggle="modal" data-target=".bs-example-modal-smCancel"><font color="red"><small>Batal</small></font></button>
								</form>
							</div>


							<div class="modal fade bs-example-modal-smCancel" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
									<div class="modal-content bg-gradient-danger">

										<div class="modal-header">
											<h6 class="modal-title" id="modal-title-notification">Konfirmasi Batal</h6>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
										</div>
										<form action="" method="post">
											<div class="modal-body">

												<div class="py-3 text-center">
													<i class="ni ni-bell-55 ni-3x"></i>
													<h4 class="heading mt-4">Perhatian!</h4>
													<p>Apakah anda yakin ingin membatalkan Pembelian <?php echo $NewID; ?> ?</p>
												</div>

											</div>

											<div class="modal-footer">
												<button type="submit" name="CancelBeli" class="btn btn-white">Ya, Yakin & Batalkan</button>
												<button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
											</div>
										</form>
									</div>
								</div>
							</div>



						<?php }else{

						//NSC EMPTY
							$NewID=generateIDPartBUY();
							?>
							<form action="" method="post" autocomplete="off" class="form-horizontal">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label>No. Transaksi Pembelian</label>
											<h2><?php echo $NewID; ?></h2>
										</div>
									</div>

									<div class="col-lg-6">
										<div class='form-group'>
											<label>Nama Supplier</label>
											<select class="form-control" name='nama'>
												<?php
												$sup=mysqli_query($con,'SELECT * FROM supplier');
												foreach ($sup as $sup) { ?>
													<option value="<?= $sup['IDSUPPLIER'] ?>"><?= $sup['SUPPLIER'] ?></option>
												<?php } ?>
												
											</select>
										</div>
									</div>

									<div class="col-lg-6">
										<div class='form-group'>
											<label>No. Faktur</label>
											<input type="text" oninput="this.value = this.value.toUpperCase()" class='form-control' name='faktur' required>
										</div>
									</div>
								</div>
								<div class="col-md-12" align="center">
									<button type="submit" name="regisBUY" class="btn btn-primary" >Proses</button>
								</div>

							</form>

							<p>
								Cetak Ulang Purchase Order ?<strong> <a href="?module=Transaksi/Pembelian&Reprint=1">Klik disini !</a></strong>
							</p>

							<hr>
							<br>
							<h2>Purchase Order Hari Ini</h2>

							<div class="table-responsive">
								<table id="tableReprint" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Tanggal Transaksi</th>
											<th>ID. Transaksi</th>
											<th>No. Faktur</th>
											<th>Supplier</th>
											<th>Button</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no=0;
										$query="SELECT * FROM buy_part WHERE CABANG='".$_SESSION['CABANG']."' AND STATTRX='1' AND DATE(DCREA)=DATE(NOW())";

										$cek=mysqli_query($con,$query);
										foreach ($cek as $cek) { $no++; ?>
											<tr>
												<td><?php echo $cek['DCREA']; ?></td>
												<td><?php echo $cek['IDBUYPART']; ?></td>
												<td><?php echo $cek['FAKTUR']; ?></td>
												<td><?php echo $cek['SUPPLIER']; ?></td>
												<td>
													<form action="config/Print/printFaktur.php" method="post">

														<button type="button" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></button>

														<input type="hidden" name="noCABANG" value="<?php echo $_SESSION['CABANG']; ?>">
														<input type="hidden" name="addrCABANG" value="<?php echo $_SESSION['ADDRESS']; ?>">
														<input type="hidden" name="phoneCABANG" value="<?php echo $_SESSION['PHONE']; ?>">
														<input type="hidden" name="namaCABANG" value="<?php echo $_SESSION['NAME']; ?>">

														<input type="hidden" name="idKWT" value="<?php echo $cek['IDBUYPART']; ?>">
														<button class="btn btn-sm btn-primary " type="submit" name="pdf"><i class="fa fa-print"></i></button>

													</form>
												</td>	
											</tr>
										<?php } ?>						
									</tbody>

									<tfoot>
										<tr>
											<th>Tanggal Transaksi</th>
											<th>ID. Transaksi</th>
											<th>No. Faktur</th>
											<th>Supplier</th>
											<th>Button</th>
										</tr>
									</tfoot>
								</table>
							</div>


						<?php } ?>
					</div>
				<?php } ?> 

				

			</div>


		</div>
	</div>
	<?php include('module/footer.php'); ?>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$('#tableReprint').DataTable( {
			dom:"<'row col-sm-12 justify-content-center'<'col-sm-6'l><'col-sm-6'f>>" +
			"<'row col-sm-12 justify-content-center'<'col-sm-12'tr>>" +
			"<'row col-sm-12 justify-content-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			order: [[ 0, "desc" ]]
		} );
	} );
</script>