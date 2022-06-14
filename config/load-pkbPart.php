<?php
$init=$_GET['init'];
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
        'formatter' => function( $d,$row ) {
            if($row[4]>0){
                return '<form action="" method="post">
                <input type="hidden" name="partnum" value="'.$d.'">
                <button class="btn btn-sm btn-primary" type="submit" name="addPart"><i class="ni ni-send"></i> Pilih</button>
                </form>';
            }else{
                return 'Stok Kosong';
            }
            
        }
    ),
    array( 'db' => $init,  'dt' => 4 ),

);

$ind=4;
$data=mysqli_query($con,"SELECT INIT FROM CABANG WHERE INIT!='$init' AND isActive='1' ORDER BY CABANG");
foreach ($data as $CABANG) {
    $ind++;
    $columns[]=[ 'db' => $CABANG['INIT'],  'dt' => $ind];
}


require( 'scripts/ssp.class.php' );

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

