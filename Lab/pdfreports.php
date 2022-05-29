<?php
require('fpdf.php');
include_once "conn1.php";

class PDF extends FPDF
{
var $headTitle;
var $repDate;
// Page header
function setHeaderTitleLn1($headerTitleLn1)
{
	$this -> headTitleLn1 = $headerTitleLn1;
}
function setHeaderTitleLn2($headerTitleLn2)
{
	$this -> headTitleLn2 = $headerTitleLn2;
}
function Header()
{
    // Logo
    $this->Image('images/heritage-house-dental.png',10,6,30);
    $this->Image('images/winston-churchill-dental.png',170,5,30);
    // Arial bold 15
    $this->SetFont('Arial','B',10);
    // Move to the right
    $this->Cell(45);
    // Title
    $this->Cell(100,8,$this->headTitleLn1,0,2,'C');
    $this->SetFont('Arial','B',8);
    $this->Cell(100,8,$this->headTitleLn2,0,0,'C');
    // Line break
    $this->Ln(10);
    $this->SetFont('Times','U',8);
	$this -> Cell(20,5,'Case Number', 0,0);
	$this -> Cell(30,5,'Patient Name', 0,0);
	$this -> Cell(30,5,'Lab Invoice No', 0,0);
	$this -> Cell(30,5,'Lab Invoice Amount', 0,0);
	$this -> Cell(40,5,'Associcate Deduction', 0,0);
	$this -> Cell(40,5,'Associate Deduction Dt', 0,1);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

if(isset($_POST['run_report_1']))
{
	$assDedPerDt = $_POST['selectAssDedDt'];
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$query_s =  "SELECT CT.DOCTOR_NAME, SUM(CT.LAB_COST) AS SUM_LAB_COST ".
			"FROM CASE_TBL CT ".
			"WHERE   CT.ASSOCIATE_DEDUCTION = 'YES' ".
			"AND     CT.ASSOCIATE_DEDUCTION_UPD_DT >= '{$assDedPerDt}' ".
			"GROUP BY CT.DOCTOR_NAME ".
			"ORDER BY CT.DOCTOR_NAME";
	$result_s = mysqli_query($con, $query_s);
	if(mysqli_num_rows($result_s) > 0)
	{
		while ($row = mysqli_fetch_assoc($result_s)) 
		{
    		$docName = $row['DOCTOR_NAME'];
    		$sumLabCost = $row['SUM_LAB_COST'];
    		$pdf->setHeaderTitleLn1('Associate Deduction Report - All');
    		$pdf->setHeaderTitleLn2('As of Date: ' . $assDedPerDt);
    		$pdf->AddPage();
    		$pdf->SetFont('Times','B',10);
    		$pdf->Cell(0,10,$docName, 0,1);
			$query = 	"SELECT  CT.CASE_NUMBER_ID, ". 
        		"PT.PATIENT_FNAME, PT.PATIENT_LNAME, ".
        		"CT.LAB_INVOICE_NO, CT.LAB_COST, ".
        		"CT.ASSOCIATE_DEDUCTION, CT.ASSOCIATE_DEDUCTION_UPD_DT ".
				"FROM    CASE_TBL CT JOIN PATIENT_TBL PT ON PT.PATIENT_ID = CT.PATIENT_ID ".
				"WHERE   CT.ASSOCIATE_DEDUCTION = 'YES' ".
				"AND     CT.ASSOCIATE_DEDUCTION_UPD_DT > '{$assDedPerDt}' ".
				"AND     CT.DOCTOR_NAME = '{$docName}' ".
				"ORDER BY CT.CASE_NUMBER_ID";
			$result = mysqli_query($con, $query);
			while ($row = mysqli_fetch_assoc($result)) 
			{
    			$caseNumId = $row['CASE_NUMBER_ID'];
    			$patFName = $row['PATIENT_FNAME'];
    			$patLName = $row['PATIENT_LNAME'];
    			$labInvNo = $row['LAB_INVOICE_NO'];
    			$labCost = $row['LAB_COST'];
    			$assDed = $row['ASSOCIATE_DEDUCTION'];
    			$assDedUpdDt = $row['ASSOCIATE_DEDUCTION_UPD_DT'];
    			$pdf->SetFont('Times','',8);
				$pdf -> Cell(20,5,$caseNumId, 0,0);
    			$pdf -> Cell(30,5,$patFName . ' ' . $patLName, 0,0);
    			$pdf -> Cell(30,5,$labInvNo, 0,0);
    			$pdf -> Cell(30,5,'$ ' . $labCost, 0,0);
    			$pdf -> Cell(40,5,$assDed, 0,0);
    			$pdf -> Cell(20,5,$assDedUpdDt, 0,1);
    		}
    		$pdf->SetFont('Times','B',10);
    		$pdf -> Cell(20,5,'Total: ' . $sumLabCost, 0,1);
		}
		$pdf->Output('run_report_1.pdf','I');
	}
	else 
	{
		$pdf->setHeaderTitleLn1('Associate Deduction Report - All');
    	$pdf->setHeaderTitleLn2('As of Date: ' . $assDedPerDt);
    	$pdf->AddPage();
    	$pdf->SetFont('Arial','B',10);
    	$pdf->Ln(10);
    	$pdf->Cell(50,5,'No valid data has been returned - please verify Input Data',0,1);
    	$pdf->SetFont('Arial','',8);
    	$pdf->Cell(50,5,'As of Date: ' . $assDedPerDt,0,1);
    	$pdf->Output('run_report_1.pdf','I');
	}
}
if(isset($_POST['run_report_2']))
{
	$dentistName = $_POST['dentist_lst'];
	$assDedFromDt = $_POST['selectFromAssDedDt'];
	$assDedToDt = $_POST['selectToAssDedDt'];
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$query_s =  "SELECT CT.DOCTOR_NAME, SUM(CT.LAB_COST) AS SUM_LAB_COST ".
			"FROM CASE_TBL CT ".
			"WHERE   CT.ASSOCIATE_DEDUCTION = 'YES' ".
			"AND     DATE(CT.ASSOCIATE_DEDUCTION_UPD_DT) >= DATE '{$assDedFromDt}' ".
			"AND     DATE(CT.ASSOCIATE_DEDUCTION_UPD_DT) <= DATE '{$assDedToDt}' ".
			"AND     CT.DOCTOR_NAME = '{$dentistName}' ".
			"GROUP BY CT.DOCTOR_NAME";
	$result_s = mysqli_query($con, $query_s);
	if(mysqli_num_rows($result_s) > 0)
	{
		while ($row = mysqli_fetch_assoc($result_s)) 
		{
    		$docName = $row['DOCTOR_NAME'];
    		$sumLabCost = $row['SUM_LAB_COST'];
    		$pdf->setHeaderTitleLn1('Associate Deduction Report - ' . $dentistName);
    		$pdf->setHeaderTitleLn2('From: ' . $assDedFromDt . ' To ' . $assDedToDt);
    		$pdf->AddPage();
		}
		$query = 	"SELECT  CT.CASE_NUMBER_ID, ". 
        	"PT.PATIENT_FNAME, PT.PATIENT_LNAME, ".
        	"CT.LAB_INVOICE_NO, CT.LAB_COST, ".
        	"CT.ASSOCIATE_DEDUCTION, CT.ASSOCIATE_DEDUCTION_UPD_DT ".
			"FROM    CASE_TBL CT JOIN PATIENT_TBL PT ON PT.PATIENT_ID = CT.PATIENT_ID ".
			"WHERE   CT.ASSOCIATE_DEDUCTION = 'YES' ".
			"AND     DATE(CT.ASSOCIATE_DEDUCTION_UPD_DT) >= DATE '{$assDedFromDt}' ".
			"AND     DATE(CT.ASSOCIATE_DEDUCTION_UPD_DT) <= DATE '{$assDedToDt}' ".
			"AND     CT.DOCTOR_NAME = '{$dentistName}' ".
			"ORDER BY CT.CASE_NUMBER_ID";
		$result = mysqli_query($con, $query);
		while ($row = mysqli_fetch_assoc($result)) 
		{
    		$caseNumId = $row['CASE_NUMBER_ID'];
    		$patFName = $row['PATIENT_FNAME'];
    		$patLName = $row['PATIENT_LNAME'];
    		$labInvNo = $row['LAB_INVOICE_NO'];
    		$labCost = $row['LAB_COST'];
    		$assDed = $row['ASSOCIATE_DEDUCTION'];
    		$assDedUpdDt = $row['ASSOCIATE_DEDUCTION_UPD_DT'];
    		$pdf->SetFont('Times','',8);
			$pdf -> Cell(20,5,$caseNumId, 0,0);
    		$pdf -> Cell(30,5,$patFName . ' ' . $patLName, 0,0);
    		$pdf -> Cell(30,5,$labInvNo, 0,0);
    		$pdf -> Cell(30,5,'$ ' . $labCost, 0,0);
    		$pdf -> Cell(40,5,$assDed, 0,0);
    		$pdf -> Cell(20,5,$assDedUpdDt, 0,1);
   	 	}
    	$pdf->SetFont('Times','B',10);
    	$pdf -> Cell(20,5,'Total: ' . $sumLabCost, 0,1);
		$pdf->Output('run_report_2.pdf','I');
	}
	else 
	{
		$pdf->setHeaderTitleLn1('Associate Deduction Report - All');
    	$pdf->setHeaderTitleLn2('As of Date: ' . $assDedPerDt);
    	$pdf->AddPage();
    	$pdf->SetFont('Arial','B',10);
    	$pdf->Ln(10);
    	$pdf->Cell(50,5,'No valid data has been returned - please verify Input Data',0,1);
    	$pdf->SetFont('Arial','',8);
    	$pdf->Cell(50,5,'Dentist Name: ' . $dentistName,0,1);
    	$pdf->Cell(50,5,'From Date: ' . $assDedFromDt,0,1);
    	$pdf->Cell(50,5,'To Date: ' . $assDedToDt,0,0);
    	$pdf->Output('run_report_1.pdf','I');
	}
}
?>