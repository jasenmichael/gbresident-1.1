<?php

$disExportMomfShort = '2018-05';

require('fpdf/fpdf.php');
class PDF extends FPDF
{

	protected $isFinished=false;
// Page header
function Header()
{
	$disExportMomfLong = 'May 2018';

    // Logo
    //$this->Image('logo.png',10,6,30);
    // Arial bold 15
    if ($this->page == 1)
    {
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(35);
    // Title
    $this->Cell(130,10,'Marsalom Inc./Greenbriar Community School',0,1,'C');

	$this->Cell(55);
	$this->SetFont('Arial','B',13);
    //$this->Cell(80,10,'Resident Hours Submitted - '.date('M').' '.date('Y'),0,1,'C');
	//$this->Cell(80,10,'Resident Hours Submitted - January 2018');
	$this->Cell(80,10,'Resident Hours Submitted - '.$disExportMomfLong);


    // Line break
    $this->Ln(10);
	}

}

// Page footer
function Footer()
{

	// Position at 1.5 cm from bottom

    $this->SetY(-45);

	$this->SetLineWidth(.5);
	$this->SetFont('','B');
	if($this->isFinished){

	$this->Cell(0,7,'Signatures - Board Member needed for pre-approved projects',1,1,'C');
	$this->Cell(0,20,'',1,1,'C');
	$this->Cell(70,7,'Marsalom Board Member',1,0,'L');
	$this->Cell(60,7,'',1,0,'C');
	$this->Cell(60,7,'Date',1,0,'L');

	// Line break
    $this->Ln(5);
}
    $this->SetY(-10);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,5,'Page '.$this->PageNo().' of {nb}',0,0,'C');

}
// Colored table
function FancyTable($header, $data)
{

    foreach($data as $key => $row1)
    {
		if( isset($row1['work_form']) ) {

			$space_left= 286.93 -($this->GetY()+ 35);
			$page_height = 50;
			if( $page_height > $space_left )
				$this->AddPage();
			$this->Ln(5);
			$this->SetFont('','B');
			$this->Cell(80,10,$row1['name'],1,0,'C');
			// Line break
			$this->Ln(10);

			// Colors, line width and bold font
			$this->SetFillColor(227, 227, 227);
			$this->SetTextColor(255);
			$this->SetDrawColor(128,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');
			// Header
			$w = array(60, 40, 60, 15);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
			$this->Ln();
			// Color and font restoration
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			// Data
			$fill = false;

			$hours = 0;
			foreach( $row1['work_form'] as $row ){
				$space_left= 286.93 -($this->GetY()+ 35);
				if($space_left<30)
					$this->AddPage();
				//echo $row['service'];exit;
				$this->Cell($w[0],6,$row['service'],'LR',0,'C',$fill);
				$this->Cell($w[1],6, date('m/d/Y', strtotime($row['date']) ),'LR',0,'C',$fill) ;
				$this->Cell($w[2],6,($row['description']),'LR',0,'C',$fill);
				$this->Cell($w[3],6,($row['hours']),'LR',0,'C',$fill);

				//$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
				$hours += $row['hours'];

				$fill = !$fill;
				$this->Ln();

			}
			$this->Cell(array_sum($w),0,'','T');
			$this->Ln(5);
			//$this->Cell(50);
			// total hours
			$this->SetFont('','B');
			$this->Cell(0,0,$row1['name'].' submitted '.$hours.' hours  ',0,0,'R');
		}



		 // Closing line

    }
    $this->isFinished = true;

}
}

require_once('db-connection.php');


$query = "select user.* from user order by id desc";
$result = $conn->query($query);
$total_rows = $result->num_rows;
$count = 0;
$data = array(array());
while( $row = $result->fetch_assoc() ) {
	$data[$count] = $row;
	$query = "select work_form.* from work_form where fk_user_id = '".$row['id']."' order by id desc";
	$result1 = $conn->query($query);
	$total_rows1 = $result1->num_rows;
	while ( $row1 = $result1->fetch_assoc() ) {
		//print_r($row1);
		$data[$count]['work_form'][] = $row1;
	}
	$count++;
}



//echo "<pre>";print_r($data);exit;
// Column headings
$header = array('Project', 'Date', 'Description', 'Hours');
// Instanciation of inherited class
$pdf = new PDF('P','mm','Letter');
$pdf->SetAutoPageBreak(true,35);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->FancyTable($header,$data);

//$pdf->Output(dirname(__FILE__). '/../files/archive/work-credit-submissions/all-resident-work-'.date('Y-m-d').'-'.time().'.pdf', 'F');
//$pdf->Output(dirname(__FILE__). '/../files/archive/work-credit-submissions/all-resident-work-2018-01.pdf', 'F');
$pdf->Output(dirname(__FILE__). '/../files/archive/work-credit-submissions/all-resident-work-'.$disExportMomfShort.'.pdf', 'F');
// $pdf->Output();


// now create PDF for Single User

$header = array('Project', 'Date', 'Description', 'Hours');

foreach( $data as $key => $row_single ) {

	$work_form = '';
	if(isset($row_single['work_form'])) {
		foreach($row_single['work_form'] as $rs ) {
			$work_form .= $rs['id'] . ',';
		}

		$data1 = array();
		$work_form = rtrim($work_form, ',' );
		$data1[] = $row_single;
		$pdf = new PDF('P','mm','A4');
		$pdf->SetAutoPageBreak(true,35);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		$pdf->FancyTable($header,$data1);
		//$pdf->Output(dirname(__FILE__). '/../files/archive/work-credit-submissions/individual-resident-work/resident-work-'.$row_single['name'].'-'.date('Y-m-d').'-'.time().'.pdf', 'F');
		
		// indiv export
		//$pdf->Output(dirname(__FILE__). '/../files/archive/work-credit-submissions/individual-resident-work/resident-work-'.$row_single['name'].'-2018-01.pdf', 'F');
		$pdf->Output(dirname(__FILE__). '/../files/archive/work-credit-submissions/individual-resident-work/resident-work-'.$row_single['name'].'-'.$disExportMomfShort.'.pdf', 'F');



		// $query_delete = "delete from work_form where id in (".$work_form.")";
		// $conn->query($query_delete);
	}
}

echo "<script>alert('you have exported work hours submitted for last month, click here to see...');document.location='../'</script>";
 ?>
