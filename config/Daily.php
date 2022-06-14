<?php
require('fpdf.php');

class PDF extends FPDF {
// Page header
	function Header(){
		if(!empty($this->enableheader)){
			call_user_func($this->enableheader,$this);
		}
		
	}

// Page footer
	function Footer(){
		$this->SetY(-20);
		$this->SetFont('Arial','',10);
		$this->Cell(190,6,'*Apabila terdapat selisih pada laporan di atas, harap menambahkan catatan pada Laporan Penunjang.',0,1,'L');
		
	}
}

// memanggil library FPDF

// intance object dan memberikan pengaturan halaman PDF

require ('dbRep.php');

$pdf = new PDF('L','mm','A4');



// membuat halaman baru
$pdf->AliasNbPages();
$pdf->SetMargins(10,6,7);

$pdf->enableheader = 'headerPenjualanPart';
$pdf->AddPage('P');


// setting jenis font yang akan digunakan



$pdf->SetFont('Helvetica','B',9);

$pdf->Cell(6,5,'No',1,0,'C');
// $pdf->Cell(10,5,'Tipe',1,0,'C');
$pdf->Cell(20,5,'No.Polisi',1,0,'C');
$pdf->Cell(20,5,'ID. SOP',1,0,'C');
$pdf->Cell(25,5,'Nomor Part',1,0,'C');
$pdf->Cell(59,5,'Deskripsi Part',1,0,'C');
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
$isi=mysqli_query($con,"SELECT * FROM dtl_part_jual  WHERE  CABANG='".$_POST['noCABANG']."' AND DATE( `DATE`)='".$_POST['HarSt']."' ORDER BY IDTRANSPART");
foreach ($isi as $key) { 
	$no++;
	$qty=$qty+$key['QTY'];
	$disc=$disc+$key['DISCOUNT'];

	$pdf->Cell(6,5,$no,1,0,'C');
	// $pdf->Cell(10,5,$key['VPAYMENT'],1,0,'C');
	$pdf->Cell(20,5,'',1,0,'C');
	$pdf->Cell(20,5,substr($key['IDTRANSPART'],-5),1,0,'C');
	$pdf->Cell(25,5,$key['PARTNUM'],1,0,'C');
	$pdf->Cell(59,5,substr($key['PARTDESC'],0,28),1,0);
	$pdf->Cell(16,5,number_format($key['PRICE']),1,0,'C');
	$pdf->Cell(10,5,$key['QTY'],1,0,'C');
	
	if($key['VPAYMENT']=='K'){
		$grand=$grand+$key['TOTPAYPART'];
		$pdf->Cell(15,5,number_format($key['DISCOUNT']+$key['DISC_RP']),1,0,'C');
		$pdf->Cell(18,5,number_format($key['TOTPAYPART']),1,1,'C');
	}else{
		$pdf->Cell(33,5,'Main Dealer',1,1,'C');
	}
}

//// ---- ////
$pdf->SetFont('Helvetica','B',9);

$pdf->Cell(146,5,'Grand Total :',1,0,'R');
$pdf->Cell(10,5,number_format($qty),1,0,'C');
$pdf->Cell(15,5,number_format($disc),1,0,'C');
$pdf->Cell(18,5,number_format($grand),1,1,'C');

$pdf->Ln(2);


$pembelian=mysqli_query($con,"SELECT * FROM dtl_part_beli a,buy_part b WHERE a.IDBUYPART=b.IDBUYPART AND a.CABANG='".$_POST['noCABANG']."' AND DATE(a.`DCREA`)='".$_POST['HarSt']."' ORDER BY a.IDBUYPART");
$cek=mysqli_num_rows($pembelian);
if($cek>0){

	$pdf->AliasNbPages();
	$pdf->SetMargins(10,6,7);

	$pdf->SetFont('Helvetica','',8);
	$total=0;
	$qty=0;
	$no=0;

	$pdf->enableheader = 'headerPembelianPart';
	$pdf->AddPage('P');


	foreach ($pembelian as $key) { 
		$no++;
		$qty=$qty+$key['QTY'];
		$total=$total+$key['HARGA']*$key['QTY'];
		$pdf->Cell(8,5,$no,1,0,'C');
		$pdf->Cell(17,5,substr($key['IDBUYPART'],-5),1,0,'C');
		$pdf->Cell(20,5,$key['FAKTUR'],1,0,'C');
		$pdf->Cell(20,5,$key['SUPPLIER'],1,0,'C');
		$pdf->Cell(30,5,$key['PARTNUM'],1,0,'C');
		$pdf->Cell(50,5,substr($key['PARTDESC'],0,26),1,0,'L');
		$pdf->Cell(8,5,$key['QTY'],1,0,'C');
		$pdf->Cell(19,5,number_format($key['HARGA']),1,0,'C');
		$pdf->Cell(18,5,number_format($key['HARGA']*$key['QTY']),1,1,'C');
	}

	$pdf->SetFont('Helvetica','B',9);

	$pdf->Cell(145,5,'Pembelian Sparepart: ',1,0,'R');
	$pdf->Cell(8,5,number_format($qty),1,0,'L');
	$pdf->Cell(19,5,'Grand Total:',1,0,'L');
	$pdf->Cell(18,5,number_format($total),1,1,'R');

	$pdf->Ln(2);

}else{
	$pdf->Cell(190,7,'(Tidak Ada Transaksi Pembelian Part)',0,1,'C');
}





$name=$_POST['noCABANG']."_Daily_".$_POST['HarSt'].".pdf";

$pdf->Output($name,'D');


function headerPenjualanPart($pdf){
	require ('dbRep.php');
	$cek=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM CABANG WHERE CABANG='".$_POST['noCABANG']."'"));

	$pdf->SetFont('Arial','',11);
	$pdf->Cell(190,4,'CABANG '.$_POST['noCABANG'],0,1);
	$pdf->Cell(170,4,strtoupper($cek['NAMA']),0,0);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(20,4,'Hal. '.$pdf->PageNo().' / {nb}',0,1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(190,4,$cek['ALAMAT'],0,1);
	$pdf->Cell(190,4,'Telp : '.$cek['PHONE'],0,1);

	$pdf->SetFont('Helvetica','B',14);
	$pdf->Cell(190,7,'Report Sales Order',0,1,'C');

	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(190,5,date('l, d F Y', strtotime($_POST['HarSt'])),0,1,'C');

	$pdf->SetFont('Arial','',9);
	$pdf->Cell(190,5,'Waktu cetak :'.date('l, d F Y (H:i)'),0,1,'C');

	$pdf->Ln(2);
}

function headerPembelianPart($pdf){
	require ('dbRep.php');
	$cek=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM CABANG WHERE CABANG='".$_POST['noCABANG']."'"));

	$pdf->SetFont('Arial','',11);
	$pdf->Cell(190,4,'CABANG '.$_POST['noCABANG'],0,1);
	$pdf->Cell(170,4,strtoupper($cek['NAMA']),0,0);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(20,4,'Hal. '.$pdf->PageNo().' / {nb}',0,1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(190,4,$cek['ALAMAT'],0,1);
	$pdf->Cell(190,4,'Telp : '.$cek['PHONE'],0,1);

	$pdf->SetFont('Helvetica','B',14);
	$pdf->Cell(190,7,'Report Purchase Order',0,1,'C');

	$pdf->Ln(1);

	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(190,5,date('l, d F Y', strtotime($_POST['HarSt'])),0,1,'C');

	$pdf->Ln(2);

	$pdf->SetFont('Helvetica','B',9);

	$pdf->Cell(8,5,'No',1,0,'C');
	$pdf->Cell(17,5,'Id. Buy',1,0,'C');
	$pdf->Cell(20,5,'No. Faktur',1,0,'C');
	$pdf->Cell(20,5,'Supplier',1,0,'C');
	$pdf->Cell(30,5,'Nomor Part',1,0,'C');
	$pdf->Cell(50,5,'Deskripsi Part',1,0,'C');
	$pdf->Cell(8,5,'Qty',1,0,'C');
	$pdf->Cell(19,5,'Harga Jual',1,0,'C');
	$pdf->Cell(18,5,'Sub Total',1,1,'C');
}


?>
