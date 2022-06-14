<?php
session_start();

function is_session_started(){
	if ( php_sapi_name() !== 'cli' ) {
		if ( version_compare(phpversion(), '5.4.0', '>=') ) {
			return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
		} else {
			return session_id() === '' ? FALSE : TRUE;
		}
	}
	return FALSE;
}


function goLogout(){
	$script='<script type="text/javascript">window.location="logout.php";</script>';
	return $script;
}


if(array_key_exists('USERNAME',$_SESSION) && !empty($_SESSION['CABANG_CODENAME'])) {
    include("module/base-template.php");
}else{
	echo goLogout();
}

?>
