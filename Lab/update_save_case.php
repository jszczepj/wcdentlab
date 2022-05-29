<?php 
	session_start(); 
	if (!isset($_SESSION['userName']))
	{
		header("Location: /lab/login.php");
	}
	include_once "conn1.php"; 

if((isset($_POST['submit_exit_1'])) or (isset($_POST['submit_exit_2'])))
{
	# Define variables for saving patient info
	$caseId=$_POST['currentCase_No'];	
	$officeName=$_POST['office_lst'];
	$patientId=$_POST['patient_lst_id'];
	$dentistName=$_POST['dentist_lst'];
	$labId=$_POST['lab_lst'];
	$labInvNo = $_POST['lab_invoice_no_txt'];
	$labInvAmt = $_POST['lab_invoice_am_txt'];
	$paidByPatient = $_POST['paidbypatient'];
	$paidToLab = $_POST['paidtolab'];
	$associateDeduction = $_POST['associatededuction'];
	$associateDeductionUpdDt = $_POST['associatedeductionupddt'];
			
	if (!$officeName || !$patientId || !$dentistName || !$labId ) 
	{
		echo "You have not entered all the required details.<br />"
		."Please go back and try again.";
		exit;
	}
	if (!get_magic_quotes_gpc()) 
	{
		$officeName = addslashes($officeName);
		//$patientId = addslashes($patientId);
		$dentistName = addslashes($dentistName);
		//$labId = addslashes($labId);
		$labInvNo = addslashes($labInvNo);
		//$labInvAmt = addslashes($labInvAmt);
		$paidByPatient = addslashes($paidByPatient);
		$paidToLab = addslashes($paidToLab);
		$associateDeduction = addslashes($associateDeduction);
		$associateDeductionUpdDt = addslashes($associateDeductionUpdDt);
	}
	if ($associateDeduction == 'NO' && empty($associateDeductionUpdDt))
	{
		$query = "update case_tbl set ".
			 "OFFICE_NAME = '{$officeName}', PATIENT_ID = {$patientId}, DOCTOR_NAME = '{$dentistName}', LAB_ID = {$labId}, " .
			 "LAB_INVOICE_NO = {$labInvNo}, LAB_COST = {$labInvAmt}, PAID_BY_PATIENT = '{$paidByPatient}', PAID_TO_LAB = '{$paidToLab}', " .
			 "ASSOCIATE_DEDUCTION = '{$associateDeduction}' " .
			 "where CASE_NUMBER_ID = {$caseId}";
	}
	elseif ($associateDeduction == 'YES' && empty($associateDeductionUpdDt))
	{
		$query = "update case_tbl set ".
			 "OFFICE_NAME = '{$officeName}', PATIENT_ID = {$patientId}, DOCTOR_NAME = '{$dentistName}', LAB_ID = {$labId}, " .
			 "LAB_INVOICE_NO = {$labInvNo}, LAB_COST = {$labInvAmt}, PAID_BY_PATIENT = '{$paidByPatient}', PAID_TO_LAB = '{$paidToLab}', " .
			 "ASSOCIATE_DEDUCTION = '{$associateDeduction}', " .
			 "ASSOCIATE_DEDUCTION_UPD_DT = NOW() " .
			 "where CASE_NUMBER_ID = {$caseId}";
	}
	else 
	{
		$query = "update case_tbl set ".
			 "OFFICE_NAME = '{$officeName}', PATIENT_ID = {$patientId}, DOCTOR_NAME = '{$dentistName}', " .
		     "LAB_ID = {$labId}, LAB_INVOICE_NO = {$labInvNo}, LAB_COST = {$labInvAmt}, " .
		     "PAID_BY_PATIENT = '{$paidByPatient}', " .
			 "PAID_TO_LAB = '{$paidToLab}' " .
			 "where CASE_NUMBER_ID = {$caseId}";
	}
	//echo "$query\n";
	//echo "\n";
	$result = mysqli_query($con, $query);
	
	// Process Procedures ...
	// Get the current count of procedures
	$maxProcs = 15;
	$query_s = "select count(*) as COUNT from case_procedure_tbl where CASE_NUMBER_ID = ${caseId}"; 
	$result_s = mysqli_query($con, $query_s);
	while ($row_s = mysqli_fetch_assoc($result_s)) 
	{
		$procCount = $row_s['COUNT'];
	}
	for ($i = 1; $i <= $maxProcs; $i++)
	{
		if ($i <= $procCount)
		{
			// Doing Update
			$procName = $_POST['procName_' . $i];
			$procType = $_POST['procType_' . $i];
			$procQuadNo = $_POST['procQuadrantNo_' .$i];
			$procToothNo = $_POST['procToothNo_' .$i];
			$query = "update case_procedure_tbl set ".
			         "PROCEDURE_NAME = '{$procName}', PROCEDURE_TYPE = '{$procType}', QUADRANT_NUMBER = '{$procQuadNo}', TOOTH_NUMBER = '{$procToothNo}' ".
			         "where CASE_NUMBER_ID = {$caseId} and CASE_PROCEDURE_NO = {$i}";
			$result = mysqli_query($con, $query);
			for ($j = 1; $j <= 3; $j++)
			{
				$procCreateDate = $_POST['procCreateDate' . $j . '_' . $i];
				$procOutLabDate = $_POST['procOutLabDate' . $j . '_' . $i];
				$procFromLabDate = $_POST['procFromLabDate' . $j . '_' . $i];
				$procComments = $_POST['procComments' . $j . '_' . $i];

				$query = "update case_procedure_txn_tbl set ".
						 "PROCEDURE_START_DT = '{$procCreateDate}', PROCEDURE_OUT_TO_LAB_DT = '{$procOutLabDate}', PROCEDURE_BACK_FROM_LAB_DT = '{$procFromLabDate}', PROCEDURE_COMMENT = '{$procComments}' " .
				         "where CASE_NUMBER_ID = {$caseId} and CASE_PROCEDURE_NO = {$i} and PROC_TRANSACTION_ID = {$j}";   
				$result = mysqli_query($con, $query);
			}	
		}
		else	// Process adding new procedures to the case 
		{
			// Doing Update
			$procName = $_POST['procName_' . $i];
			$procType = $_POST['procType_' . $i];
			$procQuadNo = $_POST['procQuadrantNo_' .$i];
			$procToothNo = $_POST['procToothNo_' .$i];
			//if (!empty($procName) || !empty($procType) || !empty($procToothNo))
			if (!empty($procName))
			{
				$query = "insert into case_procedure_tbl(".
			 			 "CASE_NUMBER_ID, CASE_PROCEDURE_NO, PROCEDURE_NAME, PROCEDURE_TYPE, QUADRANT_NUMBER, TOOTH_NUMBER)".
			 			 " values ({$caseId},{$i},'{$procName}','{$procType}','{$procQuadNo}','{$procToothNo}')";
			//echo "$query\n";
				$result = mysqli_query($con, $query);
				for ($j = 1; $j <= 3; $j++)
				{
					$procCreateDate = $_POST['procCreateDate' . $j . '_' . $i];
					$procOutLabDate = $_POST['procOutLabDate' . $j . '_' . $i];
					$procFromLabDate = $_POST['procFromLabDate' . $j . '_' . $i];
					$procComments = $_POST['procComments' . $j . '_' . $i];
					$query = "insert into case_procedure_txn_tbl(".
			 		"CASE_NUMBER_ID, CASE_PROCEDURE_NO, PROC_TRANSACTION_ID, PROCEDURE_START_DT, PROCEDURE_OUT_TO_LAB_DT, PROCEDURE_BACK_FROM_LAB_DT, PROCEDURE_COMMENT)".
			 		" values ({$caseId},{$i},{$j},'{$procCreateDate}','{$procOutLabDate}','{$procFromLabDate}','{$procComments}')";
					//echo "$query";
					$result = mysqli_query($con, $query);
				}
			}
			//else 
			//{
				//echo "Incomplete Procedure #: $i data in Case #: $caseId <br />";
				//echo "<a href=\"get_display_case_proc.php?cId=$caseId\">Go back to Case #: $caseId</a>";
			//}
		}
	}
	//header("Location: /lab/get_display_case_proc.php?cId=$caseId");
	header("Location: /lab/search_display_cases.php");
}
if(isset($_POST['submit_add_1']))
{
	# Define variables for saving patient info
	$caseId=$_POST['currentCase_No'];	
	$officeName=$_POST['office_lst'];
	$patientId=$_POST['patient_lst_id'];
	$dentistName=$_POST['dentist_lst'];
	$labId=$_POST['lab_lst'];
	$labInvNo = $_POST['lab_invoice_no_txt'];
	$labInvAmt = $_POST['lab_invoice_am_txt'];
	$paidByPatient = $_POST['paidbypatient'];
	$paidToLab = $_POST['paidtolab'];
	$associateDeduction = $_POST['associatededuction'];
	$associateDeductionUpdDt = $_POST['associatedeductionupddt'];
			
	if (!$officeName || !$patientId || !$dentistName || !$labId ) 
	{
		echo "You have not entered all the required details.<br />"
		."Please go back and try again.";
		exit;
	}
	if (!get_magic_quotes_gpc()) 
	{
		$officeName = addslashes($officeName);
		//$patientId = addslashes($patientId);
		$dentistName = addslashes($dentistName);
		//$labId = addslashes($labId);
		$labInvNo = addslashes($labInvNo);
		//$labInvAmt = addslashes($labInvAmt);
		$paidByPatient = addslashes($paidByPatient);
		$paidToLab = addslashes($paidToLab);
		$associateDeduction = addslashes($associateDeduction);
		$associateDeductionUpdDt = addslashes($associateDeductionUpdDt);
	}
	if ($associateDeduction == 'NO' && empty($associateDeductionUpdDt))
	{
		$query = "update case_tbl set ".
			 "OFFICE_NAME = '{$officeName}', PATIENT_ID = {$patientId}, DOCTOR_NAME = '{$dentistName}', LAB_ID = {$labId}, " .
			 "LAB_INVOICE_NO = {$labInvNo}, LAB_COST = {$labInvAmt}, PAID_BY_PATIENT = '{$paidByPatient}', PAID_TO_LAB = '{$paidToLab}', " .
			 "ASSOCIATE_DEDUCTION = '{$associateDeduction}' " .
			 "where CASE_NUMBER_ID = {$caseId}";
	}
	elseif ($associateDeduction == 'YES' && empty($associateDeductionUpdDt))
	{
		$query = "update case_tbl set ".
			 "OFFICE_NAME = '{$officeName}', PATIENT_ID = {$patientId}, DOCTOR_NAME = '{$dentistName}', LAB_ID = {$labId}, " .
			 "LAB_INVOICE_NO = {$labInvNo}, LAB_COST = {$labInvAmt}, PAID_BY_PATIENT = '{$paidByPatient}', PAID_TO_LAB = '{$paidToLab}', " .
			 "ASSOCIATE_DEDUCTION = '{$associateDeduction}', " .
			 "ASSOCIATE_DEDUCTION_UPD_DT = NOW() " .
			 "where CASE_NUMBER_ID = {$caseId}";
	}
	else 
	{
		$query = "update case_tbl set ".
			 "OFFICE_NAME = '{$officeName}', PATIENT_ID = {$patientId}, DOCTOR_NAME = '{$dentistName}', " .
		     "LAB_ID = {$labId}, LAB_INVOICE_NO = {$labInvNo}, LAB_COST = {$labInvAmt}, " .
		     "PAID_BY_PATIENT = '{$paidByPatient}', " .
			 "PAID_TO_LAB = '{$paidToLab}' " .
			 "where CASE_NUMBER_ID = {$caseId}";
	}
	//echo "$query\n";
	//echo "\n";
	$result = mysqli_query($con, $query);
	
	// Process Procedures ...
	// Get the current count of procedures
	$maxProcs = 15;
	$query_s = "select count(*) as COUNT from case_procedure_tbl where CASE_NUMBER_ID = ${caseId}"; 
	$result_s = mysqli_query($con, $query_s);
	while ($row_s = mysqli_fetch_assoc($result_s)) 
	{
		$procCount = $row_s['COUNT'];
	}
	for ($i = 1; $i <= $maxProcs; $i++)
	{
		if ($i <= $procCount)
		{
			// Doing Update
			$procName = $_POST['procName_' . $i];
			$procType = $_POST['procType_' . $i];
			$procQuadNo = $_POST['procQuadrantNo_' .$i];
			$procToothNo = $_POST['procToothNo_' .$i];
			$query = "update case_procedure_tbl set ".
			         "PROCEDURE_NAME = '{$procName}', PROCEDURE_TYPE = '{$procType}', QUADRANT_NUMBER = {$procQuadNo}, TOOTH_NUMBER = '{$procToothNo}' ".
			         "where CASE_NUMBER_ID = {$caseId} and CASE_PROCEDURE_NO = {$i}";
			 
			// 	" values ({$caseIdLast},{$i},'{$procName}','{$procType}',{$procToothNo})";
			//echo "$query\n";
			$result = mysqli_query($con, $query);
			for ($j = 1; $j <= 3; $j++)
			{
				$procCreateDate = $_POST['procCreateDate' . $j . '_' . $i];
				$procOutLabDate = $_POST['procOutLabDate' . $j . '_' . $i];
				$procFromLabDate = $_POST['procFromLabDate' . $j . '_' . $i];
				$procComments = $_POST['procComments' . $j . '_' . $i];

				$query = "update case_procedure_txn_tbl set ".
						 "PROCEDURE_START_DT = '{$procCreateDate}', PROCEDURE_OUT_TO_LAB_DT = '{$procOutLabDate}', PROCEDURE_BACK_FROM_LAB_DT = '{$procFromLabDate}', PROCEDURE_COMMENT = '{$procComments}' " .
				         "where CASE_NUMBER_ID = {$caseId} and CASE_PROCEDURE_NO = {$i} and PROC_TRANSACTION_ID = {$j}";   
				$result = mysqli_query($con, $query);
			}	
		}
		else	// Process adding new procedures to the case 
		{
			// Doing Update
			$procName = $_POST['procName_' . $i];
			$procType = $_POST['procType_' . $i];
			$procQuadNo = $_POST['procQuadrantNo_' .$i];
			$procToothNo = $_POST['procToothNo_' .$i];
			//if (!empty($procName) || !empty($procType) || !empty($procToothNo))
			if (!empty($procName))
			{
				$query = "insert into case_procedure_tbl(".
			 			 "CASE_NUMBER_ID, CASE_PROCEDURE_NO, PROCEDURE_NAME, PROCEDURE_TYPE, QUADRANT_NUMBER, TOOTH_NUMBER)".
			 			 " values ({$caseId},{$i},'{$procName}','{$procType}','{$procQuadNo}','{$procToothNo}')";
			//echo "$query\n";
				$result = mysqli_query($con, $query);
				for ($j = 1; $j <= 3; $j++)
				{
					$procCreateDate = $_POST['procCreateDate' . $j . '_' . $i];
					$procOutLabDate = $_POST['procOutLabDate' . $j . '_' . $i];
					$procFromLabDate = $_POST['procFromLabDate' . $j . '_' . $i];
					$procComments = $_POST['procComments' . $j . '_' . $i];
					$query = "insert into case_procedure_txn_tbl(".
			 		"CASE_NUMBER_ID, CASE_PROCEDURE_NO, PROC_TRANSACTION_ID, PROCEDURE_START_DT, PROCEDURE_OUT_TO_LAB_DT, PROCEDURE_BACK_FROM_LAB_DT, PROCEDURE_COMMENT)".
			 		" values ({$caseId},{$i},{$j},'{$procCreateDate}','{$procOutLabDate}','{$procFromLabDate}','{$procComments}')";
					//echo "$query";
					$result = mysqli_query($con, $query);
				}
			}
			//else 
			//{
				//echo "Incomplete Procedure #: $i data in Case #: $caseId <br />";
				//echo "<a href=\"get_display_case_proc.php?cId=$caseId\">Go back to Case #: $caseId</a>";
			//}
		}
	}
	header("Location: /lab/get_display_case_proc.php?cId=".$caseId."&eProc=1");
}
?>
