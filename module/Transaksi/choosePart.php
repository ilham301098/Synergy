<!-- Awal dari tag Part-->
<?php
if(isset($_POST['deletePart'])){
	$old=getDtlPart($_POST['IDHIST']);
	$kode=cekCABANG($_SESSION['CABANG'],"INIT");

	tambahStock($kode,$old['PARTNUM'],$old['QTY']);

	$del=deleteDtlPart($_POST['IDHIST']);
	echo basicSweetAlert('Data Berhasil di Hapus.','Data Gagal di Hapus.',$del);
}

if(isset($_POST['editDetailPart'])){
	$kode=cekCABANG($_SESSION['CABANG'],"INIT");

	$data=getDtlPart($_POST['idHistPart']);

	if((getInfoPart($_POST['partnum'],$kode)+$data['QTY']-(int)$_POST['qtyPart'])>=0){
		$aksi=updatePart($_POST['idHistPart'],$_POST['discPart'],$_POST['discPartRp'],$_POST['qtyPart'],$_POST['paymentPart']);

		basicSweetAlert("Data Berhasil di Update","Data Gagal di Update",$aksi);
	}else{

		echo '
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<span class="alert-icon"><i class="ni ni-like-2"></i></span>
		<span class="alert-text"><strong>Terjadi Kesalahan!</strong> Stok '.$_POST['partnum'].' - '.getInfoPart($_POST['partnum'],"VPARTDESC").' sisa '.getInfoPart($_POST['partnum'],$kode).'</span>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
		</div>
		';
	}
}

$current=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM CABANG WHERE CABANG='".$_SESSION['CABANG']."'"));
$init=$current['INIT'];
$other=mysqli_query($con,"SELECT INIT FROM CABANG WHERE INIT!='$init' AND isActive='1' ORDER BY CABANG");
$head=[];
$head[]=str_replace('QTY','',$init);
foreach ($other as $CABANG) {
	$head[]=str_replace('QTY','',$CABANG['INIT']);
}

?>


<div class="form-group">
	<div class="input-group">
		<div class="input-group-btn">
			<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bs-example-modal-xl"><i class="fa fa-plus"></i> Part</button>
		</div>
	</div>
</div>
<div class="table-responsive">
	<table class="table align-items-center table-dark table-flush">
		<thead class="thead-dark">
			<tr>
				<th>#</th>
				<th>Part Description</th>
				<th>Price</th>
				<th>Qty</th>
				<th>Disc</th>
				<th>Sub Total</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$ind=0;
			$part=displayPart($result['IDTRANSPART']);
			foreach ($part as $part) { 
				$ind++;
				$disc=$part['DISCOUNT'];
				if($disc==0){
					$disc=$part['DISC_RP'];
				}
					?>
				<form method="post" action="">
					<tr align="center">
						<td>
							<?php echo $ind; ?>
						</td>
						<td>
							(<?php echo $part['PARTNUM']; ?>)<br><?php echo $part['PARTDESC']; 
							if($part['VPAYMENT']=='M'){ ?>
								<span class="badge badge-pill badge-md badge-primary">MD</span>
							<?php } ?>
						</td>
						<td>
							<?php echo number_format($part['PRICE']); ?>
						</td>
						<td>
							<?php echo $part['QTY']; ?>
						</td>			

						<?php if($part['VPAYMENT']=='K'){ ?>

							<td>
								<?php echo number_format($disc); ?>
							</td>
							<td>
								<?php echo number_format($part['TOTPAYPART']); ?>
							</td>

						<?php }else{ ?>

							<td colspan="2"><b>Main Dealer</b></td>

						<?php } ?>

						<td>
							<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bs-example-modal-smDetailPart<?php echo str_replace("/",'',$part['IDHIST']); ?>"><i class="fa fa-edit"></i></button>
							<input type="hidden" name="IDHIST" value="<?php echo $part['IDHIST']; ?>">
							<input type="hidden" name="PARTNUM" value="<?php echo $part['PARTNUM']; ?>">
							<button class="btn btn-sm btn-danger" name="deletePart" type="submit"><i class="fa fa-times"></i></button>
						</td>
					</tr>
				</form>
				<div class="modal fade bs-example-modal-smDetailPart<?php echo str_replace("/",'',$part['IDHIST']); ?>" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="myModalLabel" align="center">Detail Part</h4>
								<button type="button" class="close" data-dismiss="modal">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="modal-body" style="padding-top: 0px;">
								<div align="center">
									<form action="" method="post">
										<div class="row">
											<div class="col-md-12" style="margin-bottom: 0px;">
												<h5 align="center">Deskripsi</h5>
												<h4><?php echo $part['PARTDESC']; ?></h4>
											</div>

											<div class="col-md-6">
												<h5 align="center">Harga</h5>
												<h4 align="center"><?php echo number_format($part['PRICE']); ?></h4>
											</div>

											<div class="col-md-6">
												<h5 align="center">Qty</h5>
												<input type="number" min="0" class="form-control" value="<?php echo number_format($part['QTY']); ?>" name="qtyPart" />
											</div>
											
											<div class="col-md-6">
												<div class="form-group">
													<h5 align="center">Discount (%) * :</h5>
													<input type="number" min="0" max="100" class="form-control" name="discPart" value="<?php echo $part['DISCOUNT']/$part['PRICE']*100; ?>" />
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<h5 align="center">Discount (Rp) * :</h5>
													<input type="number" min="0" max="<?php echo $part['PRICE']; ?>" class="form-control" name="discPartRp" value="<?php echo $part['DISC_RP']; ?>" />
												</div>
											</div>

											<div class="col-md-12">
												<div class="text-muted text-center" style="margin-top: -20px;"><small style="font-color:red;">*Pilih Jenis Discount salah satu saja</small></div>
											</div>

											<div class="col-md-12 form-group has-feedback">
												<h5 align="center">Pembayaran  :</h5>
												<select class="form-control" name="paymentPart" >
													<option value="K" <?php if($part['VPAYMENT']=="K"){echo "selected";}?>>Konsumen</option>
													<option value="M" <?php if($part['VPAYMENT']=="M"){echo "selected";}?>>Main Dealer</option>
												</select>
											</div>			

											<div class="col-md-12" align="center">
												<input type="hidden" name="partnum" value="<?php echo $part['PARTNUM']; ?>">
												<input type="hidden" name="pricePart" value="<?php echo $part['PRICE']; ?>">		
												<input type="hidden" name="idHistPart" value="<?php echo $part['IDHIST']; ?>">	
												<input class="btn btn-primary btn-lg" name="editDetailPart" type="submit" value="Simpan">
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php 
			}	
			$totalPart=getTotalPart($result['IDTRANSPART']);
			if($totalPart>0){
				?>
				<tr align="center">
					<td colspan="5">Grand Total Part</td>
					<td>
						<b>Rp <?php echo number_format($totalPart); ?></b>
					</td>
					<td></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<!-- Akhir dari tag Part-->
<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="modal-title-default">Silahkan Pilih Part</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive">
						<table id="examplePart" class="table table-striped table-bordered" style="width:100%;">
							<thead>
								<tr>
									<th>Part Number</th>
									<th>Part Description</th>
									<th>Price</th>
									<th>Action</th>
									<?php
									for ($i=0; $i < count($head); $i++) { 
										echo '<th>Stok '.$head[$i].'</th>'; 
									}
									?>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Part Number</th>
									<th>Part Description</th>
									<th>Price</th>
									<th>Action</th>
									<?php
									for ($i=0; $i < count($head); $i++) { 
										echo '<th>Stok '.$head[$i].'</th>'; 
									}
									?>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	$(document).ready(function() {
		$('#examplePart').DataTable( {
			"processing": true,
			"serverSide": true,
			"ajax": "config/load-pkbPart.php?init=<?php echo $init; ?>",
			dom:"<'row col-sm-12 justify-content-center'<'col-sm-6'l><'col-sm-6'f> "+
			"<'col-sm-12'tr> >" +
			"<'row col-sm-12 justify-content-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
		} );
	} );
</script>