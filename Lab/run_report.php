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
		<title>Run Report</title>
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css' />
        <!---->
		<script src="jsfunctions.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="style-jquery-custom.css" />
		<script src="lab-jquery-custom.js"></script>
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
    <h1>Run Report</h1>
	<p align="right" class="date">Date: <?php echo date('jS F Y'); ?>&nbsp;&nbsp;&nbsp;User Name: <?php echo $_SESSION['userName']; ?>&nbsp;&nbsp;&nbsp;User Role: <?php echo $_SESSION['userRole']; ?></p>
	<form action="pdfreports.php" name="runReport" method="post" id="runReport">
    <?php display_header();?>
	<div id="procedures">
	<div id="reporting">
	<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom:10px">
		<tr>
			<td colspan="4" style="background-color:#877c74; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px ">
				<h3 >Associate Deduction Report per given Date:</h3>
			</td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom:10px">
		<tr>
			<td style="align:left; vertical-align:middle; padding-top: 10px">
			<input style="font-size: 12px" type="text" value="Select Date:" name="selectAssDedDt" id="selectAssDedDt">
			<script>$(function() {$( "#selectAssDedDt" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true });});
				</script>
           	<button style="width:100px; height:30px; margin-left:0px" type="submit" name="run_report_1">Run</button>
            </td>
        </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-bottom:10px">
		<tr>
			<td colspan="4" style="background-color:#877c74; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px ">
				<h3 >Associate Deduction Report per Doctor for Date Range</h3>
			</td>
		</tr>
	</table>
  	<table>
		<tr>
			<td style="align:left; vertical-align:middle; padding-top: 10px">
				<select name="dentist_lst" style="margin-bottom: 7px">
					<option value=''>Select Dentist</option>
					<option value="Kate Bazydlo">Dr. Kate Bazydlo</option>
					<option value="Daniela Bololoi">Dr. Daniela Bololoi</option>
					<option value="Jennifer Holody">Dr. Jennifer Holody</option>
					<option value="Yolanda Li">Dr. Yolanda Li</option>
					<option value="Nicole Maciel">Dr. Nicole Maciel</option>
					<option value="Fred Diodati">Dr. Fred Diodati</option>
				</select>
			</td>
			<td style="align:left; vertical-align:middle; padding-top: 10px">
				<input style="marging-top: 10px; font-size: 12px" type="text" value="Select From Date:" name="selectFromAssDedDt" id="selectFromAssDedDt">
				<script>$(function() {$( "#selectFromAssDedDt" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true });});
				</script>
            </td>
            <td style="align:left; vertical-align:middle; padding-top: 10px">
				<input style="font-size: 12px" type="text" value="Select To Date:" name="selectToAssDedDt" id="selectToAssDedDt">
				<script>$(function() {$( "#selectToAssDedDt" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true });});
				</script>
            	<button style="width:100px; height:30px; margin-left:0px" type="submit" name="run_report_2">Run</button>
            </td>
		</tr>
	</table>
</div>
</div>
</form>
</div>
</div>
</body>
</html>