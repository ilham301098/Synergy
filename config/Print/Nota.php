<?php
// $path='../../components/phpqrcode/';
// $b = scandir($path,1);

// var_dump($b);

require('../dbRep.php');
require('../fpdf.php');
require('../../components/phpqrcode/qrlib.php');
$idpkb=$_POST['idKWT'];
$id=str_replace('/','',$_POST['idKWT']);
QRcode::png("https://CABANGmitrakarya.com/qrprint.php?id=$idpkb",'../../Images/QR/'.$id.'.png','C',4,4);

$cek=mysqli_query($con,"UPDATE `pkb` SET `PRINT`='1' WHERE `IDPKB`='".$_POST['idKWT']."'");


class PDF extends FPDF {
// Page header
	function Header(){
		if(!empty($this->enableheader)){
			call_user_func($this->enableheader,$this);
		}
		
	}

// Page footer
	function Footer(){
		include ('../dbRep.php');

		$kode="SETIAJ";
		if($_POST['noCABANG']=='14095'){
			$kode="SIWALA";
		}else if($_POST['noCABANG']=='08332'){
			$kode="MITRAK";
		}

		$content = mysqli_query($con, "SELECT * FROM pkb WHERE IDPKB='".$_POST['idKWT']."'");
		$dt = mysqli_fetch_assoc($content);
    // Position at 1.5 cm from bottom
		$this->SetY(-25);

		$this->Image('../../Images/QR/'.str_replace('/','',$_POST['idKWT']).'.png',10,125,20,20);
		$this->SetFont('Arial','',10);

		$this->Cell(20,5,'',0,0);
		$this->Cell(170,5,'Garansi service maks 500 Km / 1 Minggu (yang tercapai lebih dahulu) dengan menunjukkan Nota ini.',0,1,'C');
		$this->Cell(20,5,'',0,0);
		$this->Cell(170,5,'Unduh Aplikasi BromPit pada Play Store sekarang dan gunakan Kode Referal '.$kode.'.',0,1,'C');
		$this->Cell(20,5,'',0,0);
		$this->Cell(170,7,$dt['NOPOL'].' - '.date('d F Y').' - '.$dt['IDPKB'].' - KILOMETER: '.number_format($dt['KILOMETER']),1,1,'C');
	}
}

// memanggil library FPDF

// intance object dan memberikan pengaturan halaman PDF

include ('../dbRep.php');

$pdf = new PDF('L','mm',array(148,210));

// membuat halaman baru
$pdf->AliasNbPages();
$pdf->SetMargins(10,6,7);

$pdf->enableheader = 'headerNota';
$pdf->AddPage();


// setting jenis font yang akan digunakan

$pdf->Ln(3);

$pdf->SetFont('Arial','',10);
$content = mysqli_query($con, "SELECT * FROM pkb WHERE IDPKB='".$_POST['idKWT']."'");
$dt = mysqli_fetch_assoc($content);
$pdf->Cell(23,4,'No. Kwitansi',0,0);
$pdf->Cell(60,4,': '.$dt['IDPKB'],0,0);
$pdf->Cell(17,4,'No.Polisi',0,0);
$pdf->Cell(90,4,': '.$dt['NOPOL'],0,1);

$pdf->Cell(23,4,'Tgl. Nota',0,0);
$pdf->Cell(60,4,': '.date_format(date_create($dt['DCREA']),"d F Y H:i:s"),0,0);
$pdf->Cell(17,4,'Nama',0,0);
$nama=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM mstmotor WHERE NOPOL='".$dt['NOPOL']."'"));
$pdf->Cell(87,4,': '.$nama['NAME'],0,1);

$pdf->Cell(23,4,'No. Hp',0,0);
$pdf->Cell(60,4,': '.$nama['PHONE'],0,0);
$pdf->Cell(17,4,'Alamat',0,0);
$pdf->MultiCell(87,4,': '.$nama['ALAMAT'],0,1);



// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Ln(2);

$pdf->SetFont('Arial','',10);

$pdf->Cell(33,5,'Item',1,0,'C');
$pdf->Cell(78,5,'Nama',1,0,'C');
$pdf->Cell(20,5,'Harga',1,0,'C');
$pdf->Cell(10,5,'Qty',1,0,'C');
$pdf->Cell(22,5,'Diskon',1,0,'C');
$pdf->Cell(27,5,'Jumlah',1,1,'C');

$totalPart=0;
$part = mysqli_query($con, "SELECT * FROM `dtl_part_jual` WHERE `IDTRANSPART`='".$dt['IDTRANSPART']."'");
$cek=mysqli_num_rows($part);
if($cek>0){

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(10,5,'Part : ',0,0);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30,5,$dt['IDTRANSPART'],0,1);

	


	while ($row = mysqli_fetch_array($part)){
		if($row['VPAYMENT']=="K"){
			$totalPart=$totalPart+$row['TOTPAYPART'];
		}
		$pdf->Cell(33,5,$row['PARTNUM'],0,0);
		$pdf->Cell(78,5,$row['PARTDESC'],0,0);
		$pdf->Cell(20,5,number_format($row['PRICE']),0,0,'R');
		$pdf->Cell(10,5,$row['QTY'],0,0,'C');
		$pdf->Cell(22,5,number_format($row['DISCOUNT']),0,0,'R');
		if($row['VPAYMENT']=="K"){
			$pdf->Cell(27,5,number_format($row['TOTPAYPART']).'  ',0,1,'R');
		}else{
			$pdf->Cell(27,5,'0  ',0,1,'R');
		}
	}

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(33,5,'',0,0,'C');
	$pdf->Cell(78,5,'',0,0,'C');
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(32,5,'Total Part',0,0,'R');
	$pdf->Cell(27,5,'Rp '.number_format($totalPart).'  ',0,1,'R');

}


$totalJasa=0;
$jasa = mysqli_query($con, "SELECT * FROM `dtl_jasa` WHERE `IDTRANSJASA`='".$dt['IDTRANSJASA']."'");
$cek=mysqli_num_rows($jasa);
if($cek>0){

	$pdf->Cell(10,5,'Jasa : ',0,0);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30,5,$dt['IDTRANSJASA'],0,1);



	while ($row = mysqli_fetch_array($jasa)){
		if($row['VPAYMENT']=="K"){
			$totalJasa=$totalJasa+(int)$row['TOTPAYJASA'];
		}
		$pdf->Cell(33,5,'',0,0);
		$pdf->Cell(78,5,$row['JOBDESC'],0,0);
		$pdf->Cell(20,5,number_format($row['PRICE']),0,0,'R');
		$pdf->Cell(10,5,'',0,0,'C');
		$pdf->Cell(22,5,number_format($row['DISCOUNT']),0,0,'R');
		if($row['VPAYMENT']=="K"){
			$pdf->Cell(27,5,number_format($row['TOTPAYJASA']).'  ',0,1,'R');
		}else{
			$pdf->Cell(27,5,'0  ',0,1,'R');
		}
	}

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(33,5,'',0,0,'C');
	$pdf->Cell(78,5,'',0,0,'C');
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(32,5,'Total Jasa',0,0,'R');
	$pdf->Cell(27,5,'Rp '.number_format($totalJasa).'  ',0,1,'R');
}

$pdf->SetFont('Arial','',12);
$pdf->Cell(40,5,'Mekanik:',0,0);
$pdf->Cell(55,5,'',0,0,'C');
$pdf->Cell(30,5,'',0,0,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(35,5,'Grand Total',0,0,'R');
$pdf->Cell(30,5,'Rp '.number_format($totalPart+$totalJasa).'  ',0,1,'R');

$pdf->SetFont('Arial','',12);
$nm=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM employee WHERE IDEMP='".$dt['MEKANIK']."'"));
$pdf->Cell(40,5,$nm['NAMA'],0,0);
$pdf->Cell(160,5,'',0,1,'C');

$pdf->Ln(2);

$pdf->SetFont('Arial','',12);
$pdf->Cell(190,5,'Terbilang: '.terbilang($totalPart+$totalJasa).' Rupiah',0,0);

$name=$_POST['idKWT'].".pdf";

$pdf->Output($name,'D');








function headerNota($pdf){
	require ('../dbRep.php');
	$cek=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM CABANG WHERE CABANG='".$_POST['noCABANG']."'"));


	$pdf->SetFont('Arial','',11);
	if($_POST['noCABANG']!='99999'){
		$pdf->Cell(200,4,'CABANG '.$_POST['noCABANG'],0,1);
	}else{
		$pdf->Cell(200,4,' KHUSUS HONDA',0,1);
	}

	$pdf->Cell(75,4,$cek['NAMA'],0,0);

	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(95,4,'Nota Pembayaran',0,0);

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,4,'Hal. '.$pdf->PageNo().' / {nb}',0,1);

	$pdf->SetFont('Arial','',9);
	$pdf->Cell(76,4,$cek['ALAMAT'],0,0);

	$pdf->SetFont('Arial','',11);
	$pdf->Cell(114,5,'CABANGmitrakarya.com',0,1);

	$pdf->SetFont('Arial','',9);
	$pdf->Cell(190,4,'Telp : '.$cek['PHONE'],0,1);

	
}






function penyebut($nilai) {
	$nilai = abs($nilai);
	$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " ". $huruf[$nilai];
	} else if ($nilai <20) {
		$temp = penyebut($nilai - 10). " Belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " Seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " Seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
	}     
	return $temp;
}

function terbilang($nilai) {
	if($nilai<0) {
		$hasil = "Minus ". trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}     		
	return $hasil;
}

?>


