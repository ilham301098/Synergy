<?php 
require_once('config/db.php');

?>

<h6 class="navbar-heading p-0 text-muted">
	<span class="docs-normal">General</span>
</h6>

<ul class="menu">

	<a class="linkRouter" href="?module=dashboardADM">
		<li class="menu menuHeader <?php echo menuActive('dashboardADM'); ?> margin-b-8">
			<i class="fas fa-th-large margin-r-8 header"></i><div class="menu-name">Dashboard</div>
		</li>
	</a>


</ul>

<h6 class="navbar-heading p-0 text-muted">
	<span class="docs-normal">Transaksi Part</span>
</h6>
<ul class="menu">
	<a class="linkRouter" href="?module=Transaksi/SalesOrder">
		<li class="menu menuHeader <?php echo menuActive('Transaksi/SalesOrder'); ?> margin-b-8">
			<i class="fa fa-basket-shopping margin-r-8 header"></i><div class="menu-name">Penjualan</div>
		</li>
	</a>

	<a class="linkRouter" href="?module=Report/Report">
		<li class="menu menuHeader <?php echo menuActive('Report/Report'); ?> margin-b-8">
			<i class="fa fa-file-contract margin-r-8 header"></i><div class="menu-name">Laporan</div>
		</li>
	</a>
</ul>


<h6 class="navbar-heading p-0 text-muted">
	<span class="docs-normal">Master Data</span>
</h6>
<ul class="menu">

	<a class="linkRouter" href="?module=Master/mstpart">
		<li class="menu menuHeader <?php echo menuActive('Master/mstpart'); ?> margin-b-8">
			<i class="fa fa-server margin-r-8 header"></i><div class="menu-name">Sparepart</div>
		</li>
	</a>

	<a class="linkRouter" href="?module=Master/mstmotor">
		<li class="menu menuHeader <?php echo menuActive('Master/mstmotor'); ?> margin-b-8">
			<i class="fa fa-person-biking margin-r-8 header"></i><div class="menu-name">Konsumen</div>
		</li>
	</a>


</ul>
