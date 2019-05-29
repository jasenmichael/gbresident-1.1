<?php
global $target_file;
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["prod_pic"]["name"]);
 if (move_uploaded_file($_FILES["prod_pic"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["prod_pic"]["name"]). " has been uploaded.";
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }
	
	list($width, $height) = getimagesize($target_file);

	if((exif_imagetype($target_file) == 2 || exif_imagetype($target_file) == 3 ) && $width > 750 && $height < 750)//2 IMAGETYPE_JPEG
{	
	$image_type = exif_imagetype($target_file);
    $exif = exif_read_data($target_file);
	switch($image_type) {
		case 2:
			$image = imagecreatefromjpeg($target_file);
			$image = imagerotate($image,90,0);
			imagejpeg($image, $target_file);
		break;
		case 3:
			$image = imagecreatefrompng($target_file);
			$image = imagerotate($image,90,0);
			imagepng($image, $target_file);
		break;
	}
	
			
   
}
require('fpdf/fpdf.php');
class PDF extends FPDF
{
// Page header
function Header()
{
	global $target_file;
    // Logo
    // $this->Image($target_file,10,6,0);
    // Arial bold 15
	if( $this->page == 1) {
		$this->SetFont('Arial','B',15);
		// Move to the right
		$this->Cell(35);
		// Title
		$this->Cell(130,10,'Greenbriar Resident       ',0,1,'C');
		
		$this->Cell(55);
		$this->SetFont('Arial','B',13);
		$this->Cell(80,10,'Receipt Submission Form',0,1,'C');
		// Line break
		
		$this->Ln(5);
	}
    
	
	
}

// Page footer
function Footer()
{
	
	// Position at 1.5 cm from bottom
	$this->SetLineWidth(.5);
	$this->SetFont('','B');
	if( $this->page == 1) {
		$this->SetY(-55);

		$this->Cell(0,18,'',1,1,'C');
		$this->Cell(70,7,'Signature',1,0,'L');
		$this->Cell(60,7,'',1,0,'C');
		$this->Cell(60,7,'Date',1,1,'L');
		
		$this->Cell(0,7,'Secratary, Treasurer, or Marsalom board member signature ',1,1,'C');
		$this->MultiCell(0,5,'All resident credit over $100 requires prior approval, with Secratary, Treasurer, or Marsalom board member signature. NOTE: RECEIPT ON NEXT PAGE',1);
		// Line break
		$this->Ln(5);
	}
	else {
		$this->SetY(-25);
	}
    
    
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
// Colored table
function displayData( $data)
{
   
	//$this->Rect(5, 25, 200, 1, 'D');
	
	$this->Ln(5);
	
	$this->MultiCell(0,5,utf8_decode('Name:' . chr(10) . $data['name']),1);
	$this->Ln(5);
	$this->MultiCell(0,5,utf8_decode('Date:' . chr(10) . date('m/d/Y', strtotime($data['date']))),1);
	$this->Ln(5);
	
	$this->Cell(0,10,'Receipt purpose items and services:',0,1,'L');
	$this->MultiCell(0,5, $data['description'],1);
	
	$this->Ln(25);
	$this->Cell(70,10,'Receipt amount Total:',1,0,'R');
	$this->Cell(40,10,	'$'.number_format($data['amount'], 2), 1, 1,'R');
	$this->Ln(5);
	
	if( $data['amount_option'] == 1 ) {
		$this->Cell(70,10,'Receipt Credit Total:',1,0,'R');
		$this->Cell(40,10,'$'.number_format($data['amount'],2), 1, 1,'R');
		$this->Ln(5);
	} elseif( $data['amount_option'] == 2 ) {
		$this->Cell(70,10,'Receipt Donation Total:',1,0,'R');
		$this->Cell(40,10,'$'.number_format($data['amount'], 2), 1, 1,'R');
		$this->Ln(5);
	} else if( $data['amount_option'] == 3 ) {
		
		$this->Cell(70,10,'Receipt Credit Total:',1,0,'R');
		$this->Cell(40,10,'$'.number_format($data['credit'],2), 1, 1,'R');
		$this->Ln(5);
		
		$this->Cell(70,10,'Receipt Donation Total:',1,0,'R');
		$this->Cell(40,10,'$'.number_format($data['donation'], 2), 1, 1,'R');
		$this->Ln(5);
	}
	
	
	
	//$this->multicell(0,10,'Name \n bob',1,1,'L');
			// Line break
					
}
}
$data = $_POST;
//echo "<pre>";print_r($data);exit;
// Instanciation of inherited class
$pdf = new PDF('P','mm','A4');
$pdf->SetAutoPageBreak(true,35);
$pdf->lastPage = false;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->displayData($data);
$pdf->Ln(25);
$pdf->AddPage();
$pdf->Image($target_file,10,10,0);
$pdf->lastPage = true;
//echo dirname(__FILE__). '/home/files/archive/receipt-credit-submissions';
$pdf->Output(dirname(__FILE__). '/../files/archive/receipt-credit-submissions/'.date('Y-m-d').'-'.$data['name'].'-receipt-'.time().'.pdf', 'F');
// $pdf->Output();
unlink($target_file);

echo "all done";

 ?>
