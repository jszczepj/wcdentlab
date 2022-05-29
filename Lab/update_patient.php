<?php 
 	session_start(); 
 	include_once "conn1.php"; 
 	if(isset($_POST['updatePatient']))
 	{
		$patientIdEd = $_POST['patient_Id'];
		$patientFnameEd = $_POST['patient_Fname'];
		$patientLnameEd = $_POST['patient_Lname'];
		$patientPhoneNoEd = $_POST['patient_Phone_No'];
		$patientEmailEd = $_POST['patient_Email'];
		$query = "update patient_tbl set ".
			 "PATIENT_FNAME = '{$patientFnameEd}', PATIENT_LNAME = '{$patientLnameEd}', " .
			 "PATIENT_PHONE_NO = '{$patientPhoneNoEd}', PATIENT_EMAIL_ADDR = '{$patientEmailEd}' " .
			 "where PATIENT_ID = $patientIdEd";
		echo "$query";
		$result = mysqli_query($con, $query);
		header("Location: /lab/edit_patient.php");
	}
?>
