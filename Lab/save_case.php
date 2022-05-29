<?php 
	include_once "conn1.php";
	session_start(); 
	if (!isset($_SESSION['userName']))
	{
		header("Location: /lab/login.php");
	}
?>
<?php 
if((isset($_POST['submit_exit_1'])) or (isset($_POST['submit_exit_2'])))
{
	$officeName=$_POST['office_lst'];
	$patientId=$_POST['patient_lst_id'];
	$dentistName=$_POST['dentist_lst'];
	$labId=$_POST['lab_lst'];
	$labInvNo = $_POST['lab_invoice_no_txt'];
	$labInvAmt = $_POST['lab_invoice_am_txt'];
	$paidByPatient = $_POST['paidbypatient'];
	//$paidToLab = $_POST['paidtolab'];
		
	if (!get_magic_quotes_gpc()) {
		$officeName = addslashes($officeName);
		//$patientId = addslashes($patientId);
		$dentistName = addslashes($dentistName);
		//$labId = addslashes($labId);
		$labInvNo = addslashes($labInvNo);
		//$labInvAmt = addslashes($labInvAmt);
		$paidByPatient = addslashes($paidByPatient);
		//$paidToLab = addslashes($paidToLab);
	}
	
	$query = "insert into case_tbl(".
			 "OFFICE_NAME, PATIENT_ID, DOCTOR_NAME, LAB_ID, CASE_OPEN_DT, LAB_INVOICE_NO, LAB_COST, PAID_BY_PATIENT)".
			 " values ('{$officeName}',{$patientId},'{$dentistName}',{$labId},sysdate(),{$labInvNo},{$labInvAmt},'{$paidByPatient}')";
	$result = mysqli_query($con, $query);
	// Get the generated ID for just inserted record
	
	$query1 = "select LAST_INSERT_ID() as CASE_NUMBER_ID";
	$result = mysqli_query($con, $query1);
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$caseIdLast = $row['CASE_NUMBER_ID'];
	}
	# Process Procedures:
	$maxProcs = 15;
	for ($i = 1; $i <= $maxProcs; $i++)
	{
		$procName = $_POST['procName_' . $i];
		if (!empty($procName))
		{
			$procType = $_POST['procType_' . $i];
			$procQuadNo = $_POST['procQuadrantNo_' .$i];
			$procToothNo = $_POST['procToothNo_' .$i];
			$query = "insert into case_procedure_tbl(".
			 	"CASE_NUMBER_ID, CASE_PROCEDURE_NO, PROCEDURE_NAME, PROCEDURE_TYPE, QUADRANT_NUMBER, TOOTH_NUMBER)".
			 	" values ({$caseIdLast},{$i},'{$procName}','{$procType}','{$procQuadNo}','{$procToothNo}')";
			$result = mysqli_query($con, $query);
			for ($j = 1; $j <= 3; $j++)
			{
				$procCreateDate = $_POST['procCreateDate' . $j . '_' . $i];
				$procOutLabDate = $_POST['procOutLabDate' . $j . '_' . $i];
				$procFromLabDate = $_POST['procFromLabDate' . $j . '_' . $i];
				$procComments = $_POST['procComments' . $j . '_' . $i];
				$query = "insert into case_procedure_txn_tbl(".
			 	"CASE_NUMBER_ID, CASE_PROCEDURE_NO, PROC_TRANSACTION_ID, PROCEDURE_START_DT, PROCEDURE_OUT_TO_LAB_DT, PROCEDURE_BACK_FROM_LAB_DT, PROCEDURE_COMMENT)".
			 	" values ({$caseIdLast},{$i},{$j},'{$procCreateDate}','{$procOutLabDate}','{$procFromLabDate}','{$procComments}')";
				$result = mysqli_query($con, $query);
			}
		}
	}
	//include "search_display_cases.php";
	mysqli_close($con);
	header('Location: /lab/search_display_cases.php');
}
if(isset($_POST['submit_add_1']))
{
	$officeName=$_POST['office_lst'];
	$patientId=$_POST['patient_lst_id'];
	$dentistName=$_POST['dentist_lst'];
	$labId=$_POST['lab_lst'];
	$labInvNo = $_POST['lab_invoice_no_txt'];
	$labInvAmt = $_POST['lab_invoice_am_txt'];
	$paidByPatient = $_POST['paidbypatient'];
	//$paidToLab = $_POST['paidtolab'];
		
	if (!get_magic_quotes_gpc()) {
		$officeName = addslashes($officeName);
		//$patientId = addslashes($patientId);
		$dentistName = addslashes($dentistName);
		//$labId = addslashes($labId);
		$labInvNo = addslashes($labInvNo);
		//$labInvAmt = addslashes($labInvAmt);
		$paidByPatient = addslashes($paidByPatient);
		//$paidToLab = addslashes($paidToLab);
	}
	
	$query = "insert into case_tbl(".
			 "OFFICE_NAME, PATIENT_ID, DOCTOR_NAME, LAB_ID, CASE_OPEN_DT, LAB_INVOICE_NO, LAB_COST, PAID_BY_PATIENT)".
			 " values ('{$officeName}',{$patientId},'{$dentistName}',{$labId},sysdate(),{$labInvNo},{$labInvAmt},'{$paidByPatient}')";
	$result = mysqli_query($con, $query);
	// Get the generated ID for just inserted record
	
	$query1 = "select LAST_INSERT_ID() as CASE_NUMBER_ID";
	$result = mysqli_query($con, $query1);
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$caseIdLast = $row['CASE_NUMBER_ID'];
	}
	# Process Procedures:
	$maxProcs = 15;
	for ($i = 1; $i <= $maxProcs; $i++)
	{
		$procName = $_POST['procName_' . $i];
		if (!empty($procName))
		{
			$procType = $_POST['procType_' . $i];
			$procQuadNo = $_POST['procQuadrantNo_' .$i];
			$procToothNo = $_POST['procToothNo_' .$i];
			$query = "insert into case_procedure_tbl(".
			 	"CASE_NUMBER_ID, CASE_PROCEDURE_NO, PROCEDURE_NAME, PROCEDURE_TYPE, QUADRANT_NUMBER, TOOTH_NUMBER)".
			 	" values ({$caseIdLast},{$i},'{$procName}','{$procType}','{$procQuadNo}','{$procToothNo}')";
			$result = mysqli_query($con, $query);
			for ($j = 1; $j <= 3; $j++)
			{
				$procCreateDate = $_POST['procCreateDate' . $j . '_' . $i];
				$procOutLabDate = $_POST['procOutLabDate' . $j . '_' . $i];
				$procFromLabDate = $_POST['procFromLabDate' . $j . '_' . $i];
				$procComments = $_POST['procComments' . $j . '_' . $i];
				$query = "insert into case_procedure_txn_tbl(".
			 	"CASE_NUMBER_ID, CASE_PROCEDURE_NO, PROC_TRANSACTION_ID, PROCEDURE_START_DT, PROCEDURE_OUT_TO_LAB_DT, PROCEDURE_BACK_FROM_LAB_DT, PROCEDURE_COMMENT)".
			 	" values ({$caseIdLast},{$i},{$j},'{$procCreateDate}','{$procOutLabDate}','{$procFromLabDate}','{$procComments}')";
				$result = mysqli_query($con, $query);
			}
		}
	}
	//include "search_display_cases.php";
	mysqli_close($con);
	header("Location: /lab/get_display_case_proc.php?cId=".$caseIdLast."&eProc=1");
}
?>
