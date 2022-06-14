<?php
date_default_timezone_set('Asia/Jakarta');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;

require('config/dbRep.php');
include "config/APIConfig.php";

function cekCABANG($noCABANG,$info){
	require("config/dbRep.php");
	$res=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM cabang WHERE CABANG='".$noCABANG."'"));
	return $res[$info];
}

function saveStr($str){
	require("config/dbRep.php");
	return mysqli_escape_string($con,$str);
}

$userCABANG=$_SESSION['CABANG_CODENAME'];
$userRole=$_SESSION['ROLE'];
$userNAME=$_SESSION['NAME'];
$userPHONE=$_SESSION['PHONE'];
$userADDRESS=$_SESSION['ADDRESS'];


?>

<!DOCTYPE html>
<html>


<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta id="vp" name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#000000">

	<title><?php echo ucwords(strtolower($userNAME)); ?> -  Smart System</title>
	<link rel="icon" href="Images/user.png" type="image/ico" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
	<link rel="stylesheet" href="components/assets/vendor/nucleo/css/nucleo.css" type="text/css">
	<!-- <link rel="stylesheet" href="components/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<link rel="stylesheet" href="components/assets/css/argon.css?v=1.2.0" type="text/css">

	<!-- Datatables -->
	<link href="components/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="components/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
	<link href="components/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
	<link href="components/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
	<link href="components/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
	<!-- <script src="components/src/js/jquery-2.2.1.min.js"></script> -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<style type="text/css">
		@keyframes ldio-xiexjbcpolf {
			0% { transform: rotate(0) }
			100% { transform: rotate(360deg) }
		}
		.ldio-xiexjbcpolf div { box-sizing: border-box!important }
		.ldio-xiexjbcpolf > div {

			/*display: inline-block;*/
			/*position: relative;*/
			/*top:40%;*/

			position: absolute;
			width: 144px;
			height: 144px;
			top: 28px;
			left: 28px;
			border-radius: 50%;
			border: 16px solid #000;
			border-color: #337ab7 transparent #337ab7 transparent;
			animation: ldio-xiexjbcpolf 1s linear infinite;
		}

		.ldio-xiexjbcpolf > div:nth-child(2), .ldio-xiexjbcpolf > div:nth-child(4) {
			width: 108px;
			height: 108px;
			top: 46px;
			left: 46px;
			animation: ldio-xiexjbcpolf 1s linear infinite reverse;
		}
		.ldio-xiexjbcpolf > div:nth-child(2) {
			border-color: transparent #5bc0de transparent #5bc0de
		}
		.ldio-xiexjbcpolf > div:nth-child(3) { border-color: transparent }
		.ldio-xiexjbcpolf > div:nth-child(3) div {
			position: absolute;
			width: 100%;
			height: 100%;
			transform: rotate(45deg);
		}
		.ldio-xiexjbcpolf > div:nth-child(3) div:before, .ldio-xiexjbcpolf > div:nth-child(3) div:after { 
			content: "";
			display: block;
			position: absolute;
			width: 16px;
			height: 16px;
			top: -16px;
			left: 48px;
			background: #337ab7;
			border-radius: 50%;
			box-shadow: 0 128px 0 0 #337ab7;
		}
		.ldio-xiexjbcpolf > div:nth-child(3) div:after {
			left: -16px;
			top: 48px;
			box-shadow: 128px 0 0 0 #337ab7;
		}

		.ldio-xiexjbcpolf > div:nth-child(4) { border-color: transparent; }
		.ldio-xiexjbcpolf > div:nth-child(4) div {
			position: absolute;
			width: 100%;
			height: 100%;
			transform: rotate(45deg);
		}
		.ldio-xiexjbcpolf > div:nth-child(4) div:before, .ldio-xiexjbcpolf > div:nth-child(4) div:after {
			content: "";
			display: block;
			position: absolute;
			width: 16px;
			height: 16px;
			top: -16px;
			left: 30px;
			background: #5bc0de;
			border-radius: 50%;
			box-shadow: 0 92px 0 0 #5bc0de;
		}
		.ldio-xiexjbcpolf > div:nth-child(4) div:after {
			left: -16px;
			top: 30px;
			box-shadow: 92px 0 0 0 #5bc0de;
		}
		.loadingio-spinner-double-ring-mgx9rl2r4nm {
			width: 200px;
			height: 200px;
			display: inline-block;
			overflow: hidden;
			background: none;
		}
		.ldio-xiexjbcpolf {
			width: 100%;
			height: 100%;
			position: relative;
			transform: translateZ(0) scale(1);
			backface-visibility: hidden;
			transform-origin: 0 0; /* see note above */
		}
		.ldio-xiexjbcpolf div { box-sizing: content-box; }
/* generated by https://loading.io/ */
</style>

<style type="text/css">
	
	.load-container {
		display: inline-block;
		position: relative;
		top:30%;
	}

	.overlay {
		z-index:999999;
		position: fixed;
		top:0;
		bottom: 0;
		left: 0;
		right: 0;
		background-color: rgba(22, 21, 21, 0.8);
		text-align: center;
	}

</style>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" type="text/css" href="components/assets/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.css" integrity="sha512-85w5tjZHguXpvARsBrIg9NWdNy5UBK16rAL8VWgnWXK2vMtcRKCBsHWSUbmMu0qHfXW2FVUDiWr6crA+IFdd1A==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.js" integrity="sha512-pF+DNRwavWMukUv/LyzDyDMn8U2uvqYQdJN0Zvilr6DDo/56xPDZdDoyPDYZRSL4aOKO/FGKXTpzDyQJ8je8Qw==" crossorigin="anonymous"></script>

<link href="components/main.css" rel="stylesheet">
<script src="components/main.js"></script>
<script src="components/js/html5-qrcode.min.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<?php

function sweetAlert($data){

	$alert="<script type='text/javascript'>";

	if($data['code']==200){
		if(isset($data['data']['message'])){
			$alert.="alertMGSS('success','Berhasil!','".$data['data']['message']."');";
		}else{
			$alert.="alertMGSS('success','Berhasil!','Pesan tidak tersedia');";
		}

	}else if($data['code']==500){
		$alert.="alertMGSS('error','Terjadi Kesalahan!','".$data['message']."');";

	}else{ 
		$alert.="alertMGSS('error','Fatal Error!','Silahkan hubungi CS');";
	}

	$alert.="</script>";

	return $alert;
}

function basicSweetAlert($sukses,$gagal,$aksi){

	$alert="<script type='text/javascript'>";
	if($aksi){
		$alert.="toastMGSS('success','Berhasil!','".$sukses."');";
	}else{
		$alert.="toastMGSS('error','Terjadi Kesalahan!','".$gagal."');";
	}
	$alert.="</script>";

	return $alert;
}

function simpleSweetAlert($flag,$msg){
	$stat='error';
	$title='Terjadi Kesalahan!';
	if($flag){
		$stat='success';
		$title='Berhasil!';
	}
	$alert="<script type='text/javascript'>toastMGSS('$stat','$title','$msg');</script>";

	return $alert;
}

?>

<script>
	window.onload = function() {
		if (screen.width == 1280) {
			console.log('resize');
			var mvp = document.getElementById('vp');
			mvp.setAttribute('content','user-scalable=no,width=1280');
		}
	}

		//Sweet Alert For All
		function alertMGSS(tipe,title_msg,msg){
			Swal.fire({
				title: title_msg,
				text: msg,
				icon: tipe,
				confirmButtonText: 'Ok'
			});
		}

		function toastMGSS(tipe,title_msg,msg){
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 4000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			})

			Toast.fire({
				icon: tipe,
				title: msg
			});
		}
	</script>

</head>


<!-- <body onload="hide_loading();"> -->

<body>
	<?php if(!isset($_SESSION['NAME'])){ ?>
		<script type="text/javascript">window.location="logout.php";</script>

		<?php 
	} 

		?>

		<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs " id="sidenav-main" style="margin-bottom: -20px;padding-top: 4px;background-color: #373737;">
			<div class="scrollbar-inner" style="background-color: #373737;">
				<!-- Brand -->
				<div class="sidenav-header  align-items-center">
					<a class="navbar-brand" href="javascript:void(0)">
						<h2 style="color:white;">POS Synergy</h2>
					</a>
				</div>
				<div class="navbar-inner">

					<!-- Collapse -->
					<div class="collapse navbar-collapse" id="sidenav-collapse-main">

						<?php 
						if(isset($userRole)){ 
							if($userRole=='0'){ 
								include("Menu/Owner.php");
							}else if($userRole=='1'){ 
								include("Menu/AdmSO.php");
							}else if($userRole=='2'){ 
								include("Menu/AdmPO.php");
							}
						} 
						?>

					</div>
					<!--NEW UI-->

					<div class="itm-container" style="margin-left: -20px;">
						<div class="itm">
							<svg width="304" height="274" viewBox="0 0 304 274" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M0.5 0.5C0.5 0.5 64.5 7 175 91C285.5 175 240 274 240 274H0.5V0.5Z" fill="#FFFFFF" fill-opacity="0.05"></path>
								<path d="M304 131C304 131 246.62 128.091 136 170C25.3802 211.909 0 274 0 274H304V131Z" fill="#FFFFFF" fill-opacity="0.05"></path>
							</svg>
						</div>
					</div>
					<!--END NEW UI-->
					<form action="logout.php" id="frmSoal" method='post' > 

					</form>
				</div>
			</div>
		</nav>


		<?php
	

	function menuActive($path){
		if (strpos($_SERVER['REQUEST_URI'], $path) !== false) {
			echo 'actives';
		}
	}

	?>

	<!-- Main content -->
	<div class="main-content" id="panel">
		<!-- Topnav -->

		<nav class="navbar navbar-top navbar-expand navbar-dark bg-default border-bottom">
			<div class="container-fluid">
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- Search form -->
					<form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
						<a href="main-access.php">
							<!-- <img alt="Image placeholder" src="Images/logo_honda.png"> -->
						</a>
					</form>

					<!-- NEW UI -->

					<button class="custom-avtr avtr">
						<div data-action="sidenav-pin" data-target="#sidenav-main">
							<i class="sidenav-toggler-line"></i>
							<i class="sidenav-toggler-line"></i>
							<i class="sidenav-toggler-line"></i>
						</div>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav mr-auto">

						</ul>
						<ul class="navbar-nav navbarRight">
							<li class="nav-item dropdown">
								<div class="avtr">
									<img class="img-fluid" alt="Nav profile" src="Images/user.png">
								</div>
							</li>
							<li class="nav-item iddty">
								<a class="titlename"><?php echo ucwords(strtolower($userNAME)); ?></a>
								<a class="titlerole">
									<?php 
									if(isset($userRole)){ 
										if($userRole=='0'){ 
											echo 'Owner';
										}else if($userRole=='1'){ 
											echo 'Admin Penjualan';
										}else if($userRole=='2'){ 
											echo 'Admin Pembelian';
										}
									} 
									?>
								</a>
							</li>
							<li class="nav-item">
								<div class="btn-logout">

									<a href="logout.php" class="mr-2 ml-3">Logout</a>
									<svg width="22" class="lg" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5 9H13V11H5V14L0 10L5 6V9ZM4 16H6.708C7.86269 17.0183 9.28669 17.6819 10.8091 17.9109C12.3316 18.14 13.8878 17.9249 15.291 17.2915C16.6942 16.6581 17.8849 15.6332 18.7201 14.3398C19.5553 13.0465 19.9995 11.5396 19.9995 10C19.9995 8.46042 19.5553 6.95354 18.7201 5.66019C17.8849 4.36683 16.6942 3.34194 15.291 2.7085C13.8878 2.07506 12.3316 1.85998 10.8091 2.08906C9.28669 2.31815 7.86269 2.98167 6.708 4H4C4.93066 2.75718 6.13833 1.74851 7.52707 1.05414C8.91581 0.359775 10.4473 -0.00116364 12 2.81829e-06C17.523 2.81829e-06 22 4.477 22 10C22 15.523 17.523 20 12 20C10.4473 20.0012 8.91581 19.6402 7.52707 18.9459C6.13833 18.2515 4.93066 17.2428 4 16Z" fill="#4D4D4D"></path>
									</svg>
								</div>
							</li>
						</ul>
					</div>

				</div>
			</div>
		</nav>

		<?php 
		require('config/dbRep.php');

		$allowed_role=[-1,0,1,2,3,4];
		if(!in_array($userRole,$allowed_role)){
			echo '<script type="text/javascript">window.location="logout.php";</script>';
		}


		if(!empty($_GET['module'])) {

			$module=$_GET['module'];
			include($module.'.php');
		} else {
			include('dashboard.php');
		}
		?>


	</div>



	<!-- Argon Scripts -->
	<!-- Core -->

	<script src="components/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="components/assets/vendor/js-cookie/js.cookie.js"></script>
	<script src="components/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
	<script src="components/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
	<!-- Optional JS -->
	<!-- <script src="components/assets/vendor/chart.js/dist/Chart.min.js"></script> -->
	<!-- <script src="components/assets/vendor/chart.js/dist/Chart.extension.js"></script> -->

	<!-- Argon JS -->
	<script src="components/assets/js/argon.js?v=1.2.0"></script>

	<script src="components/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="components/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="components/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="components/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
	<script src="components/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="components/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="components/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="components/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
	<script src="components/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
	<script src="components/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="components/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
	<script src="components/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>

	<script src="components/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>




	<script type="text/javascript">


		function number_format (number, decimals, decPoint, thousandsSep) { 
			number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
			const n = !isFinite(+number) ? 0 : +number
			const prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
			const sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
			const dec = (typeof decPoint === 'undefined') ? '.' : decPoint
			let s = ''
			const toFixedFix = function (n, prec) {
				if (('' + n).indexOf('e') === -1) {
					return +(Math.round(n + 'e+' + prec) + 'e-' + prec)
				} else {
					const arr = ('' + n).split('e')
					let sig = ''
					if (+arr[1] + prec > 0) {
						sig = '+'
					}
					return (+(Math.round(+arr[0] + 'e' + sig + (+arr[1] + prec)) + 'e-' + prec)).toFixed(prec)
				}
			}

			s = (prec ? toFixedFix(n, prec).toString() : '' + Math.round(n)).split('.')
			if (s[0].length > 3) {
				s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
			}
			if ((s[1] || '').length < prec) {
				s[1] = s[1] || ''
				s[1] += new Array(prec - s[1].length + 1).join('0')
			}
			return s.join(dec)
		}
	</script>

	<script>
		
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
	</script>


	<script>
		$(function () {
			$('#example1').DataTable({
				dom:"<'row col-sm-12 justify-content-center'<'col-sm-6'l><'col-sm-6'f>>" +
				"<'row col-sm-12 justify-content-center'<'col-sm-12'tr>>" +
				"<'row col-sm-12 justify-content-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			})
			$('#example2').DataTable({
				dom:"<'row col-sm-12 justify-content-center'<'col-sm-6'l><'col-sm-6'f>>" +
				"<'row col-sm-12 justify-content-center'<'col-sm-12'tr>>" +
				"<'row col-sm-12 justify-content-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			})
			$('#exampleT').DataTable()
			$('#example3').DataTable()
			$('#example4').DataTable()
			$('#example5').DataTable()
		})
	</script>

	<script type="text/javascript">
		let fadeTarget = document.querySelector(".loading")

		function show_loading() {
			fadeTarget.style.display = "block";
			fadeTarget.style.opacity = 1;
		}
		function hide_loading() {
			let fadeEffect = setInterval(() => {
				if (!fadeTarget.style.opacity) {
					fadeTarget.style.opacity = 1;
				}
				if (fadeTarget.style.opacity > 0) {
					fadeTarget.style.opacity -= 0.1;
				} else {
					clearInterval(fadeEffect)
					fadeTarget.style.display = "none"
				}
			},100)
		}

	</script>
</body>

</html>
