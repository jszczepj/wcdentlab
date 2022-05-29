<?php session_start();
	  if (!isset($_SESSION['userName']))
	  {
	  	header("Location: /lab/login.php");
	  }
	  include_once "conn1.php";
	  include_once "display_procedures_update.php"; 
	  include_once "helper_functions.php";
	  
// Get data from the database to populate update form.
$caseId = $_GET['cId'];
$displayExtraProc = $_GET['eProc'];
$query = "select OFFICE_NAME, PATIENT_ID, DOCTOR_NAME, LAB_ID, LAB_INVOICE_NO, LAB_COST, PAID_BY_PATIENT, PAID_TO_LAB, ASSOCIATE_DEDUCTION, ASSOCIATE_DEDUCTION_UPD_DT".
" from case_tbl where CASE_NUMBER_ID = ". $caseId;
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_assoc($result)) 
{
	$officeSetName = $row['OFFICE_NAME'];
	$patientSetId = $row['PATIENT_ID'];
	$doctorSetName = $row['DOCTOR_NAME'];
	$labSetId = $row['LAB_ID'];
	$labSetInvoiceNo = $row['LAB_INVOICE_NO'];
	$labSetCost = $row['LAB_COST'];
	$paidSetByPatient = $row['PAID_BY_PATIENT'];
	$paidSetToLab = $row['PAID_TO_LAB'];
	$associateSetDeduction = $row['ASSOCIATE_DEDUCTION'];
	$associateSetDeductionUpdDt = $row['ASSOCIATE_DEDUCTION_UPD_DT'];
}
				
?>
<html>
	<head>
		<title>Modify Case</title>
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>
        <!--<link rel="stylesheet" type="text/css" href="mainstyle.css">-->
		<script src="jsfunctions.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="style-jquery-custom.css" />
		<script src="lab-jquery-custom.js"></script>
        <link rel="stylesheet" href="style-mg.css" />
        <style type="text/css">
    	textarea 
    	{
    		resize: none;
		}
	</style>
	<script type="text/javascript">
	var proc_idx = 0;
	function validateForm()
	{
		var maxProc = 15;
		//alert("proc_idx: " + proc_idx);
		if( document.caseData.office_lst.value == "" )
		{
			alert( "Please select Office Name!" );
		    document.caseData.office_lst.focus() ;
		    return false;
		}
		if( document.caseData.patient_lst_id.value == "" )
		{
			alert( "Please select Patient Name!" );
		    document.caseData.patient_lst_id.focus() ;
		    return false;
		}
		if( document.caseData.dentist_lst.value == "" )
		{
			alert( "Please select Doctor's name!" );
		    document.caseData.dentist_lst.focus() ;
		    return false;
		}
		if( document.caseData.lab_lst.value == "" )
		{
			alert( "Please select Lab Name!" );
		    document.caseData.lab_lst.focus() ;
		    return false;
		}
		// Simple Procedure #1 evaluation:
		for (var i = 1;i <= proc_idx;i++)
		{ 
			//alert ('for loop variable i = ' + i);
			var controlProcId = 'proc_' + i;
			var divelem = document.getElementById(controlProcId);
			var controlProcName = 'procName_' + i;
			var procNameElem = document.getElementById(controlProcName);
			var controlProcType = 'procType_' + i;
			var procTypeElem = document.getElementById(controlProcType);
			//var controlToothNo = 'procToothNo_' + i;
			//var procToothNoElem = document.getElementById(controlToothNo);
			//alert ('Div proc_' + i + ' is visilble');
			if( procNameElem.value == "" )
			{
				alert( 'Please select Name for Procedure #' + i );
				procNameElem.focus() ;
		    	return false;
			}
			if( procTypeElem.value == "" )
			{
				alert( 'Please select Type for Procedure #' + i );
				procTypeElem.focus() ;
		    	return false;
			}
			/*if( procToothNoElem.value == "" )
			{
				alert( 'Please select Tooth Number for Procedure #!' + i );
				procToothNoElem.focus() ;
		    	return false;
			}*/
			continue;
		}		
		return( true );
	}
	function hideText(elId)
	{
		document.getElementById(elId).style.display = 'none';
	}
	function setfocustolastproc(procNameId)
	{
		var tbProcNameCtl = 'procName_' + procNameId;
		var tbProcNameId = document.getElementById(tbProcNameCtl);
		tbProcNameId.focus();
		tbProcNameId.scrollIntoView();
	}
	</script>
	</head>
	<body>
<div id="wrapperlarge">
    <div id="search">
    <div align="right"><img src="images/winston-churchill-dental.png" width="220"><img src="images/heritage-house-dental.png" width="300"></div>
     <h1>View / Modify Case</h1>
<p align="right" class="date">Date: <?php echo date('jS F Y'); ?>&nbsp;&nbsp;&nbsp;User Name: <?php echo $_SESSION['userName']; ?>&nbsp;&nbsp;&nbsp;User Role: <?php echo $_SESSION['userRole']; ?></p>
<form action="update_save_case.php" name="caseData" method="post" onsubmit="return (validateForm())">
    <?php display_header();?>
    <div id="newcase">
	<?php echo "<input type=\"hidden\" name=\"currentCase_No\" value=$caseId>";?>
	<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom:10px">
		<tr>
			<td colspan="1" style="background-color:#877c74; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px" >
				<h3>Case #: <?php echo $caseId; ?></h3>
			</td>
			
			<td colspan="1" style="background-color:#877c74; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px" >
				
			</td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td align="left">
				<?php 
					// Initialize Office Name Array
					$officeNameAr = array('Heritage House Dental'
										  ,'Winston Churchill Dental'
										 );
					print "<label for=\"office_lst\">Office Location:</label><select name=\"office_lst\">";
					for ($i = 0; $i < count($officeNameAr); $i++)
					{
						if ($officeNameAr[$i] == $officeSetName)
						{
							print "<option value=\"$officeNameAr[$i]\" selected>$officeNameAr[$i]</option>";
						}
						else 
						{
							print "<option value=\"$officeNameAr[$i]\">$officeNameAr[$i]</option>";
						}
					}
					print "</select>";
				?><br />
			
				<?php
				$query = "select PATIENT_ID, PATIENT_FNAME, PATIENT_LNAME, PATIENT_PHONE_NO from patient_tbl order by PATIENT_LNAME";
				$result = mysqli_query($con, $query);
				print "<label for=\"patient_lst_id\">Patient Name:</label><select name=\"patient_lst_id\" id=\"patient_lst_id\">\n";
				//echo "<option value=''>Select Patient</option>";
				while ($row = mysqli_fetch_assoc($result)) 
				{
					$patientId = $row['PATIENT_ID'];
					$patientFname = $row['PATIENT_FNAME'];
					$patientLname = $row['PATIENT_LNAME'];
					$patientPhoneNo = $row['PATIENT_PHONE_NO'];
					if ($patientSetId == $patientId)
					{
						print "<option value=$patientId selected>$patientLname, $patientFname ($patientPhoneNo)\n";
					}
					else 
					{
						print "<option value=$patientId>$patientLname, $patientFname ($patientPhoneNo)\n";
					}
				}
				echo "</select>";
				?><br />
			
				<?php 
					$doctorNameAr = array('Kate Bazydlo','Daniela Bololoi','Jennifer Holody','Yolanda Li','Nicole Maciel','Fred Diodati');
					print "<label for=\"dentist_lst\">Dentist:</label><select name=\"dentist_lst\">";
					for ($i = 0; $i < count($doctorNameAr); $i++)
					{
						if ($doctorNameAr[$i] == $doctorSetName)
						{
							print "<option value=\"$doctorNameAr[$i]\" selected>Dr. $doctorNameAr[$i]</option>";
						}
						else 
						{
							print "<option value=\"$doctorNameAr[$i]\">Dr. $doctorNameAr[$i]</option>";
						}
					}
					print "</select>";
				?>
			</td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">			
		<tr>
			<td align="left">
				<label for="lab_lst">Laboratory:</label><?php
				$query = "select LAB_ID, LAB_NAME, LAB_CONTACT_FNAME, LAB_CONTACT_LNAME, LAB_PHONE_NO from lab_tbl order by LAB_NAME";
				$result = mysqli_query($con, $query);
					print "<select name=\"lab_lst\">\n";
					while ($row = mysqli_fetch_assoc($result)) 
					{
						$labId = $row['LAB_ID'];
						$labName = $row['LAB_NAME'];
						$labContactFname = $row['LAB_CONTACT_FNAME'];
						$labContactLname = $row['LAB_CONTACT_LNAME'];
						$labPhoneNo = $row['LAB_PHONE_NO'];
						if ($labSetId == $labId)
						{
							print "<option value=$labId selected>$labName\n";
						}
						else
						{
							print "<option value=$labId>$labName\n";
						}
					}
					print "</select>\n";
				?><br />
			 <label for="lab_invoice_no_txt">Lab Invoice Number:</label>
				<?php 
					print "<input type=\"text\" value=$labSetInvoiceNo name=\"lab_invoice_no_txt\" >";
				?><br />
			 <label for="lab_invoice_am_txt">Lab Invoice Amount:</label>
				<?php 
					print "<input type=\"text\" value=$labSetCost name=\"lab_invoice_am_txt\" >";
				?><br />
			</td>
		</tr>
	</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
    	<tr>
			<td><label for="paidbypatient">Paid by Patient:</label>
				<?php 
					$paidByPatientAr = array('NO','YES','PP');
					for ($i = 0; $i < count($paidByPatientAr); $i++)
					{
						if ($paidByPatientAr[$i] === $paidSetByPatient)
						{
							print "<input style=\"width:20px; height:15px\" type=\"radio\" name=\"paidbypatient\" value=$paidByPatientAr[$i] checked=\"checked\">$paidByPatientAr[$i] &nbsp;&nbsp;&nbsp;";
						}
						else 
						{
							print "<input style=\"width:20px; height:15px\" type=\"radio\" name=\"paidbypatient\" value=$paidByPatientAr[$i]>$paidByPatientAr[$i] &nbsp;&nbsp;&nbsp;";
						}
					}
				?><br />
			</tr>
		<?php
			if ($_SESSION['userRole'] === 'admin')
			{
				echo "<label for=\"paidtolab\">Paid To Lab:</label>"; 
				$paidToLabAr = array('NO','YES');
				for ($i = 0; $i < count($paidToLabAr); $i++)
				{
					if ($paidToLabAr[$i] === $paidSetToLab)
					{
						print "<input style=\"width:20px; height:15px\" type=\"radio\" name=\"paidtolab\" value=$paidToLabAr[$i] checked=\"checked\">$paidToLabAr[$i] &nbsp;&nbsp;&nbsp;";
					}
					else 
					{
						print "<input style=\"width:20px; height:15px\" type=\"radio\" name=\"paidtolab\" value=$paidToLabAr[$i]>$paidToLabAr[$i] &nbsp;&nbsp;&nbsp;";
						}
				}
				echo "<br />";
			echo "</td>";
			echo "</td>";	
			echo "<tr>";
				echo "<td>";
				$associateDeductionAr = array('NO','YES');
				for ($i = 0; $i < count($associateDeductionAr); $i++)
				{
					if ($associateDeductionAr[$i] === $associateSetDeduction)
					{
						print "<label for=\"associatededuction\">Associate Deduction:</label><input style=\"width:20px; height:15px\" type=\"radio\" name=\"associatededuction\" value=$associateDeductionAr[$i] checked=\"checked\">$associateDeductionAr[$i] &nbsp;&nbsp;&nbsp;";
					}
					else 
					{
						print "<input style=\"width:20px; height:15px\" type=\"radio\" name=\"associatededuction\" value=$associateDeductionAr[$i]>$associateDeductionAr[$i] &nbsp;&nbsp;&nbsp;";
					}
				}
				echo "&nbsp;&nbsp;&nbsp;";
				print "<input type=\"text\" value=\"$associateSetDeductionUpdDt\" name=\"associatedeductionupddt\" readonly=\"true\" >";
				echo "</tr>";
			}
			echo "<tr>";
			echo "<td align=\"center\">";
            echo "<button style=\"width:150px; height:30px; margin-left:0; margin-right:3\" type=\"submit\" name=\"submit_exit_1\">Save/Exit</button>";
            echo "<button style=\"width:150px; height:30px; margin-left:0\" type=\"button\" name=\"cancel_1\" onclick=\"window.location.href='search_display_cases.php'\">Cancel</button>";
            echo "</td>";
			echo "</tr>"; 
		?>
	</table></div>
    
    <div id="procedures">
		<?php	// Define local variables for procedure transaction records 
		$maxProcs = 15;
		$j = 1;	// Procedure Counter
		$query = "select CASE_PROCEDURE_NO, PROCEDURE_NAME, PROCEDURE_TYPE, QUADRANT_NUMBER, TOOTH_NUMBER".
		" from case_procedure_tbl where CASE_NUMBER_ID = ". $caseId .
		" order by CASE_PROCEDURE_NO";
		$result = mysqli_query($con, $query);
		while ($row = mysqli_fetch_assoc($result)) 
		{
			$procId = $row['CASE_PROCEDURE_NO'];
			$procName = $row['PROCEDURE_NAME'];
			$procType = $row['PROCEDURE_TYPE'];
			$procQuadNo = $row['QUADRANT_NUMBER'];
			$procToothNo = $row['TOOTH_NUMBER'];
			// Process transactions 1
			$query_t = "select PROCEDURE_START_DT, PROCEDURE_OUT_TO_LAB_DT, PROCEDURE_BACK_FROM_LAB_DT, PROCEDURE_COMMENT".
			" from case_procedure_txn_tbl " .
			" where CASE_NUMBER_ID = ". $caseId .
			" and   CASE_PROCEDURE_NO = " . $procId .
			" and   PROC_TRANSACTION_ID = 1";
			//echo "Transaction 1: $query_t\n";
			$result_t = mysqli_query($con, $query_t);
			while ($row_t = mysqli_fetch_assoc($result_t)) 
			{
				$procCreateDt1 = dsp_empty_dt($row_t['PROCEDURE_START_DT']);
				$procOutToLabDt1 = dsp_empty_dt($row_t['PROCEDURE_OUT_TO_LAB_DT']);
				$procFromLabDt1 = dsp_empty_dt($row_t['PROCEDURE_BACK_FROM_LAB_DT']);
				$procComments1 = $row_t['PROCEDURE_COMMENT'];
			}
			$query_t = "select PROCEDURE_START_DT, PROCEDURE_OUT_TO_LAB_DT, PROCEDURE_BACK_FROM_LAB_DT, PROCEDURE_COMMENT".
			" from case_procedure_txn_tbl " .
			" where CASE_NUMBER_ID = ". $caseId .
			" and   CASE_PROCEDURE_NO = " . $procId .
			" and   PROC_TRANSACTION_ID = 2";
			$result_t = mysqli_query($con, $query_t);
			while ($row_t = mysqli_fetch_assoc($result_t)) 
			{
				$procCreateDt2 = dsp_empty_dt($row_t['PROCEDURE_START_DT']);
				$procOutToLabDt2 = dsp_empty_dt($row_t['PROCEDURE_OUT_TO_LAB_DT']);
				$procFromLabDt2 = dsp_empty_dt($row_t['PROCEDURE_BACK_FROM_LAB_DT']);
				$procComments2 = $row_t['PROCEDURE_COMMENT'];
			}
			$query_t = "select PROCEDURE_START_DT, PROCEDURE_OUT_TO_LAB_DT, PROCEDURE_BACK_FROM_LAB_DT, PROCEDURE_COMMENT".
			" from case_procedure_txn_tbl " .
			" where CASE_NUMBER_ID = ". $caseId .
			" and   CASE_PROCEDURE_NO = " . $procId .
			" and   PROC_TRANSACTION_ID = 3";
			$result_t = mysqli_query($con, $query_t);
			while ($row_t = mysqli_fetch_assoc($result_t)) 
			{
				$procCreateDt3 = dsp_empty_dt($row_t['PROCEDURE_START_DT']);
				$procOutToLabDt3 = dsp_empty_dt($row_t['PROCEDURE_OUT_TO_LAB_DT']);
				$procFromLabDt3 = dsp_empty_dt($row_t['PROCEDURE_BACK_FROM_LAB_DT']);
				$procComments3 = $row_t['PROCEDURE_COMMENT'];
			}
			$nextId = $j + 1;
			echo "<div id=\"proc_$j\" name=\"proc_$j\" style=\"padding:5px;display:table;display:inline\">";
			display_proc_form_update($procId,$procName,$procType,$procQuadNo,$procToothNo,$procCreateDt1,$procOutToLabDt1,$procFromLabDt1,$procComments1,$procCreateDt2,$procOutToLabDt2,$procFromLabDt2,$procComments2,$procCreateDt3,$procOutToLabDt3,$procFromLabDt3,$procComments3);
			echo "</div>";
			$j = $nextId;
		}
		echo "<br>";
		echo "<script>";
		?>
		proc_idx = <?php echo json_encode($j - 1); ?>;
		<?php 
		echo "</script>";
		if($displayExtraProc == 1)
		{
			echo "<div id=\"proc_$j\" name=\"proc_$j\" style=\"padding:5px;display:table;display:inline\">";
			display_proc_form($j);
			echo "</div>";
			echo "<script>";
			?>
			proc_idx = <?php echo json_encode($j); ?>;
			setfocustolastproc(<?php echo json_encode($j); ?>);
			<?php 
			echo "</script>";
		}
?>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="2">	
    	<tr>
			<td align="center">
				<button style="width:250px; height:30px; margin-left:0" type="submit" name="submit_add_1">Save/Add Next Procedure</button>
                <button style="width:150px; height:30px; margin-left:0" type="submit" name="submit_exit_2">Save/Exit</button>
                <button style="width:150px; height:30px; margin-left:0" type="button" name="cancel_2" onclick="window.location.href='search_display_cases.php'">Cancel</button>
             </td>
		</tr>
	</table>	
</form>
</div>
</div>
</body>
</html>
