<?php 
	include_once "conn1.php";
	if (!isset($_SESSION['userName']))
	{
		header("Location: /lab/login.php");
	}
?>
<?php 
function display_case($id, $patFName, $patLName, $docName, $labName, $offName, $caseOpDt)
{
	echo "<tr>";
	echo "<td align=\"center\" ><a href=\"get_display_case_proc.php?cId=$id\"><button style=\"margin-top:5px; margin-left:10px; padding:2px 10px; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; border:2px solid #ccc1
    background-color:#ccc; color:#666666;font-weight:bold;\">$id</button></a></td>";
   	echo "<td>$patFName, $patLName</td>";
    echo "<td>$docName</td>";
    echo "<td>$labName</td>";
	echo "<td>$offName</td>";
	echo "<td>$caseOpDt</td>";
	echo "</tr>";
}
function display_upd_case($id, $patFName, $patLName, $docName, $labName, $offName, $caseOpDt)
{
	echo "<tr>";
	echo "<td align=\"center\" ><input type=\"checkbox\" name=\"assDedChkBox[]\" value=\"$id\"> $id</td>";
   	echo "<td>$patFName, $patLName</td>";
    echo "<td>$docName</td>";
    echo "<td>$labName</td>";
	echo "<td>$offName</td>";
	echo "<td>$caseOpDt</td>";
	echo "</tr>";
}
?>	
