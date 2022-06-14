<?php
require_once('db.php');

$table = "(SELECT * FROM part WHERE `SHOW`='1') a";
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
    array(
        'db' => 'VPARTNUM',
        'dt' => 3,
        'formatter' => function( $d ) {
            return '<form action="" method="post">
            <input type="hidden" name="partnum" value="'.$d.'">
            <button class="btn btn-primary" type="submit" name="addPart"><i class="ni ni-send"></i> Pilih</button>
            </form>';
        }
    ),
    array( 'db' => 'QTYSYN',  'dt' => 4 )
);

require( 'scripts/ssp.class.php' );

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

