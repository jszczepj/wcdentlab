<html>
<head>
<script type="text/javascript" src="jquery-1.10.2.js"></script>
<script type="text/javascript" src="jquery-ui-1.10.4.js"></script>
<script type="text/javascript" src="jquery.maskedinput.js"></script>
<script type="text/javascript">$(document).ready(function() {$("input#patient_Phone_No").mask("999-999-9999");});</script>
</head>
<body>
<?php
	session_start();
	if (!isset($_SESSION['userName']))
	{
		header("Location: /lab/login.php");
	}
	include_once "conn1.php";
	$patientId = $_POST['id']; // Selected Patient Id
	//print "Returned $patientId";
	$query  = "select PATIENT_FNAME, PATIENT_LNAME, PATIENT_PHONE_NO, PATIENT_EMAIL_ADDR from patient_tbl where PATIENT_ID = $patientId";
	$result = mysqli_query($con, $query);
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$patientFname = $row['PATIENT_FNAME'];
		$patientLname = $row['PATIENT_LNAME'];
		$patientPhoneNo = $row['PATIENT_PHONE_NO'];
		$patientEmailAddr = $row['PATIENT_EMAIL_ADDR'];
	}
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";
		echo "<tr>";
			echo "<td style=\"padding-top:20px\"><label for=\"patient_Id\">Patient Id:</label><input type=\"text\" name=\"patient_Id\" id=\"patient_Id\" value=\"$patientId\" readonly><br />";
			echo "<label for=\"patient_Fname\">Patient First Name:</label><input type=\"text\" name=\"patient_Fname\" id=\"patient_Fname\" value=\"$patientFname\"><br />";
			echo "<label for=\"patient_Lname\">Patient Last Name:</label><input type=\"text\" name=\"patient_Lname\" id=\"patient_Lname\" value=\"$patientLname\"><br />";
			echo "<label for=\"patient_Phone_No\">Patient Phone Number:</label><input type=\"text\" name=\"patient_Phone_No\" id=\"patient_Phone_No\" value=\"$patientPhoneNo\"><br />";
        	echo "<label for=\"patient_Email\">Patient Email:</label><input type=\"text\" name=\"patient_Email\" id=\"patient_Email\" value=\"$patientEmailAddr\"><br >";
        	echo "</td>";
        echo "</tr>";
    echo "</table>";
?>
</body>
</html>
