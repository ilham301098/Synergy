<div class="header bg-primary pb-6">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
					<!-- <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6> -->
					<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
						<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
							<li class="breadcrumb-item"><a href="main-access.php"><i class="fas fa-home"></i></a></li>
							<!-- <li class="breadcrumb-item"><a href="#">Components</a></li> -->
							<li class="breadcrumb-item active" aria-current="page">Master Data</li>
						</ol>
					</nav>
				</div>
				<div class="col-lg-6 col-5 text-right">
					
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			
			<div class="card-body">
				<div class="card-title">
					<h2>Master Data Konsumen</h2>
				</div>
				<div class="table-responsive">
					<table id="example" id="datatable-buttons"  class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th>Telepon</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$res=mysqli_query($con,"SELECT * FROM customer");

							foreach ($res as $res) { ?>
								<tr>
									<td><?= $res['created_at'] ?></td>
									<td><?= $res['nama'] ?></td>
									<td><?= $res['alamat'] ?></td>
									<td><?= $res['phone'] ?></td>
									<td>
										<button class="btn btn-primary"><i class="fas fa-edit"></i></button>
									</td>
								</tr>
							<?php }	?>
						</tbody>
						<tfoot>
							<tr>
								<th>Tanggal</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th>Telepon</th>
								<th>Aksi</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php include('module/footer.php') ?>
</div>
