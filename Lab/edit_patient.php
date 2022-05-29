<?php session_start(); 
	  if (!isset($_SESSION['userName']))
	  {
	  	header("Location: /lab/login.php");
	  }
	  include_once "conn1.php";
	  include_once "helper_functions.php";
?>
<html>
	<head>
		<title>Edit Patient</title>
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>
        <!--<link rel="stylesheet" type="text/css" href="mainstyle.css">-->
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script type="text/javascript" src="jquery-1.10.2.js"></script>
		<script type="text/javascript" src="jquery-ui-1.10.4.js"></script>
		<script type="text/javascript" src="jquery.maskedinput.js"></script>
		<script type="text/javascript">$(document).ready(function() {$("input#patient_Phone_No").mask("999-999-9999");});</script>
        <link rel="stylesheet" href="style-mg.css" />
        <!-- script type="text/javascript" src="lab/jquery-1.4.2.min.js"></script -->
        <script src="http://code.jquery.com/jquery-latest.js"></script>
		<script type="text/javascript">
		function getdetails(){
			var selPatientId = $("#patient_lst_id option:selected").val();
			$.ajax({
			type: "POST",
			url: "getPatientDetail.php",
			data: {id:selPatientId}
			}).done(function( result ) {
			$("#patientDetail").html( result );
			});
			document.getElementById("updatePatient").disabled = false;
		}
		function upddetails(){
			var updPatientId = $("#patient_lst_id option:selected").val();
			var updPatientFName = $("#patient_Fname").val();
			var updPatientLName = $("#patient_Lname").val();
			var updPatientPhoneNo = $("#patient_Phone_No").val();
			var updPatientEmailAddr = $("#patient_Email").val();
			$.ajax({
			type: "POST",
			url: "updPatientDetail.php",
			data: {
				id:updPatientId,
				fn:updPatientFName,
				ln:updPatientLName,
				ph:updPatientPhoneNo,
				em:updPatientEmailAddr
			}
			}).done(function( result ) {
			$("#patientDetail").html( result );
			});
		}
    </script>
	</head>
<body>
<div id="wrapperlarge">
    <div id="newcase">
    <div align="right"><img src="images/winston-churchill-dental.png" width="220"><img src="images/heritage-house-dental.png" width="300"></div>
     <h1>Edit Patient</h1>
<p align="right" class="date">Date: <?php echo date('jS F Y'); ?>&nbsp;&nbsp;&nbsp;User Name: <?php echo $_SESSION['userName']; ?>&nbsp;&nbsp;&nbsp;User Role: <?php echo $_SESSION['userRole']; ?></p>
<?php display_header();?>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td style="background-color:#877c74; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px" >
				<h3>Edit Patient</h3>
			</td>
		</tr>
		<tr>
			<td>
			<?php
				$query = "select PATIENT_ID, PATIENT_FNAME, PATIENT_LNAME, PATIENT_PHONE_NO, PATIENT_EMAIL_ADDR from patient_tbl order by PATIENT_LNAME";
				$result = mysqli_query($con, $query);
				print "<br />";
				print "<label for=\"patient_lst_id\">Edit Patient:</label><select name=\"patient_lst_id\" id=\"patient_lst_id\" onchange=\"getdetails()\">\n";
				echo "<option value=''>Select Patient</option>";
				while ($row = mysqli_fetch_assoc($result)) 
				{
					$patientId = $row['PATIENT_ID'];
					$patientFname = $row['PATIENT_FNAME'];
					$patientLname = $row['PATIENT_LNAME'];
					$patientPhoneNo = $row['PATIENT_PHONE_NO'];
					print "<option value=$patientId>$patientLname, $patientFname ($patientPhoneNo)\n";
				}
				echo "</select>";
			?>
			</td>
		</tr>	
	</table>
	<!-- form onSubmit="upddetails()" name="editPatient" id="editPatient" method="post" -->
	<div id="patientDetail"></div>
	<button type="button" style="width:200px; height:45px" name="updatePatient" id="updatePatient" onclick="upddetails()" disabled>SAVE PATIENT</button>
	<!-- /form -->
	</div>
 </div>
 </body>
</html>
	
