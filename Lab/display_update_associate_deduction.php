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
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js" /></script>
	<link rel="stylesheet" type="text/css" href="style-jquery-custom.css" />
	<script src="lab-jquery-custom.js"></script >
    <link rel="stylesheet" href="style-mg.css" />
    <script type="text/javascript">
	/*$(document).ready(function(){
		$('input[name="select-all"]').bind('click', function(){
		var status = $(this).is(':checked');
		$('input[type="checkbox"]').attr('checked', status);
		});
	});*/
	$(document).ready(function() {
		  $('#check-all').click(function(){
		    $("input:checkbox").prop('checked', true);
		  });
		  $('#uncheck-all').click(function(){
		    $("input:checkbox").prop('checked', false);
		  });
	});
	</script>
	<title>Associate Deduction Update Screen</title>
	</head>
	<body >
	<div id="wrapperlarge">
	<div id="search">
	<div align="right"><img src="images/winston-churchill-dental.png" width="220"><img src="images/heritage-house-dental.png" width="300"><img src="images/smiles-on-essa-dental.png" width="300"></div>
	<h1>Associate Deduction Update Screen</h1>
	<p align="right" class="date">Date: <?php echo date('jS F Y'); ?>&nbsp;&nbsp;&nbsp;User Name: <?php echo $_SESSION['userName']; ?>&nbsp;&nbsp;&nbsp;User Role: <?php echo $_SESSION['userRole']; ?>
	<?php 
		display_header();
	?>
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" name="assDedUpd" method="post" id="assDedUpd">
	<table width="100%" border="0" cellspacing="0" cellpadding="2" id="casedisplay">
	<tr><td style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px"><h4>Case #</h4></td><td style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px"><h4>Patient Name</h4></td><td style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px"><h4>Doctor Name</h4></td><td style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px"><h4>Dental Lab Name</h4></td><td style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px"><h4>Dental Office Name</h4></td><td style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px"><h4>Case Open Date</h4></td></tr>
    <tr><td>&nbsp;</td></tr>
	<tr><td>
			<a id="check-all" href="javascript:void(0);">Check All/</a>
			<a id="uncheck-all" href="javascript:void(0);">Uncheck All</a> 
			<!--  input type="checkbox" name="select-all" id="select-all" /> Select/Deselect All -->
	</td></tr>
	<tr>
			<td>
			<?php
				$query = "SELECT CT.CASE_NUMBER_ID, CT.DOCTOR_NAME, PT.PATIENT_FNAME, PT.PATIENT_LNAME, LT.LAB_NAME, CT.OFFICE_NAME, CT.CASE_OPEN_DT ".
						 "FROM CASE_TBL CT JOIN PATIENT_TBL PT ON CT.PATIENT_ID = PT.PATIENT_ID ".
						 "JOIN LAB_TBL LT ON CT.LAB_ID = LT.LAB_ID ".
						 "WHERE CT.ASSOCIATE_DEDUCTION = 'NO'";
					$result = mysqli_query($con, $query);
					while ($row = mysqli_fetch_assoc($result)) 
					{
						$caseNumId = $row['CASE_NUMBER_ID'];
						$labName = $row['LAB_NAME'];
						$docName = $row['DOCTOR_NAME'];
						$patFName = $row['PATIENT_FNAME'];
						$patLName = $row['PATIENT_LNAME'];
						$offName = $row['OFFICE_NAME'];
						$caseOpenDt = $row['CASE_OPEN_DT'];
						display_upd_case($caseNumId, $patFName, $patLName, $docName, $labName, $offName, $caseOpenDt);
					}
				?>
			</td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	 <tr><td>&nbsp;</td></tr>
	 <tr>
			<td>
			<button style="width:350px; height:30px" type="submit" name="updateAssDeduction">UPDATE ASSOCIATE DEDUCTIONS</button>
			</td>
		</tr>
	<tr><td>&nbsp;</td></tr>
	</table>
</form>
<?php 
$inClause = "";
if(isset($_POST['updateAssDeduction']))
{
	if (isset($_POST['assDedChkBox'])) 
	{
   		$checkedAssDedBoxes = $_POST['assDedChkBox'];
   		$inClause = join(', ', $checkedAssDedBoxes);
   	}
   	if (!empty($inClause))
	{
   		// Update ASSOCIATE DEDUCTION for CASES in the INCLAUSE
   		$query = "UPDATE case_tbl SET ".
					"ASSOCIATE_DEDUCTION = 'YES', " .
			 		"ASSOCIATE_DEDUCTION_UPD_DT = NOW() " .
			 		"WHERE CASE_NUMBER_ID IN ({$inClause})";   
		$result = mysqli_query($con, $query);
		$currentDate = date('jS F Y');
		$currentTime = date('H:i:s');
		echo "ASSOCIATE DEDUCTION has been updated for the following CASES: $inClause on $currentDate at $currentTime";
	}
	else 
	{
		echo "NO CASES have been selected to perform ASSOCIATE DEDUCTION UPDATE";
	}
}
?>
</div>
</div>
</body>
</html>
