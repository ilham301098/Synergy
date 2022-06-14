<?php
require('fpdf.php');

class PDF extends FPDF {
// Page header
	function Header(){
		$this->SetFont('Arial','',11);
		$this->Cell(275,4,'CABANG '.$_POST['noCABANG'],0,1);
		$this->Cell(255,4,strtoupper($_POST['namaCABANG']),0,0);
		$this->SetFont('Arial','',10);
		$this->Cell(20,4,'Hal. '.$this->PageNo().' / {nb}',0,1);
		$this->SetFont('Arial','',9);
		$this->Cell(275,4,$_POST['addrCABANG'],0,1);
		$this->Cell(275,4,'Telp : '.$_POST['phoneCABANG'],0,1);

		$this->SetFont('Helvetica','B',15);
		$this->Cell(275,7,'Laporan Pendapatan Harian',0,1,'C');

		$this->Ln(2);

		$this->SetFont('Arial','B',11);
		$this->Cell(275,5,date('l, d F Y (H:i)', strtotime($_POST['HarSt'])),0,1,'C');

		$this->Ln(2);
	}

// Page footer
	function Footer(){
		require ('dbRep.php');
    // Position at 1.5 cm from bottom
		$this->SetY(-20);
		$this->SetFont('Arial','',10);
		$this->Cell(275,7,'Di cetak pada '.date('l, d F Y - H:i:s').', Apabila terdapat selisih pada laporan di atas, harap menambahkan catatan pada Laporan Penunjang.',1,1,'C');
	}
}

// memanggil library FPDF

// intance object dan memberikan pengaturan halaman PDF

require ('dbRep.php');

$pdf = new PDF('L','mm','A4');

// membuat halaman baru
$pdf->AliasNbPages();
$pdf->SetMargins(10,6,7);
$pdf->AddPage();


// setting jenis font yang akan digunakan



$pdf->SetFont('Helvetica','B',9);

$pdf->Cell(275,5,'Service',0,1);

$pdf->Cell(130,12,'',1,0,'C');
$pdf->Cell(126,6,'Pembayaran',1,0,'C');
$pdf->Cell(21,18,'Total',1,0,'C');
$pdf->Cell(0,6,'',0,1,'C');

$pdf->Cell(130,6,'',0,0,'C');
$pdf->Cell(63,6,'Konsumen',1,0,'C');
$pdf->Cell(63,6,'Main Dealer',1,0,'C');
$pdf->Cell(21,6,'',0,1,'C');

$pdf->Cell(10,6,'No',1,0,'C');
$pdf->Cell(40,6,'No. KWT',1,0,'C');
$pdf->Cell(10,6,'Type',1,0,'C');
$pdf->Cell(25,6,'No.Polisi',1,0,'C');
$pdf->Cell(15,6,'Waktu',1,0,'C');
$pdf->Cell(30,6,'Mekanik',1,0,'C');

$pdf->Cell(21,6,'Jasa (A)',1,0,'C');
$pdf->Cell(21,6,'Part (B)',1,0,'C');
$pdf->Cell(21,6,'Diskon',1,0,'C');
$pdf->Cell(21,6,'Jasa (C)',1,0,'C');
$pdf->Cell(21,6,'Part (D)',1,0,'C');
$pdf->Cell(21,6,'Diskon',1,0,'C');
$pdf->Cell(21,6,'',0,1,'C');

//// ISI ////
$pdf->SetFont('Helvetica','',8);
$ALLtjasa=0;
$ALLtjasamd=0;
$ALLtpart=0;
$ALLtpartmd=0;
$ALLdis=0;
$ALLdismd=0;

$ALLtotal=0;

$no=0;
$unit=mysqli_query($con,"SELECT * FROM pkb WHERE CABANG='".$_POST['noCABANG']."' AND STATTRX<3");
foreach ($unit as $key) {

	$statusPKB="";
	if($key['STATTRX']=='0'){
		$statusPKB="Antrian";
	}else if($key['STATTRX']=='1'){
		$statusPKB="Start";
	}else if($key['STATTRX']=='2'){
		$statusPKB="Pause";
	}
	

	$pdf->Cell(10,4,'',1,0,'C');
	$pdf->Cell(40,4,$key['IDPKB'],1,0,'C');
	$pdf->Cell(10,4,$statusPKB,1,0,'C');
	$pdf->Cell(25,4,$key['NOPOL'],1,0,'C');
	$pdf->Cell(15,4,'0',1,0,'C');

	$mk=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM employee WHERE IDEMP='".$key['MEKANIK']."'"));
	$pdf->Cell(30,4,substr($mk['NAMA'],0,12),1,0,'C');


	$pdf->Cell(126,4,'Tanggal Masuk : '.$key['DCREA'],1,0,'C');


	$pdf->Cell(21,4,'0',1,1,'R');
}


$isi=mysqli_query($con,"SELECT * FROM pkb WHERE CABANG='".$_POST['noCABANG']."' AND DATE(`TFINISH`)='".$_POST['HarSt']."'");
foreach ($isi as $key) { 
	$no++;

	$tjasa=0;
	$tjasamd=0;
	$tpart=0;
	$tpartmd=0;
	$dis=0;
	$dismd=0;

	$total=0;

	$js=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(PRICE) AS TOTJS FROM dtl_jasa WHERE IDTRANSJASA='".$key['IDTRANSJASA']."' AND VPAYMENT='K'"));
	$jskpb=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(PRICE) AS TOTKPBJS FROM dtl_jasa WHERE IDTRANSJASA='".$key['IDTRANSJASA']."' AND VPAYMENT='M'"));
	
	$pt=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(PRICE*QTY) AS TOTPT FROM dtl_part_jual WHERE IDTRANSPART='".$key['IDTRANSPART']."' AND VPAYMENT='K'"));
	$ptkpb=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(PRICE*QTY) AS TOTKPBPT FROM dtl_part_jual WHERE IDTRANSPART='".$key['IDTRANSPART']."' AND VPAYMENT='M'"));

	$disjs=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(DISCOUNT) AS DISJS FROM dtl_jasa WHERE IDTRANSJASA='".$key['IDTRANSJASA']."' AND VPAYMENT='K'"));
	$dispt=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(DISCOUNT) AS DISPT FROM dtl_part_jual WHERE IDTRANSPART='".$key['IDTRANSPART']."' AND VPAYMENT='K'"));

	$dis=$disjs['DISJS']+$dispt['DISPT'];
	$dismd=0;

	date_default_timezone_set('Asia/Jakarta');

	$awal  = strtotime($key['DCREA']);
	$akhir = strtotime($key['TFINISH']);
	$diff  = $akhir - $awal;

	$menit   = floor($diff / 60 );



	$pdf->Cell(10,4,$no.'.',1,0,'C');
	$pdf->Cell(40,4,$key['IDPKB'],1,0,'C');
	$pdf->Cell(10,4,'S',1,0,'C');
	$pdf->Cell(25,4,$key['NOPOL'],1,0,'C');
	$pdf->Cell(15,4,$menit,1,0,'C');

	$mk=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM employee WHERE IDEMP='".$key['MEKANIK']."'"));
	$pdf->Cell(30,4,substr($mk['NAMA'],0,12),1,0,'C');


	$pdf->Cell(21,4,number_format($js['TOTJS']),1,0,'R');
	$pdf->Cell(21,4,number_format($pt['TOTPT']),1,0,'R');
	$pdf->Cell(21,4,number_format($dis),1,0,'R');


	$pdf->Cell(21,4,number_format($jskpb['TOTKPBJS']),1,0,'R');
	$pdf->Cell(21,4,number_format($ptkpb['TOTKPBPT']),1,0,'R');
	$pdf->Cell(21,4,number_format($dismd),1,0,'R');

	$total=($js['TOTJS']+$pt['TOTPT']-$dis)+($jskpb['TOTKPBJS']+$ptkpb['TOTKPBPT']-$dismd);

	$pdf->Cell(21,4,number_format($total),1,1,'R');

	$ALLtjasa+=$js['TOTJS'];
	$ALLtjasamd+=$jskpb['TOTKPBJS'];
	$ALLtpart+=$pt['TOTPT'];
	$ALLtpartmd+=$ptkpb['TOTKPBPT'];
	$ALLdis+=$dis;
	$ALLdismd+=$dismd;

	$ALLtotal+=$total;
}

//// ---- ////
$pdf->SetFont('Helvetica','B',9);

$pdf->Cell(130,6,'Grand Total :',1,0,'C');
$pdf->Cell(21,6,number_format($ALLtjasa),1,0,'R');
$pdf->Cell(21,6,number_format($ALLtpart),1,0,'R');
$pdf->Cell(21,6,number_format($ALLdis),1,0,'R');
$pdf->Cell(21,6,number_format($ALLtjasamd),1,0,'R');
$pdf->Cell(21,6,number_format($ALLtpartmd),1,0,'R');
$pdf->Cell(21,6,number_format($ALLdismd),1,0,'R');
$pdf->Cell(21,6,number_format($ALLtotal),1,1,'R');

$totalKon=$ALLtjasa+$ALLtpart-$ALLdis;
$totalMD=$ALLtjasamd+$ALLtpartmd-$ALLdismd;

$pdf->Cell(130,6,'Total Pendapatan  Jasa & Part :',1,0,'C');
$pdf->Cell(63,6,number_format($totalKon),1,0,'R');
$pdf->Cell(63,6,number_format($totalMD),1,0,'R');
$pdf->Cell(21,6,number_format($totalKon+$totalMD),1,1,'R');

$pdf->Ln(2);
$pdf->Cell(275,5,'NSC',0,1);

$pdf->Cell(10,6,'No',1,0,'C');
$pdf->Cell(45,6,'No. NSC',1,0,'C');
$pdf->Cell(35,6,'Nomor Part',1,0,'C');
$pdf->Cell(61,6,'Deskripsi Part',1,0,'C');
$pdf->Cell(21,6,'Harga',1,0,'C');
$pdf->Cell(21,6,'Qty',1,0,'C');
$pdf->Cell(21,6,'Discount',1,0,'C');
$pdf->Cell(23,6,'Sub Total',1,0,'C');
$pdf->Cell(40,6,'Keterangan',1,1,'C');


$pdf->SetFont('Helvetica','',8);

$no=0;
$sumNSC=0;
$sumQty=0;

$isi=mysqli_query($con,"SELECT * FROM dtl_part_jual WHERE CABANG='".$_POST['noCABANG']."' AND DATE(`DATE`)='".$_POST['HarSt']."' AND VPAYMENT='K' AND IDTRANSPART LIKE '".$_POST['noCABANG']."/NSC/%'");

foreach ($isi as $key) { 
	$no++;
	$sumQty=$sumQty+$key['QTY'];
	$sumNSC=$sumNSC+$key['TOTPAYPART'];
	$pdf->Cell(10,4,$no,1,0,'C');
	$pdf->Cell(45,4,$key['IDTRANSPART'],1,0,'C');
	$pdf->Cell(35,4,$key['PARTNUM'],1,0,'C');
	$pdf->Cell(61,4,$key['PARTDESC'],1,0,'C');
	$pdf->Cell(21,4,number_format($key['PRICE']),1,0,'C');
	$pdf->Cell(21,4,$key['QTY'],1,0,'C');
	$pdf->Cell(21,4,$key['DISCOUNT'],1,0,'C');
	$pdf->Cell(23,4,number_format($key['TOTPAYPART']),1,0,'C');
	$pdf->Cell(40,4,'',1,1,'C');
}

$pdf->SetFont('Helvetica','B',9);

$pdf->Cell(172,6,'Grand Total :',1,0,'C');
$pdf->Cell(21,6,$sumQty,1,0,'C');
$pdf->Cell(21,6,'',1,0,'C');
$pdf->Cell(23,6,number_format($sumNSC),1,0,'R');
$pdf->Cell(40,6,'',1,1,'R');


$pdf->Ln(2);

$pdf->Cell(275,5,'Pembatalan ('.date('l, d F Y', strtotime($_POST['HarSt'])).')',0,1);

$pdf->Cell(10,6,'No',1,0,'C');
$pdf->Cell(20,6,'Tipe',1,0,'C');
$pdf->Cell(35,6,'ID. Transaksi',1,0,'C');
$pdf->Cell(210,6,'Keterangan',1,1,'');

$pdf->SetFont('Helvetica','',8);

$no=0;
$btl=mysqli_query($con,"SELECT * FROM pembatalan WHERE CREABY='".$_POST['noCABANG']."' AND DATE(`DCREA`)='".$_POST['HarSt']."'");

foreach ($btl as $btl) { 
	$no++;
	$pdf->Cell(10,5,$no,1,0,'C');
	$pdf->Cell(20,5,$btl['TRANSAKSI'],1,0,'C');
	$pdf->Cell(35,5,$btl['IDTRANSAKSI'],1,0,'C');
	$pdf->Cell(210,5,$btl['KETERANGAN'],1,1,'');
}




$name="LaporanHarian-".$_POST['HarSt'].".pdf";

$pdf->Output($name,'D');

?>
