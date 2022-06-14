<?php
require('fpdf.php');

class PDF extends FPDF {
// Page header
	function Header(){
		$this->SetFont('Arial','',11);
		$this->Cell(190,4,'CABANG '.$_POST['noCABANG'],0,1);
		$this->Cell(170,4,strtoupper($_POST['namaCABANG']),0,0);
		$this->SetFont('Arial','',10);
		$this->Cell(20,4,'Hal. '.$this->PageNo().' / {nb}',0,1);
		$this->SetFont('Arial','',9);
		$this->Cell(190,4,$_POST['addrCABANG'],0,1);
		$this->Cell(190,4,'Telp : '.$_POST['phoneCABANG'],0,1);

		$this->SetFont('Helvetica','B',14);
		$this->Cell(190,7,'Laporan Penerimaan Part',0,1,'C');

		$this->Ln(2);

		$this->SetFont('Arial','B',11);
		$this->Cell(190,5,date('l, d F Y', strtotime($_POST['HarSt'])),0,1,'C');

		$this->Ln(2);

		$this->SetFont('Helvetica','B',9);

		$this->Cell(8,5,'No',1,0,'C');
		$this->Cell(32,5,'No. Transaksi',1,0,'C');
		$this->Cell(20,5,'No. Faktur',1,0,'C');
		$this->Cell(20,5,'Supplier',1,0,'C');
		$this->Cell(25,5,'Nomor Part',1,0,'C');
		$this->Cell(40,5,'Deskripsi Part',1,0,'C');
		$this->Cell(8,5,'Qty',1,0,'C');
		$this->Cell(19,5,'Harga',1,0,'C');
		$this->Cell(18,5,'Sub Total',1,1,'C');
	}

// Page footer
	function Footer(){
		require ('dbRep.php');
    // Position at 1.5 cm from bottom
		$this->SetY(-20);
		$this->SetFont('Arial','',10);
		$this->Cell(190,7,'Di cetak pada '.date('l, d F Y - H:i:s'),1,1,'C');
	}
}

// memanggil library FPDF

// intance object dan memberikan pengaturan halaman PDF

require ('dbRep.php');

$pdf = new PDF('P','mm','A4');

// membuat halaman baru
$pdf->AliasNbPages();
$pdf->SetMargins(10,6,7);
$pdf->AddPage();


// setting jenis font yang akan digunakan






//// ISI ////
$pdf->SetFont('Helvetica','',8);
$total=0;
$qty=0;
$no=0;

$isi=mysqli_query($con,"SELECT * FROM dtl_part_mutasi a,trans_mutasi b WHERE a.IDMUTASIPART=b.IDMUTASIPART AND a.TUJUAN='".$_POST['noCABANG']."' AND DATE(a.`DCREA`)='".$_POST['HarSt']."' ORDER BY a.IDMUTASIPART");
foreach ($isi as $key) { 
	$no++;
	$qty=$qty+$key['QTY'];
	$total=$total+$key['HARGA']*$key['QTY'];
	$pdf->Cell(8,5,$no,1,0,'C');
	$pdf->Cell(32,5,$key['IDMUTASIPART'],1,0,'C');
	$pdf->Cell(20,5,$key['NAMA'],1,0,'C');
	$pdf->Cell(20,5,$key['ASAL'],1,0,'C');
	$pdf->Cell(25,5,$key['PARTNUM'],1,0,'C');
	$pdf->Cell(40,5,substr($key['PARTDESC'],0,23),1,0,'L');
	$pdf->Cell(8,5,$key['QTY'],1,0,'C');
	$pdf->Cell(19,5,number_format($key['HARGA']),1,0,'C');
	$pdf->Cell(18,5,number_format($key['HARGA']*$key['QTY']),1,1,'C');
}

$isi=mysqli_query($con,"SELECT * FROM dtl_part_beli a,buy_part b WHERE a.IDBUYPART=b.IDBUYPART AND a.CABANG='".$_POST['noCABANG']."' AND DATE(a.`DCREA`)='".$_POST['HarSt']."' ORDER BY a.IDBUYPART");
foreach ($isi as $key) { 
	$no++;
	$qty=$qty+$key['QTY'];
	$total=$total+$key['HARGA']*$key['QTY'];
	$pdf->Cell(8,5,$no,1,0,'C');
	$pdf->Cell(32,5,$key['IDBUYPART'],1,0,'C');
	$pdf->Cell(20,5,$key['FAKTUR'],1,0,'C');
	$pdf->Cell(20,5,$key['SUPPLIER'],1,0,'C');
	$pdf->Cell(25,5,$key['PARTNUM'],1,0,'C');
	$pdf->Cell(40,5,substr($key['PARTDESC'],0,23),1,0,'L');
	$pdf->Cell(8,5,$key['QTY'],1,0,'C');
	$pdf->Cell(19,5,number_format($key['HARGA']),1,0,'C');
	$pdf->Cell(18,5,number_format($key['HARGA']*$key['QTY']),1,1,'C');
}

//// ---- ////
$pdf->SetFont('Helvetica','B',9);

$pdf->Cell(145,5,'Total Item :',1,0,'R');
$pdf->Cell(8,5,number_format($qty),1,0,'L');
$pdf->Cell(19,5,'Grand Total:',1,0,'L');
$pdf->Cell(18,5,number_format($total),1,1,'R');

$pdf->Ln(2);


$name="PembelianPart_".$_POST['HarSt'].".pdf";

$pdf->Output($name,'D');

?>
