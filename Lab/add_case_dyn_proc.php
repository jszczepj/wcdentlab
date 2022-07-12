<?php session_start(); 
	  if (!isset($_SESSION['userName']))
	  {
	  	header("Location: /lab/login.php");
	  }
?>
<html>
<?php include_once "conn1.php"; 
	  include_once "display_procedures_update.php"; 
	  include_once "helper_functions.php";
?>
	<head>
		<title>Enter New Case</title>
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css' />
        <!---->
		<script src="jsfunctions.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="style-jquery-custom.css" />
		<script src="lab-jquery-custom.js"></script>
		<script type="text/javascript">
		var proc_idx = 1;
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
				continue;
			}		
			return( true );
		}
		function hideText(elId)
		{
			document.getElementById(elId).style.display = 'none';
		}
		</script>
		<link rel="stylesheet" href="style-mg.css" />
			<script>
		function setFocus()
		{
			document.getElementById("office_lst").focus();
		}
		</script>
	</head>
	<body onload="setFocus()">
    <div id="wrapperlarge">
    <div id="search">
	<div align="right"><img src="images/winston-churchill-dental.png" width="220"><img src="images/heritage-house-dental.png" width="300"><img src="images/smiles-on-essa-dental.png" width="300"></div>
    <h1>Enter New Case</h1>
<p align="right" class="date">Date: <?php echo date('jS F Y'); ?>&nbsp;&nbsp;&nbsp;User Name: <?php echo $_SESSION['userName']; ?>&nbsp;&nbsp;&nbsp;User Role: <?php echo $_SESSION['userRole']; ?></p>
	<form action="save_case.php" name="caseData" method="post" onsubmit="return (validateForm())">
    <!-- form action="php echo htmlspecialchars($_SERVER["PHP_SELF"]);" name="caseData" method="post" onsubmit="return (validateForm())"-->
    <?php display_header();?>
	<div id="newcase">
    <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom:10px">
		<tr>
			<td colspan="2" style="background-color:#877c74; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px" >
				<h3>Enter New Case</h3>
			</td>
			
			<td colspan="2" style="background-color:#877c74; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px" >
				
			</td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	
		<tr>
			<td align="left">
				<label for="office_lst" style="width: 135px; height: 30px vertical-align: middle; margin-left: 15px">Office Location:</label>
				<?php $officeNameAr = array('Heritage House Dental','Winston Churchill Dental');?>
				<select name="office_lst" id="office_lst" style="width: 250px; height: 30px">
					<option value=''>Select Dental Office</option>
					<option value="Winston Churchill Dental">Winston Churchill Dental</option>
					<option value="Heritage House Dental">Heritage House Dental</option>
				</select>
			</td>
			<td align="left">			
				<?php
			    $query = "select PATIENT_ID, PATIENT_FNAME, PATIENT_LNAME, PATIENT_PHONE_NO from patient_tbl order by PATIENT_LNAME";
				$result = mysqli_query($con, $query);
				print "<label for=\"patient_lst_id\" style=\"width: 134px; height: 30px vertical-align: middle; margin-left: 15px\">Patient Name:</label><select name=\"patient_lst_id\" id=\"patient_lst_id\" style=\"width: 250px; height: 30px\">";
				echo "<option value=''>Select Patient</option>";
				while ($row = mysqli_fetch_assoc($result)) 
				{
					$patientId = $row['PATIENT_ID'];
					$patientFname = $row['PATIENT_FNAME'];
					$patientLname = $row['PATIENT_LNAME'];
					$patientPhoneNo = $row['PATIENT_PHONE_NO'];
					print "<option value=$patientId>$patientLname, $patientFname ($patientPhoneNo)</option>\n";
				}
				echo "</select>";
				?><!--a href="add_patient.php">Add Patient</a-->
			</td>
		</tr>
		<tr>
			<td align="left">	
				<label for="dentist_lst" style="width: 135px; height: 30px; vertical-align: middle; margin-left: 15px">Dentist:</label><select name="dentist_lst" style="width: 250px; height: 30px">
					<option value=''>Select Dentist</option>
					<option value="Kate Bazydlo">Dr. Kate Bazydlo</option>
					<option value="Daniela Bololoi">Dr. Daniela Bololoi</option>
					<option value="Jennifer Holody">Dr. Jennifer Holody</option>
					<option value="Yolanda Li">Dr. Yolanda Li</option>
					<option value="Nicole Maciel">Dr. Nicole Maciel</option>
					<option value="Fred Diodati">Dr. Fred Diodati</option>
				</select>
			</td>
			<td align="left">
				<?php
				$query = "select LAB_ID, LAB_NAME, LAB_CONTACT_FNAME, LAB_CONTACT_LNAME, LAB_PHONE_NO from lab_tbl order by LAB_NAME";
				$result = mysqli_query($con, $query);
					print "<label for=\"lab_lst\" style=\"width: 135px; height: 30px; vertical-align: middle; margin-left: 15px\">Laboratory:</label><select name=\"lab_lst\" style=\"width: 250px; height: 30px\">\n";
					echo "<option value=''>Select Laboratory</option>";
					while ($row = mysqli_fetch_assoc($result)) 
					{
						$labId = $row['LAB_ID'];
						$labName = $row['LAB_NAME'];
						$labContactFname = $row['LAB_CONTACT_FNAME'];
						$labContactLname = $row['LAB_CONTACT_LNAME'];
						$labPhoneNo = $row['LAB_PHONE_NO'];
						print "<option value=$labId>$labName</option>\n";
					}
					print "</select>\n";
				?>
			</td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">			
		<tr>
			<td align="left"><label for="lab_invoice_no_txt" style="width: 135px; height: 30px; vertical-align: middle; margin-left: 15px">Lab Invoice Number: </label>
			<input type="text" value="0" name="lab_invoice_no_txt" style="width: 250px; height: 30px"></td>
			<td align="left"><label for="lab_invoice_am_txt" style="width: 135px; height: 30px; vertical-align: middle; margin-left: 15px">Lab Invoice Amount:</label>
			<input type="text" value="0.00" name="lab_invoice_am_txt" style="width: 250px; height: 30px"></td>
		</tr>
	</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="2">	
        <tr>
			
			<td> 
				<label for="paidbypatient" style="width: 180px; height: 30px; vertical-align: middle; margin-left: 15px">Paid by Patient:</label>
				<input style="width:20px; height:15px" type="radio" name="paidbypatient" value="NO" checked="checked">NO &nbsp;&nbsp;&nbsp;
				<input style="width:20px; height:15px" type="radio" name="paidbypatient" value="YES">YES&nbsp;&nbsp;&nbsp;
				<input style="width:20px; height:15px" type="radio" name="paidbypatient" value="PP">PP&nbsp;&nbsp;&nbsp;
			</td>
			<td align="center">
                <button style="width:150px; height:30px; margin-left:0" type="submit" name="submit_exit_1">Save</button>
                <button style="width:150px; height:30px; margin-left:0" type="button" name="cancel_1" onclick="window.location.href='search_display_cases.php'">Cancel</button>
             </td>
		</tr>
	</table>
</div>
<div id="procedures">
		<?php 
			$maxProcs = 15;
			for ($i = 1; $i <= $maxProcs; $i++)
			{
				if($i == 1)
				{
					$nextId = $i + 1;
					echo "<div id=\"proc_$i\" name=\"proc_$i\" style=\"padding-bottom:10px;display:table;display:inline\">";
					display_proc_form($i);
					echo "<br>";
					//echo "<script>";
					//echo "\$(document).ready(function(){\$(\"#show_proc_$i\").click(function(){\$(\"#proc_$nextId\").show();\$(\"#show_proc_$i\").hide();});});";
					//echo "</script>";
					//echo "<button style=\"margin-left:0; height:30px\" type=\"button\" name=\"show_proc_$i\" id=\"show_proc_$i\" onclick=\"proc_idx++\">Add Next Procedure</button>&nbsp;&nbsp;&nbsp;";
//					echo "<button style=\"width:330px; height:20px\" type=\"button\" name=\"hide_proc_$i\" onClick=\"hideNextProc($nextId)\">Hide Next Procedure</button>";
					echo "</div>";
				}
				else 
				{
					$nextId = $i + 1;
					echo "<div id=\"proc_$i\" name=\"proc_$i\" style=\"padding-bottom:10px;display:table;display:none\">";
					display_proc_form($i);
					if($nextId <= $maxProcs)
					{
						//echo "<script>";
						//echo "\$(document).ready(function(){\$(\"#show_proc_$i\").click(function(){\$(\"#proc_$nextId\").show();\$(\"#show_proc_$i\").hide();});});";
						//echo "</script>";
						//echo "<button style=\"margin-left:0; height:30px\" type=\"button\" name=\"show_proc_$i\" id=\"show_proc_$i\" onclick=\"proc_idx++\">Add Next Procedure</button>&nbsp;&nbsp;&nbsp;";
//					echo "<button style=\"width:330px; height:20px\" type=\"button\" name=\"hide_proc_$i\" onClick=\"hideNextProc($nextId)\">Hide Next Procedure</button>";
						echo "<br>";
						echo "</div>";
					}
					else 
					{
						echo "</div>";
					}
				}
			}
			?>
</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">	
    	<tr>
			<td align="center">
				<button style="width:250px; height:30px; margin-left:0" type="submit" name="submit_add_1">Save/Add Next Procedure</button>
                <button style="width:150px; height:30px; margin-left:0" type="submit" name="submit_exit_2">Save</button>
                <button style="width:150px; height:30px; margin-left:0" type="button" name="cancel_2" onclick="window.location.href='search_display_cases.php'">Cancel</button>
             </td>
		</tr>
	</table>	
</form>
</div>
</div>
</body>
</html>
