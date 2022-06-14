<?php 
include("function-Report.php"); 
date_default_timezone_set('Asia/Jakarta');
$today=date('Y-m-d');

?>
<div class="header bg-primary pb-6">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
					<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
						<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
							<li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
							<li class="breadcrumb-item active" aria-current="page">Laporan</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title">
						<h2>Laporan</h2>
					</div>

					<div class="row" align="center">

						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
							<form action="config/Daily.php" method="post">
								<input type="hidden" name="noCABANG" value="<?php echo $_SESSION['CABANG']; ?>">
								<input type="hidden" name="addrCABANG" value="<?php echo $_SESSION['ADDRESS']; ?>">
								<input type="hidden" name="phoneCABANG" value="<?php echo $_SESSION['PHONE']; ?>">
								<input type="hidden" name="namaCABANG" value="<?php echo $_SESSION['NAME']; ?>">
								<div class='form-group'>
									<label>Report Transaksi</label>


									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
											</div>
											<input class="form-control datepicker" placeholder="Select date" name="HarSt" type="date" value="<?php echo $today; ?>" required>
											<button type="submit" name="btnDaily" class="btn btn-md btn-primary" >Proses</button>
										</div>
									</div>


								</div>
							</form>
						</div>

					</div>

				</div>
			</div>
		</div>


		<?php include('module/footer.php'); ?>
	</div>


	<script src="components/ckeditor/ckeditor.js"></script>