<?php
	session_start(); 
	if (!isset($_SESSION['userName']))
	{
		header("Location: /lab/login.php");
	}
	include_once "conn1.php";
	
	$patientId = $_POST['id']; // Selected Patient Id
	$patientFname = $_POST['fn'];
	$patientLname = $_POST['ln'];
	$patientPhoneNo = $_POST['ph'];
	$patientEmailAddr = $_POST['em'];
		
	//print "Returned $patientId";
	$query = "update patient_tbl set ".
			 "PATIENT_FNAME = '{$patientFname}', PATIENT_LNAME = '{$patientLname}', " .
			 "PATIENT_PHONE_NO = '{$patientPhoneNo}', PATIENT_EMAIL_ADDR = '{$patientEmailAddr}' " .
			 "where PATIENT_ID = $patientId";
	//echo "$query";
    $result = mysqli_query($con, $query);
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";
		echo "<tr>";
			echo "<td style=\"padding-top:20px\"><label for=\"patient_Id\">Patient Id:</label><input type=\"text\" name=\"patient_Id\" id=\"patient_Id\" value=\"$patientId\" readonly><br />";
			echo "<label for=\"patient_Fname\">Patient First Name:</label><input type=\"text\" name=\"patient_Fname\" id=\"patient_Fname\" value=\"$patientFname\"><br />";
			echo "<label for=\"patient_Lname\">Patient Last Name:</label><input type=\"text\" name=\"patient_Lname\" id=\"patient_Lname\" value=\"$patientLname\"><br />";
			echo "<label for=\"patient_Phone_No\">Patient Phone Number:</label><input type=\"text\" name=\"patient_Phone_No\" id=\"patient_Phone_No\" value=\"$patientPhoneNo\"><br />";
        	echo "<label for=\"patient_Email\">Patient Email:</label><input type=\"text\" name=\"patient_Email\" id=\"patient_Email\" value=\"$patientEmailAddr\"><br >";
        	echo "</td>";
        echo "</tr>";
        $date_var = date('jS F Y H:i:s');
        echo "<tr><td>Patient with id: $patientId has been successfuly saved at: $date_var";
    echo "</table>";
?>
