<?php session_start();
 	  if (!isset($_SESSION['userName']))
 	  {
	  	header("Location: /lab/login.php");
	  }
	  ob_start();
      include_once "conn1.php";
 	  include_once "helper_functions.php";
 	  include_once "display_cases.php";
?>
<html>
	<head>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>
		<!--<link rel="stylesheet" type="text/css" href="mainstyle.css">-->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="style-jquery-custom.css" />
		<script src="lab-jquery-custom.js"></script >
        <link rel="stylesheet" href="style-mg.css" />
		<title>Search Cases</title>
		<script>
		function setFocus()
		{
			document.getElementById("caseIdSc").focus();
		}
		</script>
	</head>
	<body onload="setFocus()">
    <div id="wrapperlarge">
<div id="search">
<div align="right"><img src="images/winston-churchill-dental.png" width="220"><img src="images/heritage-house-dental.png" width="300"><img src="images/smiles-on-essa-dental.png" width="300"></div>
<h1>Search Case</h1>
<p align="right" class="date">Date: <?php echo date('jS F Y'); ?>&nbsp;&nbsp;&nbsp;User Name: <?php echo $_SESSION['userName']; ?>&nbsp;&nbsp;&nbsp;User Role: <?php echo $_SESSION['userRole']; ?>
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" name="searchData" method="post" id="searchData">
	<?php 
//	if(!isset($_POST['caseIdSc']))
//	{
	display_header();
//	}
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td colspan="1" style="background-color:#877c74; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px" >
				<h3>Search Case</h3>
			</td>
			
		</tr>
        <tr>
        <td>&nbsp;</td>
        </tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="15%">
				<label for="caseIdSc" style="width: 50px; height: 30px; vertical-align: middle; margin-left: 5px">Case Id:</label><input type="text" value="" name="caseIdSc" id="caseIdSc" style="width:50px; height:30px">
			</td>
			<td width="30%">
				<?php
			    	$query = "select PATIENT_ID, PATIENT_FNAME, PATIENT_LNAME, PATIENT_PHONE_NO from patient_tbl order by PATIENT_LNAME";
					$result = mysqli_query($con, $query);
					echo "<label for=\"patient_lst_id\" style=\"width: 75px; height: 30px; vertical-align: middle; margin-left: 5px\">Patient:</label><select name=\"patient_lst_id\" id=\"patient_lst_id\">\n";
					echo "<option value='' selected>Filter Patient</option>";
					while ($row = mysqli_fetch_assoc($result)) 
					{
						$patientId = $row['PATIENT_ID'];
						$patientFname = $row['PATIENT_FNAME'];
						$patientLname = $row['PATIENT_LNAME'];
						$patientPhoneNo = $row['PATIENT_PHONE_NO'];
						if (!empty($_POST['patient_lst_id']))
						{
							if ($patientId === $_POST['patient_lst_id'])
							{
								echo "<option value=$patientId selected>$patientLname, $patientFname ($patientPhoneNo)</option>\n";
							}
							else 
							{
								echo "<option value=$patientId>$patientLname, $patientFname ($patientPhoneNo)</option>\n";
							}
						}
						else 
						{
							echo "<option value=$patientId>$patientLname, $patientFname ($patientPhoneNo)</option>\n";
						}
					}
					echo "</select>";
					?>
			</td>
			<td width="30%">
				<label for="dentist_lst" style="width: 100px; height: 30px; vertical-align: middle; margin-left: 5px">Dentist:</label>
				<?php 
					$doctorNameAr = array('Kate Bazydlo','Daniela Bololoi','Jennifer Holody','Yolanda Li','Nicole Maciel','Fred Diodati');
					if (!empty($_POST['office_lst']))
					{
						$postedDoctorName = $_POST['dentist_lst'];
						echo "<select name=\"dentist_lst\" style=\"width: 175px; height: 30px\">";
						echo "<option value=''>Filter Doctor's Name</option>";
						for ($i = 0; $i < count($doctorNameAr); $i++)
						{
							if ($doctorNameAr[$i] === $postedDoctorName)
							{
								echo "<option value=\"$postedDoctorName\" selected >$postedDoctorName</option>";
							}
							else 
							{
								echo "<option value=\"$doctorNameAr[$i]\" >$doctorNameAr[$i]</option>";
							}
						}
						echo "</select>";
					}
					else 
					{
						echo "<select name=\"dentist_lst\" style=\"width: 175px; height: 30px\">";
						echo "<option value='' selected>Filter Doctor's Name</option>";
						for ($i = 0; $i < count($doctorNameAr); $i++)
						{
							echo "<option value=\"$doctorNameAr[$i]\">Dr. $doctorNameAr[$i]</option>";
						}
						echo "</select>";
					}
				?>	
			</td>
			<td width="25%">
			<label for="office_lst" style="width: 50px; height: 30px; vertical-align: middle; margin-left: 5px">Office:</label>
				<?php 
				// Initialize Office Name Array
					$officeNameAr = array('Heritage House Dental','Winston Churchill Dental');
					if (!empty($_POST['office_lst']))
					{
						$postedOfficeName = $_POST['office_lst'];
						echo "<select name=\"office_lst\" style=\"width: 175px; height: 30px\">";
						echo "<option value=''>Filter Dental Office</option>";
						for ($i = 0; $i < count($officeNameAr); $i++)
						{
							if ($officeNameAr[$i] === $postedOfficeName)
							{
								echo "<option value=\"$postedOfficeName\" selected >$postedOfficeName</option>";
							}
							else 
							{
								echo "<option value=\"$officeNameAr[$i]\" >$officeNameAr[$i]</option>";
							}
						}
						echo "</select>";
					}
					else 
					{
						echo "<select name=\"office_lst\" style=\"width: 175px; height: 30px\">";
						echo "<option value='' selected>Filter Dental Office</option>";
						for ($i = 0; $i < count($officeNameAr); $i++)
						{
							echo "<option value=\"$officeNameAr[$i]\">$officeNameAr[$i]</option>";
						}
						echo "</select>";
					}
				?>
			</td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">	
		<tr>
			<td width="35%">
				<label for="lab_lst" style="width: 75px; height: 30px; vertical-align: middle; margin-left: 5px">Laboratory:</label>
				<?php
				$query = "select LAB_ID, LAB_NAME, LAB_CONTACT_FNAME, LAB_CONTACT_LNAME, LAB_PHONE_NO from lab_tbl order by LAB_NAME";
				$result = mysqli_query($con, $query);
					print "<select name=\"lab_lst\" style=\"width: 175px; height: 30px\">\n";
					echo "<option value='' selected>Filter Dental Lab Name</option>";
					while ($row = mysqli_fetch_assoc($result)) 
					{
						$labId = $row['LAB_ID'];
						$labName = $row['LAB_NAME'];
						$labContactFname = $row['LAB_CONTACT_FNAME'];
						$labContactLname = $row['LAB_CONTACT_LNAME'];
						$labPhoneNo = $row['LAB_PHONE_NO'];
						if (!empty($_POST['lab_lst']))
						{
							if ($labId === $_POST['lab_lst'])
							{
								echo "<option value=$labId selected>$labName\n";
							}
							else 
							{
								echo "<option value=$labId>$labName\n";
							}
						}
						else 
						{
							echo "<option value=$labId>$labName\n";
						}
					}
					echo "</select>\n";
				?>
				</td>
			<td width="35%">
				<label for="caseCreateDate" style="width: 125px; height: 30px; vertical-align: middle; margin-left: 5px">Case Create Dt (>=):</label>
				<input type="text" style="width: 125px; height: 30px" value="<?php echo htmlentities($_POST['caseCreateDate']);?>" name="caseCreateDate" id="caseCreateDate">
				<script>$(function() {$( "#caseCreateDate" ).datepicker({ dateFormat: 'yy-mm-dd' });});
				</script>
            </td>
			<td width="30%">
				<button style="width:150px; height:30px" type="submit" name="submitFilter2">SEARCH</button>
			</td>
		</tr>
	</table>
	<!--table>     
    	<tr>
			<td colspan="5">
				<button style="width:150px; height:30px" type="submit" name="submitFilter2">SEARCH</button>
			</td>
		</tr>
	</table-->
	<table>     
    	<tr>
			<td colspan="5">
				&nbsp;
			</td>
		</tr>
	</table>
	</form>
	<table width="100%" border="0" cellspacing="0" cellpadding="2" id="casedisplay">
		<tr>
			<td width="10%" align="center" style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px"><h4>Case #</h4>
			</td>
			<td width="20%" style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px"><h4>Patient Name</h4>
			</td>
			<td width="20%" style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px"><h4>Doctor Name</h4>
			</td>
			<td width="20%" style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px"><h4>Dental Lab Name</h4>
			</td>
			<td width="15%" style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px"><h4>Case Status</h4>
			</td>
			<td width="15%" style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px"><h4>Case Open Date</h4>
			</td>
		</tr>
    	<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	<?php 
		if((isset($_POST['submitFilter1'])) or (isset($_POST['submitFilter2'])))
		{
			echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"2\" id=\"casedisplay\" style=\"border: 1px solid black; border-spacing: 15px; margin-bottom: 5px\">";
			$caseIdSearch = $_POST['caseIdSc'];
			$officeNameSearch = $_POST['office_lst'];
			$patientIdSearch = $_POST['patient_lst_id'];
			$doctorNameSearch = $_POST['dentist_lst'];
			$labIdSearch = $_POST['lab_lst'];
			$caseOpenDtSearch = $_POST['caseCreateDate'];
			//echo "CaseIDSearch: $caseIdSearch \n";
			// Build Where clause
			if (!empty($caseIdSearch)) 
			{
				//echo "I'm inside the if statement:";
				// Verify if caseId is present...
				$query1 = "select max(CASE_NUMBER_ID) as CASE_NUMBER_ID from case_tbl";
				$result = mysqli_query($con, $query1);
				while ($row = mysqli_fetch_assoc($result)) 
				{
					$caseMaxId = $row['CASE_NUMBER_ID'];
					echo "Max Case Number: $caseMaxId";
					if ($caseIdSearch <= $caseMaxId)
					{
						//echo "I'm inside of another if statement";
						header("Location: /lab/get_display_case_proc.php?cId=$caseIdSearch");
						//include "/get_display_case_proc.php?cId=$caseIdSearch";
						//echo "Header is not being called";
						exit();
					}
					else 
					{
						echo "The CASE ID: $caseIdSearch does not exist ...";
					}
				}
			}
			else 
			{
				$filterWhereClause = "";
				if(!empty($officeNameSearch))
				{
					$officeNameWC = "AND C.OFFICE_NAME = '" . $officeNameSearch ."' ";
					$filterWhereClause = $filterWhereClause . $officeNameWC;
				}
				if(!empty($patientIdSearch))
				{
					$patientIdWC = "AND C.PATIENT_ID = " . $patientIdSearch . " ";
					$filterWhereClause = $filterWhereClause . $patientIdWC;
				}
				if(!empty($doctorNameSearch))
				{
					$doctorNameWC = "AND C.DOCTOR_NAME = '" . $doctorNameSearch ."'";
					$filterWhereClause = $filterWhereClause . $doctorNameWC;
				}
				if(!empty($labIdSearch))
				{
					$labIdWC = "AND C.LAB_ID = " . $labIdSearch . " ";
					$filterWhereClause = $filterWhereClause . $labIdWC;
				}
				if(!empty($caseOpenDtSearch))
				{
					$caseOpenDtWC = "AND C.CASE_OPEN_DT >= '" . $caseOpenDtSearch ."' ";
					$filterWhereClause = $filterWhereClause . $caseOpenDtWC;
				}
				// $query = "SELECT C.CASE_NUMBER_ID, P.PATIENT_FNAME, P.PATIENT_LNAME, C.DOCTOR_NAME, L.LAB_NAME, C.OFFICE_NAME, C.CASE_OPEN_DT  " .
				$query = "SELECT C.CASE_NUMBER_ID, P.PATIENT_FNAME, P.PATIENT_LNAME, C.DOCTOR_NAME, L.LAB_NAME, C.OFFICE_NAME, S.CASE_STATUS_DESC, C.CASE_OPEN_DT " .
		 		"FROM case_tbl C, patient_tbl P, lab_tbl L, case_status_tbl S " .
		 		"WHERE C.PATIENT_ID = P.PATIENT_ID " .
				"AND   C.CASE_STATUS_CD = S.CASE_STATUS_CD " .
		 		"AND   C.LAB_ID = L.LAB_ID " . $filterWhereClause . "ORDER BY C.CASE_NUMBER_ID DESC LIMIT 100";
				//echo "$query";
				$result = mysqli_query($con, $query);
				while ($row = mysqli_fetch_assoc($result)) 
				{
					$caseId = $row['CASE_NUMBER_ID'];
					$patientFName = $row['PATIENT_FNAME'];
					$patientLName = $row['PATIENT_LNAME'];	
					$doctorName = $row['DOCTOR_NAME'];
					$labName = $row['LAB_NAME'];
					$officeName = $row['OFFICE_NAME'];
					$caseStatusDesc = $row['CASE_STATUS_DESC'];
					$caseOpenDt = $row['CASE_OPEN_DT'];
					display_case($caseId, $patientFName, $patientLName, $doctorName, $labName, $caseStatusDesc, $caseOpenDt);
				}
			}
			echo "</table>";
		}
		else 
		{
			//echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"2\" id=\"casedisplay\" style=\"border: 1px solid black\">";
			// Display cases opened in last week or as a result of query ...
			$statusCdAr = array("'T'","'L'","'B'","'E'","'C'");
			foreach ($statusCdAr as $statusCd) 
			{
				echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"2\" id=\"casedisplay\" style=\"border: 1px solid gray; border-spacing: 10px; margin-bottom: 5px\">";
				$query = "SELECT C.CASE_NUMBER_ID, P.PATIENT_FNAME, P.PATIENT_LNAME, C.DOCTOR_NAME, L.LAB_NAME, S.CASE_STATUS_DESC, C.CASE_OPEN_DT " .
		 		"FROM case_tbl C, patient_tbl P, lab_tbl L, case_status_tbl S " .
		 		"WHERE C.PATIENT_ID = P.PATIENT_ID " .
		 		"AND   C.LAB_ID = L.LAB_ID " .
				"AND   C.CASE_STATUS_CD = S.CASE_STATUS_CD " .
				"AND   C.CASE_STATUS_CD = " . $statusCd . " ORDER BY C.CASE_NUMBER_ID DESC " ;
				// secho "$query";
				$result = mysqli_query($con, $query);
				while ($row = mysqli_fetch_assoc($result)) 
				{
					$caseId = $row['CASE_NUMBER_ID'];
			 		$patientFName = $row['PATIENT_FNAME'];
					$patientLName = $row['PATIENT_LNAME'];
					$doctorName = $row['DOCTOR_NAME'];
					$labName = $row['LAB_NAME'];
					$caseStatusDesc = $row['CASE_STATUS_DESC'];
					$caseOpenDt = $row['CASE_OPEN_DT'];
					display_case($caseId, $patientFName, $patientLName, $doctorName, $labName, $caseStatusDesc, $caseOpenDt);
				}
				echo "</table>";
			}
			// "AND C.CASE_OPEN_DT >= NOW() - INTERVAL 6 WEEK " .
			//echo "$query";
		}
	?>
</div>
</div>
</body>
</html>
<?php 
	//mysqli_close($con);
?>
