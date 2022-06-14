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

?>