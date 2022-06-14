<?php 

session_start();


require_once('config/db.php');
if(isset($_POST['login'])){
	$query = "SELECT * FROM `member` WHERE USERNAME='".mysqli_escape_string($con,$_POST['username'])."' and PASSWORD='".md5(mysqli_escape_string($con,$_POST['password']))."'";

	if ($row = mysqli_fetch_assoc(mysqli_query($con, $query))) {
		$_SESSION['CABANG']=$row['CABANG'];
		$_SESSION['CABANG_CODENAME']=$row['CABANG'];
		$_SESSION['USERNAME']=$row['USERNAME'];
		$_SESSION['NAME']=$row['NAME'];
		$_SESSION['PHONE']=$row['PHONUM'];
		$_SESSION['ADDRESS']=$row['VADRESS'];
		$_SESSION['ROLE']=$row['ROLE_ID'];

		header('location:main-access.php');

	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>POS Synergy | Member</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php include("ComponentFE/head.php"); ?>

</head>
<body>
	<?php include("ComponentFE/header.php"); ?>
	<!-- END nav -->



	<section class="ftco-section ftco-booking bg-light">
		<div class="container ftco-relative">
			<div class="row justify-content-center pb-3">
				<div class="col-md-10 heading-section text-center ftco-animate">
					<span class="subheading">Login</span>
					<h2 class="mb-4">Member Area</h2>
				</div>
			</div>
			<h3 class="vr">Info: 031 - 123 3456</h3>
			<div class="row justify-content-center">
				<div class="col-md-10 ftco-animate">
					<form action="" method="post" class="appointment-form">
						<?php 

						if(isset($errMsg)){ ?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<?php echo $errMsg; ?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
						<?php } ?>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Username" name="username">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<input type="password" class="form-control" placeholder="Password" name="password">
								</div>
							</div>
						</div>
						<div class="form-group">
							<input type="submit" value="Login" name="login" class="btn btn-primary" >
						</div>
					</form>


					
				</div>
			</div>
		</div>
	</section>

	<section class="ftco-section ftco-team">
		<div class="container-fluid px-md-5">
			<div class="row justify-content-center pb-3">
				<div class="col-md-10 heading-section text-center ftco-animate">
					<h2 class="mb-4">Jaringan Kami</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 ftco-animate">
					<div class="carousel-team owl-carousel">
						<div class="item">
							<a href="#" class="team text-center">
								<div class="img" style="background-image: url(ComponentFE/images/Unknown.jpeg);"></div>
								<h2>Synergy Surabaya</h2>
								<span class="position">Cabang Surabaya</span>
							</a>
						</div>
						<div class="item">
							<a href="#" class="team text-center">
								<div class="img" style="background-image: url(ComponentFE/images/Unknown.jpeg);"></div>
								<h2>Synergy Jakarta</h2>
								<span class="position">Cabang Jakarta</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<?php include("ComponentFE/footer.php"); ?>

	<!-- loader -->
	<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>



	<?php include("ComponentFE/script.php"); ?>

</body>
</html>