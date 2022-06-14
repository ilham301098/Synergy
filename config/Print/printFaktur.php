<?php
require('../fpdf.php');

class PDF extends FPDF {
// Page header
	function Header(){
		$this->SetFont('Arial','',11);
		$this->Cell(200,4,'CABANG '.$_POST['noCABANG'],0,1);
		$this->Cell(165,4,$_POST['namaCABANG'],0,0);
		$this->SetFont('Arial','',10);
		$this->Cell(10,4,'Hal. '.$this->PageNo().' / {nb}',0,1);
		$this->SetFont('Arial','',9);
		$this->Cell(200,4,$_POST['addrCABANG'],0,1);
		$this->Cell(200,4,'Telp : '.$_POST['phoneCABANG'],0,1);
	}

// Page footer
	function Footer(){
		include ('../dbRep.php');
    // Position at 1.5 cm from bottom
		$this->SetY(-20);
		$this->SetFont('Arial','',10);
		$this->Cell(190,5,'Barang yang sudah dibeli tidak dapat dikembalikan dengan alasan apapun.',0,1,'C');
		$this->Cell(190,5,'Terima kasih telah memilih kami.',0,1,'C');
	}
}

// memanggil library FPDF

// intance object dan memberikan pengaturan halaman PDF

include ('../dbRep.php');

$pdf = new PDF('L','mm',array(148,210));

// membuat halaman baru
$pdf->AliasNbPages();
$pdf->SetMargins(10,6,7);
$pdf->AddPage();


// setting jenis font yang akan digunakan


$pdf->SetFont('Arial','B',13);
$pdf->Cell(190,7,'Purchase Order',0,1,'C');

$pdf->Ln(2);

$pdf->SetFont('Arial','',10);
$content = mysqli_query($con, "SELECT * FROM buy_part WHERE IDBUYPART='".$_POST['idKWT']."'");
$dt = mysqli_fetch_assoc($content);
$pdf->Cell(23,4,'No. Transaksi',0,0);
$pdf->Cell(75,4,': '.$dt['IDBUYPART'],0,0);
$pdf->Cell(25,4,'Nama Supplier',0,0);
$pdf->Cell(67,4,': '.$dt['SUPPLIER'],0,1);

$pdf->Cell(23,4,'Tgl. Nota',0,0);
$pdf->Cell(75,4,': '.date_format(date_create($dt['DCREA']),"d F Y H:i:s"),0,0);
$pdf->Cell(25,4,'No. Faktur',0,0);
$pdf->Cell(67,4,': '.$dt['FAKTUR'],0,1);

// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Ln(2);

$pdf->SetFont('Arial','',10);

$pdf->Cell(43,5,'Part Number',1,0,'C');
$pdf->Cell(98,5,'Nama Part',1,0,'C');
$pdf->Cell(16,5,'Qty',1,0,'C');
$pdf->Cell(33,5,'Jumlah',1,1,'C');


$totalPart=0;
$part = mysqli_query($con, "SELECT * FROM `dtl_part_beli` WHERE `IDBUYPART`='".$dt['IDBUYPART']."'");

while ($row = mysqli_fetch_array($part)){
	$pdf->Cell(43,5,$row['PARTNUM'],0,0);
	$pdf->Cell(98,5,$row['PARTDESC'],0,0);
	$pdf->Cell(16,5,$row['QTY'],0,0,'C');
	$pdf->Cell(33,5,'-',0,1,'R');

}
// $pdf->Ln(2);

// $pdf->SetFont('Arial','',12);
// $pdf->Cell(40,5,'',0,0);
// $pdf->Cell(55,5,'',0,0,'C');
// $pdf->Cell(30,5,'',0,0,'C');
// $pdf->SetFont('Arial','B',12);
// $pdf->Cell(35,5,'Grand Total',0,0,'R');
// $pdf->Cell(30,5,'Rp ',0,1,'R');



// $pdf->Ln(2);

// $pdf->SetFont('Arial','',12);
// $pdf->Cell(190,5,'Terbilang: '.terbilang($totalPart).' Rupiah',0,0);

$name=$_POST['idKWT'].".pdf";

$pdf->Output($name,'D');

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
