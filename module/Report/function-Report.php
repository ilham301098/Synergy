<?php

function getCABANG(){
	require('config/dbRep.php');
	$aksi=mysqli_query($con,"SELECT * FROM `CABANG` ");
	return $aksi;
}

function getPoinJasaBulanan($idemp,$date,$dateFns){
	require("config/dbRep.php");
	$poin=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(a.`PRICE`-a.`PRICEBUY`) AS POIN FROM `dtl_jasa` a, `pkb` b WHERE a.`IDTRANSJASA`=b.`IDTRANSJASA` AND b.`MEKANIK`='".$idemp."' AND DATE(b.`TFINISH`) BETWEEN '".$date."' AND '".$dateFns."' GROUP BY b.MEKANIK"));
	return $poin['POIN'] ?? 0;
}

function getPoinPartBulanan($idemp,$date,$dateFns){
	require("config/dbRep.php");
	$poin=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(a.`PRICE`*a.`QTY`) AS POIN FROM `dtl_part_jual` a, `pkb` b  WHERE a.`IDTRANSPART`=b.`IDTRANSPART` AND b.`MEKANIK`='".$idemp."' AND DATE(b.`TFINISH`) BETWEEN '".$date."' AND '".$dateFns."' GROUP BY b.MEKANIK"));
	return $poin['POIN'] ?? 0;
}

function getPoinJasa($idemp,$date){
	require("config/dbRep.php");
	$poin=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(a.`PRICE`-a.`PRICEBUY`) AS POIN FROM `dtl_jasa` a, `pkb` b WHERE a.`IDTRANSJASA`=b.`IDTRANSJASA` AND b.`MEKANIK`='".$idemp."' AND DATE(b.`TFINISH`)='".$date."' GROUP BY b.MEKANIK"));
	return $poin['POIN'] ?? 0;
}

function getPoinPart($idemp,$date){
	require("config/dbRep.php");
	$poin=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(a.`PRICE`*a.`QTY`) AS POIN FROM `dtl_part_jual` a, `pkb` b  WHERE a.`IDTRANSPART`=b.`IDTRANSPART` AND b.`MEKANIK`='".$idemp."' AND DATE(b.`TFINISH`)='".$date."' GROUP BY b.MEKANIK"));
	return $poin['POIN'] ?? 0;
}




function getDtlRepMasuk($CABANG,$dt){
	require('config/dbRep.php');
	$res=mysqli_query($con,"SELECT * FROM daily_detail WHERE TIPE='MASUK' AND CABANG='$CABANG' AND DATE(DCREA)='$dt' ORDER BY PRIORITY,JENIS");
	return $res;
}

function getDtlRepKeluar($CABANG,$dt){
	require('config/dbRep.php');
	$res=mysqli_query($con,"SELECT * FROM daily_detail WHERE TIPE='KELUAR' AND CABANG='$CABANG' AND DATE(DCREA)='$dt' ORDER BY PRIORITY,JENIS");
	return $res;
}



function getPendapatanJasa($CABANG,$date){
	require("config/dbRep.php");
	$poin=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(a.`PRICE`-a.`PRICEBUY`) AS POIN FROM `dtl_jasa` a, `pkb` b WHERE a.`IDTRANSJASA`=b.`IDTRANSJASA` AND CABANG='$CABANG' AND DATE(b.`TFINISH`)='$date' GROUP BY a.CABANG"));
	return $poin['POIN'] ?? 0;
}

function getPendapatanPart($CABANG,$date){
	require("config/dbRep.php");
	$poin=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(a.`PRICE`*a.`QTY`) AS POIN FROM `dtl_part_jual` a, `pkb` b  WHERE a.`IDTRANSPART`=b.`IDTRANSPART` AND CABANG='$CABANG' AND DATE(b.`TFINISH`)='$date' GROUP BY a.CABANG"));
	return $poin['POIN'] ?? 0;
}

function getTotalPendapatan($CABANG,$date){
	return getPendapatanJasa($CABANG,$date)+getPendapatanPart($CABANG,$date);
}

function getTotalNSC($CABANG,$date){
	require("config/dbRep.php");
	$total_part=0;

	$pt=mysqli_query($con,"SELECT SUM(TOTPAYPART) AS POIN FROM `dtl_part_jual` WHERE `IDTRANSPART` LIKE '%/NSC/%' AND CABANG='$CABANG' AND DATE(`DATE`)='$date' GROUP BY CABANG");
	if(mysqli_num_rows($pt)>0){
		$poin=mysqli_fetch_assoc($pt);
		$total_part=$poin['POIN'];
	}
	return $total_part;
}

function getTotalPendapatanBersih($CABANG,$date){
	//tanpa Main Dealer & Claim & NSC 
	require("config/dbRep.php");
	$total_jasa=$total_part=0;

	$js=mysqli_query($con,"SELECT SUM(TOTPAYJASA) AS POIN FROM `dtl_jasa` a, `pkb` b WHERE a.`IDTRANSJASA`=b.`IDTRANSJASA` AND VPAYMENT='K' AND a.CABANG='$CABANG' AND DATE(b.`TFINISH`)='$date' GROUP BY a.CABANG");
	if(mysqli_num_rows($js)>0){
		$jasa=mysqli_fetch_assoc($js);
		$total_jasa=$jasa['POIN'];
	}

	$pt=mysqli_query($con,"SELECT SUM(TOTPAYPART) AS POIN FROM `dtl_part_jual` a, `pkb` b  WHERE a.`IDTRANSPART`=b.`IDTRANSPART` AND VPAYMENT='K' AND a.`IDTRANSPART` LIKE '%/SOP/%' AND a.CABANG='$CABANG' AND DATE(b.`TFINISH`)='$date' GROUP BY a.CABANG");
	if(mysqli_num_rows($pt)>0){
		$part=mysqli_fetch_assoc($pt);
		$total_part=$part['POIN'];
	}
	
	return $total_jasa+$total_part;
}



function getRepMasuk($CABANG,$dt){
	require('config/dbRep.php');
	$total=0;
	$res=mysqli_query($con,"SELECT * FROM daily_detail WHERE TIPE='MASUK' AND CABANG='$CABANG' AND DATE(DCREA)='$dt'");
	foreach ($res as $res) {
		$total=$total+$res['NOMINAL'];
	}
	return $total;
}

function getRepKeluar($CABANG,$dt){
	require('config/dbRep.php');
	$total=0;
	$res=mysqli_query($con,"SELECT * FROM daily_detail WHERE TIPE='KELUAR' AND CABANG='$CABANG' AND DATE(DCREA)='$dt'");
	foreach ($res as $res) {
		$total=$total+$res['NOMINAL'];
	}
	return $total;
}

function insertPemasukan($CABANG,$detail,$nominal){
	require('config/dbRep.php');
	$aksi=mysqli_query($con,"INSERT INTO `daily_detail` (`CABANG`, `JENIS`, `NOMINAL`, `TIPE`,`PRIORITY`) VALUES ('".$CABANG."','".strtoupper($detail)."','".$nominal."','MASUK','99')");

	return $aksi;
}

function insertPengeluaran($CABANG,$detail,$nominal){
	require('config/dbRep.php');
	$aksi=mysqli_query($con,"INSERT INTO `daily_detail` (`CABANG`, `JENIS`, `NOMINAL`, `TIPE`,`PRIORITY`) VALUES ('".$CABANG."','".strtoupper($detail)."','".$nominal."','KELUAR','99')");

	return $aksi;
}

function deleteDtlReport($ID){
	require('config/dbRep.php');
	$aksi=mysqli_query($con,"DELETE FROM daily_detail WHERE ID='".$ID."'");

	return $aksi;
}

function insertClosing($CABANG,$KETERANGAN,$TOTAL_CURRENT,$PLAN_MODAL,$FDNAME){
	require('config/dbRep.php');

	$total_pendapatan=getTotalPendapatanBersih($CABANG,date('Y-m-d'));
	$total_nsc=getTotalNSC($CABANG,date('Y-m-d'));

	$daily=mysqli_query($con,"INSERT INTO `daily_detail` (`CABANG`, `JENIS`, `NOMINAL`, `TIPE`,`PRIORITY`) VALUES ('".$CABANG."','PENDAPATAN ','".$total_pendapatan."','MASUK','2')");

	$nsc=mysqli_query($con,"INSERT INTO `daily_detail` (`CABANG`, `JENIS`, `NOMINAL`, `TIPE`,`PRIORITY`) VALUES ('".$CABANG."','NSC','".$total_nsc."','MASUK','3')");

	$modal_besok=mysqli_query($con,"INSERT INTO `daily_detail` (`CABANG`, `JENIS`, `NOMINAL`, `TIPE`,`PRIORITY`) VALUES ('".$CABANG."','MODAL BESOK','".$PLAN_MODAL."','KELUAR','1')");

	$pemasukan=getRepMasuk($CABANG,date('Y-m-d'));
	$pengeluaran=getRepKeluar($CABANG,date('Y-m-d'));

	$TOTAL_SYSTEM=$pemasukan-$pengeluaran;
	$SELISIH_ACTUAL=$TOTAL_SYSTEM-$TOTAL_CURRENT;

	$IDREPORT=$CABANG.'-'.date('Ymd');
	// $aksi=mysqli_query($con,"INSERT INTO `detail_report` (`IDREPORT`,`CABANG`, `KETERANGAN`, `TOTAL_CURRENT`,`TOTAL_SYSTEM`,`SELISIH_ACTUAL`,`PLAN_SETOR`,`PLAN_MODAL`,`FDNAME`) VALUES ('$IDREPORT','$CABANG','$KETERANGAN','$TOTAL_CURRENT','$TOTAL_SYSTEM','$SELISIH_ACTUAL','$PLAN_SETOR','$PLAN_MODAL','$FDNAME')");
	$aksi=mysqli_query($con,"INSERT INTO `detail_report` (`IDREPORT`,`CABANG`, `KETERANGAN`, `TOTAL_CURRENT`,`TOTAL_SYSTEM`,`SELISIH_ACTUAL`,`PLAN_MODAL`,`FDNAME`) VALUES ('$IDREPORT','$CABANG','$KETERANGAN','$TOTAL_CURRENT','$TOTAL_SYSTEM','$SELISIH_ACTUAL','$PLAN_MODAL','$FDNAME')");

	sendNotifClosing($IDREPORT);

	return $aksi;
}

function cekClosing($CABANG){
	require('config/dbRep.php');
	$res=mysqli_query($con,"SELECT * FROM detail_report WHERE IDREPORT='".$CABANG.'-'.date('Ymd')."'");
	if(mysqli_num_rows($res)>0){
		return true;
	}
	return false;
}

function getDataClosing($CABANG){
	require('config/dbRep.php');
	$res=mysqli_query($con,"SELECT * FROM detail_report WHERE IDREPORT='".$CABANG.'-'.date('Ymd')."'");

	return mysqli_fetch_assoc($res);
}

function sendNotifClosing($idReport){
	require('config/dbRep.php');
	$res=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM detail_report WHERE IDREPORT='".$idReport."'"));
	$cek=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM CABANG WHERE CABANG='".$res['CABANG']."'"));

	$pesan='[ LAPORAN HARIAN '.$res['CABANG'].' ]'."\n\n";

	$pesan.="CABANG ".$res['CABANG']."\n";
	$pesan.=strtoupper($cek['NAMA'])."\n\n";

	//$pesan.="Setor Tunai : ".number_format($res['PLAN_SETOR'])."\n";

	$pesan.='Hasil FrontDesk : '.number_format($res['TOTAL_CURRENT'])."\n";
	$pesan.='Hasil Sistem    : '.number_format($res['TOTAL_SYSTEM'])."\n\n";

	$pesan.="Selisih Laporan : ".number_format($res['SELISIH_ACTUAL'])."\n\n";	

	$pesan.="FrontDesk :".$res['FDNAME']."\n\n";

	if(!isset($res['KETERANGAN'])){
		$pesan.="Keterangan :\n".$res['KETERANGAN']."\n";
	}

	$pesan.=":::::::::::::::::::::::::::::::::::::::::::::::::::::\n\n";

	$pesan.="..::-- Pemasukan --::..\n";
	$listMasuk=getDtlRepMasuk($res['CABANG'],date('Y-m-d'));
	foreach ($listMasuk as $list) {
		$pesan.=$list['JENIS'].' : '.number_format($list['NOMINAL'])."\n";
	}
	$pesan.='Total Pemasukan : '.number_format(getRepMasuk($res['CABANG'],date('Y-m-d')))."\n\n";


	$pesan.="..::-- Pengeluaran --::..\n";
	$listMasuk=getDtlRepKeluar($res['CABANG'],date('Y-m-d'));
	foreach ($listMasuk as $list) {
		$pesan.=$list['JENIS'].' : '.number_format($list['NOMINAL'])."\n";
	}
	$pesan.='Total Pengeluaran : '.number_format(getRepKeluar($res['CABANG'],date('Y-m-d')))."\n\n";


	$pesan.="Laporan ini dibuat pada : \n".date('l, d F Y')."\n\n";
	$pesan.="Terima Kasih\n";
	$pesan.="- POS Synergy Bot -\n";

	sendMessage($pesan);

	return true;
}


?>