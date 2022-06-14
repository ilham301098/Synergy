<?php
require_once('db.php');

$table = "part";
$primaryKey = 'VPARTNUM';

$columns = array(
	array( 'db' => 'VPARTNUM', 'dt' => 0 ),
	array( 'db' => 'VPARTDESC',  'dt' => 1 ),
	array(
            'db' => 'MHETPART',
            'dt' => 2,
            'formatter' => function( $d ) {

                return number_format($d);
            }
        ),

	array( 'db' => 'QTYSYN',  'dt' => 3 ),
	array(
            'db' => 'VPARTNUM',
            'dt' => 4,
            'formatter' => function( $d ) {

                return '<a href="?module=Master/partDetail&partnum='.$d.'"><button class="btn btn-sm btn-info"><i class="fa fa-eye"></i></button></a>';
            }
        ),
);

require( 'scripts/ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
