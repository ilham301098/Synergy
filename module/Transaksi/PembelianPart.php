<!-- Awal dari tag Part-->
<div class="col-md-12">
	
	<?php
	require_once('config/db.php');

	if(isset($_POST['deletePart'])){
		$old=getDtlPartBUY($_POST['ID']);

		$kode=cekCABANG($_SESSION['CABANG'],"INIT");

		kurangiStock($kode,$old['PARTNUM'],$old['QTY']);

		$del=deleteDtlPartBUY($_POST['ID']);

		echo basicSweetAlert('Data Berhasil di Hapus.','Data Gagal di Hapus.',$del);
	}

	if(isset($_POST['addPart'])){
		$aksi=insertPartBUY($_POST['partnum']);
		echo basicSweetAlert('Data Berhasil di Simpan.','Data Gagal di Simpan. (Part telah tersedia di PKB ini.',$aksi);
	}

	if(isset($_POST['editDetailPart'])){
		$updatePart=updPartBeli($_POST['ID'],$_POST['qtyPart']);
		basicSweetAlert("Data Berhasil di Update","Data Gagal di Update",$updatePart);
	}

	?>
	<div class="form-group">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus"></i> Part</button>
			</div>
		</div>
	</div>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Part Description</th>
				<th>Qty</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$ind=0;
			$part=getAllPartBUY($NewID);
			foreach ($part as $part) { $ind++;	?>
				<form action="" method="post">
					<tr>
						<td><?php echo $ind; ?></td>
						<td>(<?php echo $part['PARTNUM']; ?>)<br><?php echo $part['PARTDESC']; ?></td>
						<td><?php echo $part['QTY']; ?></td>
						<td>
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bs-example-modal-smDetailPart<?php echo str_replace("/",'',$part['ID']); ?>"><i class="fa fa-edit"></i></button>

							<input type="hidden" name="ID" value="<?php echo $part['ID']; ?>">
							<input type="hidden" name="PARTNUM" value="<?php echo $part['PARTNUM']; ?>">
							<button class="btn btn-danger btn-sm" name="deletePart" type="submit"><i class="fa fa-times"></i></button>

						</td>
					</tr>
				</form>

				<div class="modal fade bs-example-modal-smDetailPart<?php echo str_replace("/",'',$part['ID']); ?>" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-sm">

						<div class="modal-content">

							<div class="modal-header">
								<h4 class="modal-title" id="myModalLabel" align="center">Detail Information</h4>
								<button type="button" class="close" data-dismiss="modal">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="modal-body">
								<div align="center">

									<form action="" method="post" autocomplete="off">
										<div class="col-md-12">
											<div class="col-md-12 form-group has-feedback">
												<label>PART DESCRIPTION :</label>
												<h2><?php echo $part['PARTDESC']; ?></h2>

											</div>
											<div class="col-md-12 form-group has-feedback">
												<label>QTY :</label>
												<input type="number" class="form-control" min="0" value="<?php echo number_format($part['QTY']); ?>" name="qtyPart" />
											</div>	
											<input type="hidden" name="partnum" value="<?php echo $part['PARTNUM']; ?>">	
											<input type="hidden" name="ID" value="<?php echo $part['ID']; ?>">	

											<input class="btn btn-primary btn-lg" name="editDetailPart"  type="submit" value="Update">
										</div>
									</form>
								</div>
							</div>

						</div>

					</div>
				</div>
			<?php }	?>
		</tbody>
	</table>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Silahkan Pilih Part</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="example" id="datatable-buttons"  class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Part Number</th>
								<th>Part Description</th>
								<th>Price</th>
								<th>Action</th>
								<th>Stock</th>
							</tr>
						</thead>

						<tfoot>
							<tr>
								<th>Part Number</th>
								<th>Part Description</th>
								<th>Price</th>
								<th>Action</th>
								<th>Stock MKM</th>
								<th>Stock SJM</th>
								<th>Stock SKM</th>
								<th>Stock JAM</th>
								<th>Stock PSJM</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			<div class="modal-footer">

			</div>

		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#example').DataTable( {
			"processing": true,
			"serverSide": true,
			"ajax": "config/load-beliPart.php",
		} );
	} );
</script>
<!-- Akhir dari tag Part-->
