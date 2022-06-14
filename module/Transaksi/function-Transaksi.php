<?php
checkSession();
//START GLOBAL FUNCTION
function checkSession(){
if(!isset($_SESSION['CABANG_CODENAME'])){ ?>
<script type="text/javascript">window.location="logout.php";</script>
<?php 

return false;
}else{

return true;
}
}

function cekClosing($CABANG){
require('config/dbRep.php');
$res=mysqli_query($con,"SELECT * FROM detail_report WHERE IDREPORT='".$CABANG.'-'.date('Ymd')."'");
if(mysqli_num_rows($res)>0){

return true;
}

return false;
}

function generateIDSOP(){
require('config/dbRep.php');

$hasil=mysqli_query($con,"SELECT MAX(IDTRANSPART) AS ID FROM trans_part WHERE CABANG='".$_SESSION['CABANG']."' AND TYPE='SOP'");
$user=mysqli_fetch_assoc($hasil);
$MaxID = $user['ID'];

$checkGen=strlen($_SESSION['CABANG'])+11;
$no_pinjam = (int) substr($MaxID,$checkGen,5);
$no_pinjam++;
$SOPID = $_SESSION['CABANG']."/SOP/".date('y/m/').sprintf("%05s",$no_pinjam);

return $SOPID;
}

function generateIDJOS(){
require('config/dbRep.php');

$user=mysqli_fetch_assoc(mysqli_query($con,"SELECT MAX(IDTRANSJASA) AS ID FROM trans_jasa WHERE CABANG='".$_SESSION['CABANG']."'"));
$MaxID = $user['ID'];

$checkGen=strlen($_SESSION['CABANG'])+11;
$no_jasa = (int) substr($MaxID,$checkGen,5);
$no_jasa++;
$JOSID = $_SESSION['CABANG']."/JOS/".date('y/m/').sprintf("%05s",$no_jasa);


return $JOSID;
}

function generateIDPKB(){
require('config/dbRep.php');

$lastID=getLastIDPKB();

$no="";
$indexYear=strlen($_SESSION['CABANG'])+5;
$yri =(int) substr($lastID,$indexYear,2);

$prefix=$_SESSION['CABANG']."/KWT/".date('y/m/');

$checkGen=strlen($_SESSION['CABANG'])+11;

$snum = (int) substr($lastID,$checkGen,5);

if ($yri!=date('y')) {
$sub=strlen($_SESSION['CABANG'])+8;

$result = mysqli_query($con, "SELECT IDPKB FROM pkb WHERE IDPKB='".substr($lastID,0,$sub)."01/00001' AND CABANG='".$_SESSION['CABANG']."'");
$ID=mysqli_fetch_assoc($result);

if ($ID['IDPKB']==$prefix."00001") {
$snum++;
$no = $prefix.sprintf("%05s",$snum);
}else{
$no = $prefix."00001";
}
} else {
$snum++;
$no = $prefix.sprintf("%05s",$snum);
}

return $no;
}

function generateIDPartMutasi(){
require('config/dbRep.php');

$hasil=mysqli_query($con,"SELECT MAX(IDMUTASIPART) AS ID FROM trans_mutasi WHERE TUJUAN='".$_SESSION['CABANG']."'");
$user=mysqli_fetch_assoc($hasil);
$MaxID = $user['ID'];

if ($row = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM trans_mutasi WHERE STATTRX='0' AND TUJUAN='".$_SESSION['CABANG']."'"))) {

$SOPID=$MaxID;
}else{
$checkGen=strlen($_SESSION['CABANG'])+11;
$no_pinjam = (int) substr($MaxID,$checkGen,5);

$no_pinjam++;
$SOPID = $_SESSION['CABANG']."/REC/".date('y/m/').sprintf("%05s",$no_pinjam);
}

return $SOPID;
}

function generateIDPartSO(){
require('config/dbRep.php');

$hasil=mysqli_query($con,"SELECT MAX(IDTRANSPART) AS ID FROM trans_part WHERE CABANG='".$_SESSION['CABANG']."' AND TYPE='SO'");
$user=mysqli_fetch_assoc($hasil);
$MaxID = $user['ID'];

$checkGen=strlen($_SESSION['CABANG'])+11;
$no_pinjam = (int) substr($MaxID,$checkGen,5);

$no_pinjam++;
$SOPID = $_SESSION['CABANG']."/SO/".date('y/m/').sprintf("%05s",$no_pinjam);


return $SOPID;
}

function cekPromo5x($nopol){
require('config/dbRep.php');
$frame=mysqli_fetch_assoc(mysqli_query($con,"SELECT FRAMENUM FROM nopol WHERE NOPOL='".$nopol."'"));

$count=0;
$listNopol='';

$cek=mysqli_query($con,"SELECT * FROM nopol WHERE FRAMENUM='".$frame['FRAMENUM']."'");
foreach ($cek as $key) {
$count++;
if($count!=1){
$listNopol.=",";
}
$listNopol.="'".$key['NOPOL']."'";
}

$queryCek="SELECT `JOBDESC` FROM `dtl_jasa` WHERE `NOPOL` IN ($listNopol) AND `JOBDESC` LIKE '%TUNE UP%' AND `VPAYMENT`='K'";
$cek1=mysqli_query($con,"SELECT `DATE`,`NOPOL`,`JOBDESC` FROM `dtl_jasa` WHERE `NOPOL` IN ($listNopol) AND `JOBDESC` LIKE '%5X%' ORDER BY `DATE` DESC LIMIT 1 ");
if(mysqli_num_rows($cek1)>0){
$last=mysqli_fetch_assoc($cek1);
$queryCek="SELECT `JOBDESC` FROM `dtl_jasa` WHERE `NOPOL` IN ($listNopol) AND `JOBDESC` LIKE '%TUNE UP%' AND `VPAYMENT`='K' AND `DATE` > '".$last['DATE']."'";
}
$data=mysqli_query($con,$queryCek);
$dt=mysqli_num_rows($data);


return $dt;
}

function validEngine($enginenum){
$valid=true;
$cekEngine=strlen($enginenum);
if($cekEngine!=12){
$valid=false;
}

return $valid;
}

function validFrame($framenum){
$valid=false;
$cekFrame=strlen($framenum);
if(strpos($framenum,'MH1')!==FALSE){
if($cekFrame==17){
$valid=true;
}
}

return $valid;
}

function displayTipeMotor(){
require('config/dbRep.php');
$aksi=mysqli_query($con,"SELECT * FROM mst_type GROUP BY VTYPEDESC1 ORDER BY VTYPEDESC1 ");

return $aksi;
}

function getInfoPart($partnum,$kode){
require('config/dbRep.php');
$cek = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `part` WHERE VPARTNUM='".$partnum."'"));

return $cek[$kode];
}

function getInfoJasa($idjob,$kode){
require('config/dbRep.php');
$cek = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `master_service` WHERE VIDJOBSERVICE='".$idjob."'"));

return $cek[$kode];
}

function PKBgetInfoMekanik($idEmp,$kode){
require('config/dbRep.php');
$mek=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM employee WHERE `IDEMP`='".$idEmp."'"));

return $mek[$kode];
}

function getTotalPart($IDTRANSPART){
require('config/dbRep.php');
$total=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(`TOTPAYPART`)AS `TOTAL` FROM `dtl_part_jual` WHERE `IDTRANSPART`='".$IDTRANSPART."' AND VPAYMENT='K'"));

return $total['TOTAL'];
}

function tambahStock($init,$partnum,$qty){
require('config/dbRep.php');
$curStock=getInfoPart($partnum,$init);
$tambah=mysqli_query($con,"UPDATE `part` SET `".$init."`='".($curStock+$qty)."' WHERE VPARTNUM='".$partnum."'");

return $tambah;
}

function kurangiStock($init,$partnum,$qty){
require('config/dbRep.php');
$curStock=getInfoPart($partnum,$init);
$kurangi=mysqli_query($con,"UPDATE `part` SET `".$init."`='".($curStock-$qty)."' WHERE VPARTNUM='".$partnum."'");

return $kurangi;
}

function getDtlPart($idtrans){
require('config/dbRep.php');
$aksi=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM dtl_part_jual WHERE `IDHIST`='".$idtrans."'"));

return $aksi;	
}

function deleteDtlPart($idtrans){
require('config/dbRep.php');
$aksi=mysqli_query($con,"DELETE FROM dtl_part_jual WHERE `IDHIST`='".$idtrans."'");

return $aksi;	
}

function pembulatan($nominal){
$nominal=round($nominal,-3);

return $nominal;
}

function getJasaKPB($seri){
require('config/dbRep.php');
$aksi=mysqli_query($con,"
select a.* FROM kpb_kategori a JOIN kpb_seri b ON a.ID=b.IDKATEGORI WHERE b.SERI='".$seri."'");


return $aksi;
}

function updDBUY($nopol,$datebuy){
require('config/dbRep.php');
$aksi=mysqli_query($con,"UPDATE `mstmotor` SET `DMCBUY`='".$datebuy."' WHERE `NOPOL`='".$nopol."'");

return $aksi;
}

//END GLOBAL FUNCTION



//START PAGE PKB.php

function PKBCommit($idpkb){
require('config/dbRep.php');
$pay=mysqli_query($con, "UPDATE pkb SET VIEW='0' WHERE IDPKB='".$idpkb."'");

return $pay;
}







//START PAGE Reprint.php
function getReprintNota(){
require('config/dbRep.php');
$aksi=mysqli_query($con,"SELECT * FROM pkb WHERE `PRINT`='1' AND `CABANG`='".$_SESSION['CABANG_CODENAME']."'");

return $aksi;
}

function getReprintSO(){
require('config/dbRep.php');
$sql="SELECT * FROM trans_part WHERE CABANG='".$_SESSION['CABANG']."' AND STATTRX='1' AND TYPE='SO' ORDER BY DCREA DESC";
if($_SESSION['CABANG']=='ADMIN'){
$sql="SELECT * FROM trans_part WHERE STATTRX='1' AND TYPE='SO' ORDER BY DCREA DESC";
}
$aksi=mysqli_query($con,$sql);

return $aksi;
}

function getSOToday(){
require('config/dbRep.php');
$sql="SELECT * FROM trans_part WHERE CABANG='".$_SESSION['CABANG']."' AND STATTRX='1' AND TYPE='SO' AND DATE(DCREA)=DATE(NOW())";
if($_SESSION['CABANG']=='ADMIN'){
$sql="SELECT * FROM trans_part WHERE STATTRX='1' AND TYPE='SO' AND DATE(DCREA)=DATE(NOW())";
}
$aksi=mysqli_query($con,$sql);

return $aksi;
}

//END PAGE Reprint.php


function getCABANG(){
require('config/dbRep.php');
$aksi=mysqli_query($con,"SELECT * FROM `CABANG`");

return $aksi;
}



//START PAGE SO.php 
function batalSO(){
require('config/dbRep.php');
$result=mysqli_fetch_assoc(checkSO());
$old=mysqli_query($con,"SELECT * FROM dtl_part_jual WHERE `IDTRANSPART`='".$result['IDTRANSPART']."'");
$kode=cekCABANG($_SESSION['CABANG'],"INIT");
foreach ($old as $old) {
tambahStock($kode,$old['PARTNUM'],$old['QTY']);
}
mysqli_query($con,"DELETE FROM `dtl_part_jual` WHERE IDTRANSPART='".$result['IDTRANSPART']."'");
$pay=mysqli_query($con, "DELETE FROM trans_part  WHERE IDTRANSPART='".$result['IDTRANSPART']."'");
echo basicSweetAlert('Nota Suku Cadang dengan ID '.$result['IDTRANSPART'].' Berhasil di batalkan.','Nota Suku Cadang dengan ID '.$result['IDTRANSPART'].' Gagal di Hapus.',$pay);
}

function SOgetAllPart($idtrans){
require('config/dbRep.php');
$part=mysqli_query($con,"SELECT * FROM dtl_part_jual WHERE IDTRANSPART='".$idtrans."'");

return $part;
}

function checkSO(){
require('config/dbRep.php');
$result=mysqli_query($con,"SELECT * FROM `trans_part` WHERE `STATTRX`='0' AND `CABANG`='".$_SESSION['CABANG']."' AND `TYPE`='SO'");

return $result;
}

function createSO($name,$alamat,$phone){
require('config/dbRep.php');
$SOPID=generateIDPartSO();

$ins = "INSERT INTO `customer`(`nama`,`alamat`,`phone`) VALUES ('".$name."','".$alamat."','".$phone."')";
$add=mysqli_query($con,$ins);

$res=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM customer WHERE nama='$name'"));

$idcust=$res['id'];

$ins = "INSERT INTO `trans_part`(`IDTRANSPART`,`TYPE`,`IDCUST`,`BUYERNAME`,`CABANG`,`CREABY`) VALUES ('".$SOPID."','SO','$idcust','".$name."','".$_SESSION['CABANG']."','".$_SESSION['NAME']."')";
$add=mysqli_query($con,$ins);

return $add;
}


function insertPartSO($partnum){
require('config/dbRep.php');
$result=mysqli_fetch_assoc(checkSO());
$SOPID="";
if($result['IDTRANSPART']==""){
$SOPID=generateIDPartSO();
$ins = "INSERT INTO `trans_part`(`IDTRANSPART`,`TYPE`,`BUYERNAME`,`CABANG`,`CREABY`) VALUES ('".$SOPID."','SO','".$result['BUYERNAME']."','".$_SESSION['CABANG']."','".$_SESSION['NAME']."')";
mysqli_query($con,$ins);
}else{
$SOPID=$result['IDTRANSPART'];
}

$kode=cekCABANG($_SESSION['CABANG'],"INIT");
mysqli_query($con,"UPDATE part SET `".$kode."`='".(getInfoPart($partnum,$kode)-1)."' WHERE `VPARTNUM`='".$partnum."'");


$sql = "INSERT INTO `dtl_part_jual`(`IDHIST`,`IDTRANSPART`,`CABANG`,`NOPOL`,`PARTNUM`,`PARTDESC`, `PRICE`, `QTY`, `TOTPAYPART`,`CREABY`) VALUES ('".$SOPID."-".$partnum."','".$SOPID."','".$_SESSION['CABANG']."','','".$partnum."','".getInfoPart($partnum,"VPARTDESC")."','".getInfoPart($partnum,"MHETPART")."','1','".getInfoPart($partnum,"MHETPART")."','".$_SESSION['NAME']."')";
$aksi = mysqli_query($con,$sql);

return $aksi;
}

function updPartSO($idHistPart,$discount,$qty,$totpay,$paymentPart){
require('config/dbRep.php');

$old=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM dtl_part_jual WHERE `IDHIST`='".$idHistPart."'"));

$kode=cekCABANG($_SESSION['CABANG'],"INIT");

tambahStock($kode,$old['PARTNUM'],$old['QTY']);
kurangiStock($kode,$old['PARTNUM'],$qty);

$updatePart=mysqli_query($con,"UPDATE `dtl_part_jual` SET `QTY`='".$qty."',`DISCOUNT`='".$discount."',`TOTPAYPART`='".$totpay."',`VPAYMENT`='".$paymentPart."' WHERE `IDHIST`='".$idHistPart."'");

return $updatePart;
}

function bayarSO($idtrans){
require('config/dbRep.php');
$tagihan=getTotalPart($idtrans);

$aksi=mysqli_query($con,"SELECT * FROM trans_part WHERE IDTRANSPART='$idtrans'");
$data=mysqli_fetch_assoc($aksi);


$aksi=mysqli_query($con,"UPDATE trans_part SET STATTRX='1',TOTPAY='".$tagihan."' WHERE IDTRANSPART='".$idtrans."'");

return $aksi;
}

//END PAGE SO.php

//START PAGE Pembelian.php
function bayarBUY($idtrans){
require('config/dbRep.php');

$tagihan=getGrandPartBeli($idtrans);
$aksi=mysqli_query($con,"UPDATE buy_part SET STATTRX='1',TOTPAY='".$tagihan."' WHERE IDBUYPART='".$idtrans."'");

return $aksi;
}

function batalBeli(){
require('config/dbRep.php');
$result=mysqli_fetch_assoc(checkBUY());
$old=getAllPartBUY($result['IDBUYPART']);

$kode=cekCABANG($_SESSION['CABANG'],"INIT");

foreach ($old as $old) {
kurangiStock($kode,$old['PARTNUM'],$old['QTY']);
}
mysqli_query($con,"DELETE FROM `dtl_part_beli` WHERE IDBUYPART='".$result['IDBUYPART']."'");
$pay=mysqli_query($con, "DELETE FROM buy_part  WHERE IDBUYPART='".$result['IDBUYPART']."'");
echo basicSweetAlert('Pembelian Sparepart dengan ID '.$result['IDBUYPART'].' Berhasil di batalkan.','Pembelian Sparepart dengan ID '.$result['IDBUYPART'].' Gagal di Batalkan.',$pay);
}

function getAllPartBUY($idtrans){
require('config/dbRep.php');
$part=mysqli_query($con,"SELECT * FROM dtl_part_beli WHERE IDBUYPART='".$idtrans."'");

return $part;
}

function checkBUY(){
require('config/dbRep.php');
$result=mysqli_query($con,"SELECT * FROM `buy_part` WHERE `STATTRX`='0' AND `CABANG`='".$_SESSION['CABANG']."'");

return $result;
}

function createBUY($faktur,$name){
require('config/dbRep.php');
$SOPID=generateIDPartBUY();
$ins = "INSERT INTO `buy_part`(`IDBUYPART`,`FAKTUR`,`SUPPLIER`,`CABANG`,`CREABY`) VALUES ('".$SOPID."','".$faktur."','".$name."','".$_SESSION['CABANG']."','".$_SESSION['NAME']."')";
$add=mysqli_query($con,$ins);

return $add;
}

function insertPartBUY($partnum){
require('config/dbRep.php');
$result=mysqli_fetch_assoc(checkBUY());

$BUYID=$result['IDBUYPART'];
$kode=cekCABANG($_SESSION['CABANG'],"INIT");

tambahStock($kode,$partnum,1);

$sql = "INSERT INTO `dtl_part_beli`(`IDBUYPART`,`CABANG`,`PARTNUM`,`PARTDESC`, `QTY`, `HARGA`,`CREABY`) VALUES ('".$BUYID."','".$_SESSION['CABANG']."','".$partnum."','".getInfoPart($partnum,"VPARTDESC")."','1','".getInfoPart($partnum,"MHETPART")."','".$_SESSION['NAME']."')";
$aksi = mysqli_query($con,$sql);

return $aksi;
}

function generateIDPartBUY(){
require('config/dbRep.php');

$hasil=mysqli_query($con,"SELECT MAX(IDBUYPART) AS ID FROM buy_part WHERE CABANG='".$_SESSION['CABANG']."'");
$user=mysqli_fetch_assoc($hasil);
$MaxID = $user['ID'];

if ($row = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM buy_part WHERE STATTRX='0' AND CABANG='".$_SESSION['CABANG']."'"))) {

$SOPID=$MaxID;
}else{
$checkGen=16;
if(strlen($_SESSION['CABANG'])!=5){
	$checkGen=17;
}
$no_pinjam = (int) substr($MaxID,$checkGen,5);
$no_pinjam++;
$SOPID = $_SESSION['CABANG']."/BUY/".date('y')."/".date('m')."/".sprintf("%05s",$no_pinjam);
}

return $SOPID;
}

function displayPart($idtrans){
require('config/dbRep.php');
$part=mysqli_query($con,"SELECT * FROM dtl_part_jual WHERE IDTRANSPART='".$idtrans."' ORDER BY VPAYMENT DESC");

return $part;
}

function updPartBeli($id,$qty){
require('config/dbRep.php');

$old=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM dtl_part_beli WHERE `ID`='".$id."'"));

$kode=cekCABANG($_SESSION['CABANG'],"INIT");

kurangiStock($kode,$old['PARTNUM'],$old['QTY']);
tambahStock($kode,$old['PARTNUM'],$qty);

$updatePart=mysqli_query($con,"UPDATE `dtl_part_beli` SET `QTY`='".$qty."' WHERE `ID`='".$id."'");

return $updatePart;
}

function getGrandPartBeli($IDBUYPART){
require('config/dbRep.php');
$total=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(`HARGA`)AS `TOTAL` FROM `dtl_part_beli` WHERE `IDBUYPART`='".$IDBUYPART."'"));

return $total['TOTAL'];
}

function getDtlPartBUY($id){
require('config/dbRep.php');
$aksi=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM dtl_part_beli WHERE `ID`='".$id."'"));

return $aksi;	
}

function deleteDtlPartBUY($id){
require('config/dbRep.php');
$aksi=mysqli_query($con,"DELETE FROM dtl_part_beli WHERE `ID`='".$id."'");

return $aksi;	
}


//END PAGE Pembelian.php


?>