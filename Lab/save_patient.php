<?php include_once "conn1.php"; ?>
<?php
	//session_start();
	# Define variables for saving patient info
	$patientFname=$_POST['patient_Fname'];
	$patientLname=$_POST['patient_Lname'];
	$patientPhoneNo=$_POST['patient_Phone_No'];
	// $patientEmail=$_POST['patient_Email'];
		
	// if (!$patientFname || !$patientLname || !$patientPhoneNo || !$patientEmail ) 
	if (!$patientFname || !$patientLname || !$patientPhoneNo)
	{
		echo "You have not entered all the required details.<br />"
		."Please go back and try again.";
		exit;
	}
	// if (!get_magic_quotes_gpc()) {
	$patientFname = addslashes($patientFname);
	$patientLname = addslashes($patientLname);
	$patientPhoneNo = addslashes($patientPhoneNo);
	// $patientEmail = addslashes($patientEmail);
	//}
	
	$query = "insert into patient_tbl(".
			 "PATIENT_FNAME, PATIENT_LNAME, PATIENT_PHONE_NO, PATIENT_CREATE_DT)".
			 " values ('{$patientFname}','{$patientLname}','{$patientPhoneNo}',sysdate())";
	
	// Get the generated ID for just inserted record
	$result = mysqli_query($con, $query);
	$query1 = "select LAST_INSERT_ID() as PATIENT_ID";
	$result = mysqli_query($con, $query1);
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$patientIdLast = $row['PATIENT_ID'];
	}
	//$_SESSION['se_patId'] = $patientIdLast;
	//session_write_close();
	//echo "Session Parameter: " . $_SESSION['se_patId'];
	//echo "Session Parameter: " . $patientIdLast;
	include "add_case_dyn_proc.php";
?>
