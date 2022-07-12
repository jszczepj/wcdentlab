<?php session_start(); 
	  if (!isset($_SESSION['userName']))
 	  {
	  	header("Location: /lab/login.php");
	  }
	  include_once "helper_functions.php";
?>
<html>
	<head>
		<title>Enter New Patient</title>
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>
        <!--<link rel="stylesheet" type="text/css" href="mainstyle.css">-->
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script type="text/javascript" src="jquery-1.10.2.js"></script>
		<script type="text/javascript" src="jquery-ui-1.10.4.js"></script>
		<script type="text/javascript" src="jquery.maskedinput.js"></script>
		<script type="text/javascript" src="jquery.validate.js"></script>
		<!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
        <link rel="stylesheet" href="style-mg.css" />
        <script type="text/javascript">$(document).ready(function() {$("input#patient_Phone_No").mask("999-999-9999");});</script>
        		<script type="text/javascript">
		 $(function() {$("#addPatient").validate({
    	    rules: {patient_Email: {required: false, email: true}},
        	messages: {patient_Email: "Please enter a valid email address"},
        	submitHandler: 
         function(form) {
            form.submit();
        }
    });

  });
  </script>
	</head>
<body>
<div id="wrapperlarge">
    <div id="newcase">
    <div align="right"><img src="images/winston-churchill-dental.png" width="220"><img src="images/heritage-house-dental.png" width="300"><img src="images/smiles-on-essa-dental.png" width="300"></div>
     <h1>Enter New Patient</h1>
<p align="right" class="date">Date: <?php echo date('jS F Y'); ?>&nbsp;&nbsp;&nbsp;User Name: <?php echo $_SESSION['userName']; ?>&nbsp;&nbsp;&nbsp;User Role: <?php echo $_SESSION['userRole']; ?></p>

	<form action="save_patient.php" name="addPatient" id="addPatient" method="post">
        <?php display_header();?>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td style="background-color:#877c74; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px" >
				<h3>Enter New Patient</h3>
			</td>
			
		</tr>
		<tr>
			<td style="padding-top:20px"><label for="patient_Fname">Patient First Name:</label><input type="text" name="patient_Fname" value=""><br />
		<label for="patient_Lname">Patient Last Name:</label><input type="text" name="patient_Lname" value=""><br />
		<label for="patient_Phone_No">Patient Phone Number:</label><input type="text" name="patient_Phone_No" id="patient_Phone_No" value=""><br />
        <!-- label for="patient_Email">Patient Email:</label><input type="text" name="patient_Email" id="patient_Email" value=""><br -->
        <button type="submit" style="width:200px; height:30px" name="submitPatient">SAVE PATIENT</button>
        </td>
        </tr>
	</table>
	</form>
 	</div>
 </div>
	</body>
</html>
	
