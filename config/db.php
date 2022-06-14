<?php
/*
Author: Javed Ur Rehman
Website: http://www.allphptricks.com/
*/
date_default_timezone_set('Asia/Jakarta');

$con = mysqli_connect("localhost","root","","synergy");
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql_details = array(
	'user' => "root",
	'pass' => "",
	'db'   => "synergy",
	'host' => "localhost"
);


function message($success,$fail,$stat){
	if($stat==false){
		echo '
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<span class="alert-icon"><i class="ni ni-like-2"></i></span>
		<span class="alert-text"><strong>Terjadi Kesalahan!</strong> '.$fail.'</span>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
		</div>
		';

	}else{
		echo 
		'
		<div class="alert alert-success alert-dismissible fade show" role="alert">
		<span class="alert-icon"><i class="ni ni-like-2"></i></span>
		<span class="alert-text"><strong>Success!</strong> '.$success.'</span>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
		</div>
		';
	}
}

?>