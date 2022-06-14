<?php

require_once('db.php');

$table = 'mstmotor';

$primaryKey = 'FRAMENUM';

$columns = array(
	array(
		'db' => 'DATE_CREATED',
		'dt' => 0,
		'formatter' => function( $d ) {
			return date("d-M-Y", strtotime($d));
		}
	),
	array(
		'db' => 'NOPOL',
		'dt' => 1,
		'formatter' => function( $d ) {
			return ' <a href="?module=Master/histDetail&idhist='.$d.'"><i class="fa fa-eye"></i></a>  
			<a href="?module=Master/editMotor&idhist='.$d.'"><i class="fa fa-edit"></i></a>
			  '.$d;
		}
	),
	array(
		'db' => 'FRAMENUM',
		'dt' => 2,
		'formatter' => function( $d ) {
			$hasil=strlen($d);
			$frame="";
			if($hasil!=17){
				$frame='<img src="Images/icons/Warning.png" alt="error"> ';
			}
			return $frame.$d;
		}
	),
	array(
		'db' => 'ENGINENUM',
		'dt' => 3,
		'formatter' => function( $d ) {
			$hasil=strlen($d);
			$engine="";
			if($hasil!=12){
				$engine='<img src="Images/icons/Warning.png" alt="error"> ';
			}
			return $engine.$d;
		}
	),
	array( 'db' => 'NAME', 'dt' => 4 ),
	array(
		'db' => 'PHONE',
		'dt' => 5,
		'formatter' => function( $d ) {
			$btn='';
			if(strlen($d)>10){
				$btn='<a href="https://wa.me/62'.$d.'?text=Salam%201%20Hati%2C%20%0A%0A" target="__blank"><img src="Images/WA.png" style="width: 25px;height: 25px" alt="img">
				</a>';
			}
			return $btn.$d;
		}
	),
	array( 'db' => 'CABANG', 'dt' => 6 ),
);

require( 'scripts/ssp.class.php' );

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

