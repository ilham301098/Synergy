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
		$this->Cell(190,7,'Laporan Penjualan Part',0,1,'C');

		$this->Ln(2);

		$this->SetFont('Arial','B',11);
		$this->Cell(190,5,date('l, d F Y', strtotime($_POST['HarSt'])),0,1,'C');

		$this->Ln(2);
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



$pdf->SetFont('Helvetica','B',9);

$pdf->Cell(6,5,'No',1,0,'C');
$pdf->Cell(10,5,'Tipe',1,0,'C');
$pdf->Cell(15,5,'No.Polisi',1,0,'C');
$pdf->Cell(28,5,'No. Transaksi',1,0,'C');
$pdf->Cell(25,5,'Nomor Part',1,0,'C');
$pdf->Cell(46,5,'Deskripsi Part',1,0,'C');
$pdf->Cell(16,5,'Harga',1,0,'C');
$pdf->Cell(10,5,'Qty',1,0,'C');
$pdf->Cell(15,5,'Discount',1,0,'C');
$pdf->Cell(18,5,'Sub Total',1,1,'C');


//// ISI ////
$pdf->SetFont('Helvetica','',8);

$grand=0;
$qty=0;
$disc=0;
$no=0;
$isi=mysqli_query($con,"SELECT * FROM dtl_part_jual a,trans_part b WHERE a.`IDTRANSPART`=b.`IDTRANSPART` AND a.CABANG='".$_POST['noCABANG']."' AND DATE(a.`DATE`)='".$_POST['HarSt']."' ORDER BY a.IDTRANSPART");
foreach ($isi as $key) { 
	$no++;
	$qty=$qty+$key['QTY'];
	$disc=$disc+$key['DISCOUNT'];

	$pdf->Cell(6,5,$no,1,0,'C');
	$pdf->Cell(10,5,$key['VPAYMENT'],1,0,'C');
	$pdf->Cell(15,5,$key['NOPOL'],1,0,'C');
	$pdf->Cell(28,5,"../".substr($key['IDTRANSPART'],6),1,0);
	$pdf->Cell(25,5,$key['PARTNUM'],1,0,'C');
	$pdf->Cell(46,5,substr($key['PARTDESC'],0,28),1,0);
	$pdf->Cell(16,5,number_format($key['PRICE']),1,0,'C');
	$pdf->Cell(10,5,$key['QTY'],1,0,'C');
	$pdf->Cell(15,5,number_format($key['DISCOUNT']),1,0,'C');
	if($key['VPAYMENT']=='K'){
		$grand=$grand+$key['TOTPAYPART'];
		$pdf->Cell(18,5,number_format($key['TOTPAYPART']),1,1,'C');
	}else{
		$pdf->Cell(18,5,'0',1,1,'C');
	}
}

//// ---- ////
$pdf->SetFont('Helvetica','B',9);

$pdf->Cell(146,5,'Grand Total :',1,0,'R');
$pdf->Cell(10,5,number_format($qty),1,0,'C');
$pdf->Cell(15,5,number_format($disc),1,0,'C');
$pdf->Cell(18,5,number_format($grand),1,1,'C');

$pdf->Ln(2);


$name="PenjualanPart_".$_POST['HarSt'].".pdf";

$pdf->Output($name,'D');

?>
