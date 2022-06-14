<?php include("function-Transaksi.php"); ?>
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

				<div class="card-body">
					<?php
					if(isset($_GET['Reprint'])){ ?>


						<div class="card-title">
							<h2>Cetak Ulang SO</h2>
						</div>
						<div class="col-md-12">
							<a href="?module=Transaksi/SO">
								<button class="btn-lg" ><i class="glyphicon glyphicon-arrow-left"></i>Kembali ke Transaksi SO</button>
							</a>
							<br>
						</div>

						<table  id="tableReprint" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Tanggal Transaksi</th>
									<th>ID. Transaksi</th>
									<th>Nama Pembeli</th>
									<th>Button</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no=0;
								$cek=getReprintSO();
								foreach ($cek as $cek) { $no++; ?>
									<tr>
										<td><?php echo $cek['DCREA']; ?></td>
										<td><?php echo $cek['IDTRANSPART']; ?></td>
										<td><?php echo $cek['BUYERNAME']; ?></td>
										<td>
											<form action="config/Print/printSO.php" method="post">
												<input type="hidden" name="noCABANG" value="<?php echo $_SESSION['CABANG']; ?>">
												<input type="hidden" name="addrCABANG" value="<?php echo $_SESSION['ADDRESS']; ?>">
												<input type="hidden" name="phoneCABANG" value="<?php echo $_SESSION['PHONE']; ?>">
												<input type="hidden" name="namaCABANG" value="<?php echo $_SESSION['NAME']; ?>">

												<input type="hidden" name="idKWT" value="<?php echo $cek['IDTRANSPART']; ?>">
												<button class="btn btn-sm btn-primary " type="submit" name="pdf">
													<i class="fa fa-print"></i> Sales Order
												</button>
											</form>

										</td>
									</tr>
								<?php } ?>						
							</tbody>

							<tfoot>
								<tr>
									<th>Tanggal Transaksi</th>
									<th>ID. Transaksi</th>
									<th>Nama Pembeli</th>
									<th>Button</th>
								</tr>
							</tfoot>
						</table>



					<?php }else{ ?>

						<div class="card-title">
							<h2>Sales Order</h2>
						</div>
						<?php

						if(isset($_POST['regisSO'])){
							createSO($_POST['nama'],$_POST['alamat'],$_POST['phone']);
						}

						if(isset($_POST['btnBayar'])){
							$pay=bayarSO($_POST['idtrans']);

							$btnPrint='
							<form action="config/Print/printSO.php" method="post">
							<input type="hidden" name="noCABANG" value="'.$_SESSION['CABANG'].'">
							<input type="hidden" name="addrCABANG" value="'.$_SESSION['ADDRESS'].'">
							<input type="hidden" name="phoneCABANG" value="'.$_SESSION['PHONE'].'">
							<input type="hidden" name="namaCABANG" value="'.$_SESSION['NAME'].'">

							<input type="hidden" name="idKWT" value="'.$_POST['idtrans'].'">
							<button class="btn btn-primary btn-lg" type="submit" name="pdf">Print</button>
							</form>';

							echo basicSweetAlert('Data Penjualan ('.$_POST['idtrans'].') Berhasil di Simpan.'.$btnPrint,'Data Penjualan ('.$_POST['idtrans'].') Gagal di Simpan.',$pay);
						}
						if(isset($_POST['CancelSO'])){
							batalSO();
						}
						$NewID="";

						if ($result = mysqli_fetch_assoc(checkSO())) { 
							//SO ON GOING
							$NewID=$result['IDTRANSPART'];
							?>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>No. Transaksi Penjualan</label>
										<input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control" value="<?php echo $NewID; ?>" readonly="">
									</div>
								</div>

								<div class="col-lg-6">
									<div class='form-group'>
										<label>Nama Customer</label>
										<input type="text" oninput="this.value = this.value.toUpperCase()" class='form-control' name='nama' value='<?php echo $result['BUYERNAME']; ?>' readonly=''>
									</div>
								</div>
							</div>

							<?php
							if(isset($_POST['addPart'])){
								$kode=cekCABANG($_SESSION['CABANG'],"INIT");
								$stock=getInfoPart($_POST['partnum'],$kode);
								if($stock>=1){
									$aksi=insertPartSO($_POST['partnum']);
									echo basicSweetAlert('Data Berhasil di Simpan.','Data Gagal di Simpan. (Part telah tersedia di SO ini.)',$aksi);
								}else{
									echo '
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<span class="alert-icon"><i class="ni ni-like-2"></i></span>
									<span class="alert-text"><strong>Terjadi Kesalahan!</strong>  Stok '.$_POST['partnum'].' - '.getInfoPart($_POST['partnum'],"VPARTDESC").' sisa '.getInfoPart($_POST['partnum'],$kode).'.</span>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
									</div>';
								}
							} 

							include("choosePart.php");

							?>


							<div class="col-md-12" align="center">
								<?php if($ind>0){ ?>
									<br>
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-modal-Pay">
										<i class="fa fa-dot-circle-o"></i> Simpan
									</button>
								<?php } ?>

								<br>

								<button type="button" style="background-color: transparent;border-color: transparent;"  data-toggle="modal" data-target=".bs-example-modal-smCancel"><font color="red"><small>Batal</small></font></button>
							</div>


							<div class="modal fade bs-modal-Pay" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-sm">

									<div class="modal-content">

										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
											</button>
											<h4 class="modal-title" id="myModalLabel" align="center">Pembayaran SO</h4>
										</div>
										<div class="modal-body">
											<form action="" method="post" autocomplete="off">
												<div align="center">
													<div class="form-group">
														<label>ID SO</label>
														<input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control" value="<?php 
														echo $NewID; ?>" name="idbayar" disabled>
													</div>
													<div class="form-group">
														<label>Total Tagihan</label>
														<input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control" value="<?php 
														echo number_format(getTotalPart($NewID)); ?>" disabled>
													</div>
													<input type="hidden" name="idtrans" value="<?php echo $NewID; ?>">
													<input type="hidden" name="grand" value="<?php echo getTotalPart($NewID); ?>">
													<button type="submit" class="btn btn-primary btn-lg" name="btnBayar" >Proses</button>

												</div>
											</form>
										</div>
									</div>
								</div>
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
													<p>Apakah anda yakin ingin membatalkan SO <?php echo $NewID; ?> ?</p>
												</div>

											</div>

											<div class="modal-footer">
												<button type="submit" name="CancelSO" class="btn btn-white">Ya, Yakin & Batalkan</button>
												<button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
											</div>
										</form>
									</div>
								</div>
							</div>

							<?php
						}else{

				//SO EMPTY
							$NewID=generateIDPartSO();
							?>
							<form action="" method="post" autocomplete="off" class="form-horizontal">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label>No. Transaksi Penjualan</label>
											<h2><?php echo $NewID; ?></h2>
										</div>
									</div>


									<div class="col-lg-4">
										<div class='form-group'>
											<label>Nama Konsumen</label>
											<input type="text" oninput="this.value = this.value.toUpperCase()" class='form-control' name='nama' required>
										</div>
									</div>

									<div class="col-lg-4">
										<div class='form-group'>
											<label>Alamat</label>
											<input type="text" oninput="this.value = this.value.toUpperCase()" class='form-control' name='alamat' required>
										</div>
									</div>

									<div class="col-lg-4">
										<div class='form-group'>
											<label>Phone</label>
											<input type="text" oninput="this.value = this.value.toUpperCase()" class='form-control' name='phone' required>
										</div>
									</div>

								</div>
								<div align="center">
									<button type="submit" name="regisSO" class="btn btn-primary" >Proses</button>
								</div>
							</form>


							<p>
								Cetak Ulang SO ?<strong> <a href="?module=Transaksi/SO&Reprint=1">Klik disini !</a></strong>
							</p>




							<div class="col-md-12">
								<hr>
								<h2>SO Hari Ini</h2>
							</div>

							<table  id="tableReprint" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Tanggal Transaksi</th>
										<th>ID. Transaksi</th>
										<th>Nama Pembeli</th>
										<th>Button</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no=0;
									$cek=getSOToday();
									foreach ($cek as $cek) { $no++; ?>
										<tr>
											<td><?php echo $cek['DCREA']; ?></td>
											<td><?php echo $cek['IDTRANSPART']; ?></td>
											<td><?php echo $cek['BUYERNAME']; ?></td>
											<td>
												<form action="config/Print/printSO.php" method="post">
													<input type="hidden" name="noCABANG" value="<?php echo $_SESSION['CABANG']; ?>">
													<input type="hidden" name="addrCABANG" value="<?php echo $_SESSION['ADDRESS']; ?>">
													<input type="hidden" name="phoneCABANG" value="<?php echo $_SESSION['PHONE']; ?>">
													<input type="hidden" name="namaCABANG" value="<?php echo $_SESSION['NAME']; ?>">

													<input type="hidden" name="idKWT" value="<?php echo $cek['IDTRANSPART']; ?>">
													<button class="btn btn-sm btn-primary " type="submit" name="pdf">
														<i class="fa fa-print"></i> Sales Order
													</button>
												</form>

											</td>
										</tr>
									<?php } ?>						
								</tbody>

								<tfoot>
									<tr>
										<th>Tanggal Transaksi</th>
										<th>ID. Transaksi</th>
										<th>Nama Pembeli</th>
										<th>Button</th>
									</tr>
								</tfoot>
							</table>


						<?php } ?>

					<?php } ?>
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


		<script>
			$(document).ready(function() {
				$('#example').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax": "config/load-SOPart.php",
				} );
			} );
		</script>