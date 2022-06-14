

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
							<button class="btn btn-primary" type="button" data-toggle="modal" data-target=".bs-modalNew"><i class="fa fa-plus"></i> Part</button>
							<button class="btn btn-success" type="button" data-toggle="modal" data-target=".bs-modalCSV"><i class="fa fa-upload"></i>  CSV</button>
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
						<h2>Sparepart</h2>
					</div>
					<?php
					if(isset($_POST['addNew'])){

						$data = mysqli_query($con,"INSERT INTO part (`VPARTNUM`,`VPARTDESC`,`MHETPART`,`VCREABY`) VALUES ('".$_POST['idpart']."','".$_POST['descpart']."','".$_POST['harga']."','".$_SESSION['CABANG_CODENAME']."')");
						echo basicSweetAlert('Data Berhasil disimpan','Data Gagal disimpan.',$data);

					}
					?>


					<?php
					require_once("config/db.php");
					if(isset($_POST["View"])){
						$filename=$_FILES["file"]["tmp_name"];
						$cek=false;
						$no=0;

						$file = fopen($filename, "r");
						while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
							$no++;
							if(strpos($getData[0], '+') !== false){
								$cek=true;
								echo "Error!<br>";
								echo "Silahkan cek part ".$getData[1]." pada baris ke-".$no.".<br>";
							} 
						}
						fclose($file); 

						if($cek===false){
							$no=0;
							$in=0;
							$upd=0;
							$ins=0;
							$upds=0;

							if($_FILES["file"]["size"] > 0) {
								$file = fopen($filename, "r");
								while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){

									$partnum=mysqli_real_escape_string($con,$getData[0]);
									$partdesc=mysqli_real_escape_string($con,$getData[1]);
									$harga=mysqli_real_escape_string($con,$getData[2]);

									$no++;
									$result=mysqli_query($con,"SELECT * FROM part WHERE VPARTNUM='". $getData[0]."'");
									if ($row = mysqli_fetch_assoc($result)) {
										$sql = "UPDATE part SET `VPARTDESC`='".$partdesc."',`MHETPART`='".$harga."' WHERE `VPARTNUM`='".$partnum."'";
										$result = mysqli_query($con, $sql);
										if($result){
											$upds++;
										}
										$upd++;
									}else{
										$sql = "INSERT INTO part (`VPARTNUM`,`VPARTDESC`, `MHETPART`, `VCREABY`,`VMODIBY`) VALUES ('".$partnum."','".$partdesc."','".$harga."','".$_SESSION['CABANG_CODENAME']."','".$_SESSION['CABANG_CODENAME']."')";
											$result = mysqli_query($con, $sql);
											if($result){
												$ins++;
											}else{
												echo $sql;
											}
											$in++;

										}     
									}
									fclose($file); 
								}
								echo basicSweetAlert('CSV File has been successfully Imported. Process='.$no.' Part. Updated='.$upd.' Part, '.$upds.' Part Success. Insert='.$in.' Part, '.$ins.' Part Success','',true);
							}else{

								echo "FALSE CHECK";

							}
						}
						?>


						<div class="table-responsive">

							<table id="example" class="table table-striped table-hover ">
								<thead class="thead-dark">
									<tr>
										<th>Part Number</th>
										<th>Part Description</th>
										<th>Price</th>
										<th>Stok</th>
										<th>Action</th>

									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Part Number</th>
										<th>Part Description</th>
										<th>Price</th>
										<th>Stok</th>
										<th>Action</th>
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

	<div class="modal fade bs-modalCSV" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">

			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel" align="center">Upload Part via CSV</h4>
				</div>
				<div class="modal-body">

					<form class="form-horizontal" action="" method="post" name="upload_excel" enctype="multipart/form-data">
						<div class="col-md-12" align="center">
							<div class="form-group">
								<input type="file" name="file" id="file" class="input-large">
							</div>


							<button type="submit" id="submit" name="View" class="btn btn-primary button-loading" data-loading-text="Loading..."><i class="fa fa-upload"></i> Upload</button>
						</div>


					</form>
					<p>Contoh file csv :</p>
					<img src="Images/Help/HelpPart1.png" alt="" align="center" style="width: 270px;height: 120px;">
					<br>
					<p align="center">Maksimal 9000 Part dalam 1 CSV</p>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade bs-modalNew" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">

			<div class="modal-content">

				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel" align="center">Create New Part</h4>
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="" method="post" autocomplete="off">
						<?php
						require_once('config/db.php');
						$cek=mysqli_fetch_assoc(mysqli_query($con,"SELECT MAX(VPARTNUM)AS PARTNUM FROM part WHERE VPARTNUM LIKE '%SYN901%'"));
						$temp=$cek['PARTNUM'];
						$fixed = substr($temp,0,5);
						$IDP=sprintf("%05d", $fixed+1)."SYN901";
						?>
						<div class="form-group" align="center">
							<div class="form-input">
								<label>Part Number</label>
								<input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control" value="<?php echo $IDP; ?>" disabled="" />
							</div>
						</div>
						<div class="form-group" align="center">
							<div class="form-input">
								<label>Deskripsi Part</label>
								<input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control" name="descpart" value="" placeholder="Deskripsi Part" required/>
							</div>
						</div>
						<div class="form-group" align="center">
							<div class="form-input">
								<label>Harga</label>
								<input type="number" min="0" class="form-control" name="harga" value="" placeholder="Harga Part" required/>
							</div>
						</div>

						<div class="form-group" align="center">
							<input type="hidden" name="idpart" value="<?php echo $IDP; ?>">
							<button class="btn btn-md btn-primary" type="submit" name="addNew">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>



	<script type="text/javascript">
		$(document).ready(function() {
			$('#example').DataTable( {
				processing: true,
				serverSide: true,
				ajax: 'config/load-data.php',
				dom:"<'row col-sm-12 justify-content-center'<'col-sm-6'l><'col-sm-6'f>>" +
				"<'row col-sm-12 justify-content-center'<'col-sm-12'tr>>" +
				"<'row col-sm-12 justify-content-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			} );
		});
	</script>
