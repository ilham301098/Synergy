<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "part";

$con = mysqli_connect($servername, $username, $password, $db);
if($con){

}else{
	echo "Connection failed: ";
}


?>