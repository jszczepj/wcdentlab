<?php
//session_start();
if (!isset($_SESSION['userName']))
{
	header("Location: /lab/login.php");
}
function dsp_empty_dt($emptyDt)
{
	if ($emptyDt == '0000-00-00')
	{
		$emptyDt = '';
		return $emptyDt;
	}
	else
	{
		return $emptyDt;
	}	
}
function display_header()
{
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";
	echo "<tr>";
	echo "<td style=\"text-align:center; 
	margin-top:5px;
    margin-left:0px;
    padding:5px 20px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border:2px solid #ccc;
    background-color:#ccc;
    color:#fff;
    font-weight:bold;\"><a href=\"search_display_cases.php\">Find Case(s)</a></td>";
	echo "<td>&nbsp;&nbsp;</td>";
	echo "<td style=\"text-align:center;
	margin-top:5px;
    margin-left:0px;
    padding:5px 20px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border:2px solid #ccc;
    background-color:#ccc;
    color:#fff;
    font-weight:bold;\"><a href=\"add_case_dyn_proc.php\">Add New Case</a></td>";
	/*if ($_SESSION['userRole'] === 'admin')
	{
		echo "<td>&nbsp;&nbsp;</td>";
		echo "<td style=\"text-align:center;
		margin-top:5px;
    	margin-left:0px;
    	padding:5px 20px;
    	-webkit-border-radius: 5px;
    	-moz-border-radius: 5px;
    	border-radius: 5px;
    	border:2px solid #ccc;
    	background-color:#ccc;
    	color:#fff;
    	font-weight:bold;\"><a href=\"edit_patient.php\">Manage Patient(s)</a></td>";
	}*/
	if ($_SESSION['userRole'] === 'admin')
	{
		echo "<td>&nbsp;&nbsp;</td>";
		echo "<td style=\"text-align:center;
		margin-top:5px;
    	margin-left:0px;
    	padding:5px 20px;
    	-webkit-border-radius: 5px;
    	-moz-border-radius: 5px;
    	border-radius: 5px;
    	border:2px solid #ccc;
    	background-color:#ccc;
    	color:#fff;
    	font-weight:bold;\"><a href=\"display_update_associate_deduction.php\">Associate Deduction</a></td>";
	}
	if ($_SESSION['userRole'] === 'admin')
	{
		echo "<td>&nbsp;&nbsp;</td>";
		echo "<td style=\"text-align:center;
		margin-top:5px;
    	margin-left:0px;
    	padding:5px 20px;
    	-webkit-border-radius: 5px;
    	-moz-border-radius: 5px;
    	border-radius: 5px;
    	border:2px solid #ccc;
    	background-color:#ccc;
    	color:#fff;
    	font-weight:bold;\"><a href=\"run_report.php\">Reporting</a></td>";
	}
	echo "<td>&nbsp;&nbsp;</td>";
	echo "<td style=\"text-align:center;
	margin-top:5px;
    margin-left:0px;
    padding:5px 20px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border:2px solid #ccc;
    background-color:#ccc;
    color:#fff;
    font-weight:bold;\"><a href=\"process_logoff.php\">Log Out</a></td>";
	echo "</tr>";
	echo "</table>";
	echo "<br>";
}
?>