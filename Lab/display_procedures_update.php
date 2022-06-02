<?php 
	//session_start(); 
	if (!isset($_SESSION['userName']))
	{
		header("Location: /lab/login.php");
	}
	include_once "conn1.php";
?>
<?php 
$procId = array();
$procName = array();
$procType = array();
		
$query = "select PROCEDURE_ID, PROCEDURE_NAME, PROCEDURE_TYPE from procedure_tbl order by PROCEDURE_ID";
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_assoc($result))
{
	$procId[$row['PROCEDURE_ID']] = $row['PROCEDURE_ID'];
    $procName[$row['PROCEDURE_ID']] = $row['PROCEDURE_NAME'];
    $procType[$row['PROCEDURE_ID']] = $row['PROCEDURE_TYPE'];
}
//$GLOBALS[distinctProcName] = array_unique($procName);
$distinctProcName = array_unique($procName);
$displayProcId = $procId;
$displayProcName = $procName;
$displayProcType = $procType;

// Datepicker src and ref
echo "<link rel=\"stylesheet\" href=\"http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css\" />";
echo "<script src=\"http://code.jquery.com/jquery-1.10.2.js\"></script>";
echo "<script src=\"http://code.jquery.com/ui/1.10.4/jquery-ui.js\"></script>";
echo "<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js\">";
echo "<script src=\"jsfunctions.js\"></script>";
//echo "<link rel=\"stylesheet\" href=\"/resources/demos/style.css\" />";
echo "<link rel=\"stylesheet\" href=\"style-mg.css\" />";

function display_proc_form_update($idupd, $procNameUpd, $procTypeUpd, $procQuadrantNoUpd, $procToothNoUpd, $procCreateDate1Upd, $procOutLabDate1Upd, $procFromLabDate1Upd, $procComments1Upd, $procCreateDate2Upd, $procOutLabDate2Upd, $procFromLabDate2Upd, $procComments2Upd, $procCreateDate3Upd, $procOutLabDate3Upd, $procFromLabDate3Upd, $procComments3Upd)
{
	global $distinctProcName;
	global $displayProcId;
	global $displayProcName;
	global $displayProcType;
	global $displayQuadrantNoId;
	global $displayToothNoId;
	
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";        			
	echo "<tr><td colspan=\"4\" style=\"background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px\" >";
	echo "<h3>Procedure $idupd</h3></td></tr>";  
	echo "<tr>";
	echo "<td style=\"padding:10px 0\">Procedure Name</td> <td>Procedure Type</td><td>Quadrant Number</td><td>Tooth Number</td>";
    echo "</tr>";

	echo "<tr>";
		echo "<td>";
		echo "<select name=\"procName_$idupd\" id=\"procName_$idupd\" onchange=\"javascript:populateProcType($idupd)\">";
		foreach ($distinctProcName as $value) 
    	{
    		if ($procNameUpd == $value)
    		{
    			echo "<option value=\"$value\" selected>$value</option>";
    		}
    		else 
    		{
    			echo "<option value=\"$value\" >$value</option>";
    		}
    	}
    	echo "</select>\n";
		echo "</td>";
   		echo "<td>";
   		echo "<select name=\"procType_$idupd\" id=\"procType_$idupd\">";
   		foreach($displayProcId as $index)
   		{
   			if ($displayProcName[$index] == $procNameUpd)
   			{
   				if ($displayProcType[$index] == $procTypeUpd)
   				{
   					echo "<option value=\"$procTypeUpd\" selected>$procTypeUpd</option>";
   				}
   				else
   				{
   					echo "<option value=\"$displayProcType[$index]\">$displayProcType[$index]</option>";
   				}	
   			}
   		}
   		echo "</select>\n";
		echo "</td>";
     	echo "<td>";
     	echo "<select name=\"procQuadrantNo_$idupd\" id=\"procQuadrantNo_$idupd\">";
     	$maxQuadNo = 8;
     	echo "<option value=\"\">Select Quadrant Number</option>";
     	for ($i = 1; $i <= $maxQuadNo; $i++)
     	{
     		if ("Q$i" == $procQuadrantNoUpd)
     		{
     			echo "<option value=\"$procQuadrantNoUpd\" selected>$procQuadrantNoUpd</option>\n";
     		}
     		else 
     		{
     			echo "<option value=\"Q$i\">Q$i</option>\n";
     		}
     	}
     	echo "</select>"; 
     	echo "</td>";
     	echo "<td>";
     	//echo "<input type=\"text\" name=\"procToothNo_$idupd\" value=\"$procToothNoUpd\">";
     	echo "<select name=\"procToothNo_$idupd\" id=\"procToothNo_$idupd\">";
     	$maxTootNo = 8;
     	echo "<option value=\"\">Select Tooth Number</option>";
     	for ($i = 1; $i <= $maxTootNo; $i++)
     	{
     		if ($i == $procToothNoUpd)
     		{
     			echo "<option value=\"$procToothNoUpd\" selected>$procToothNoUpd</option>\n";
     		}
     		else 
     		{
     			echo "<option value=\"$i\">$i</option>\n";
     		}
     	}
     	echo "</select>"; 
     	echo "</td>";
	echo "</tr>";
	echo "<tr><td colspan=\"4\">&nbsp;</td></tr>";
	echo "</table>";
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";
    echo "<tr>";
    echo "<td>Procedure Date</td><td>Out To Lab</td><td>Back From Lab</td><td>Comments:</td>";
    echo "</tr>";
    echo "<tr>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procCreateDate1_$idupd\" value=\"$procCreateDate1Upd\" id=\"procCreateDate1_$idupd\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procCreateDate1_$idupd\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true }).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td valign=\"top\">";
		echo "<input type=\"text\" name=\"procOutLabDate1_$idupd\" value=\"$procOutLabDate1Upd\" id=\"procOutLabDate1_$idupd\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procOutLabDate1_$idupd\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true }).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td valign=\"top\">";
		echo "<input type=\"text\" name=\"procFromLabDate1_$idupd\" value=\"$procFromLabDate1Upd\" id=\"procFromLabDate1_$idupd\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procFromLabDate1_$idupd\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<script>";
		echo "\$(document).ready(function(){\$(\"#showCommentButton1_$idupd\").click(function(){\$(\"#comment_1_$idupd\").show();});$(\"#hideCommentButton1_$idupd\").click(function(){\$(\"#comment_1_$idupd\").hide();});});";
		echo "</script>";
		echo "<input type=\"button\" id=\"showCommentButton1_$idupd\" style=\"margin-left:0; padding:2px 10px; height:25px\" value=\"Show\">";
		echo "<input type=\"button\" id=\"hideCommentButton1_$idupd\" style=\"margin-left:0; padding:2px 10px; height:25px\" value=\"Hide\">";
		echo "</td>";
	echo "</tr>";
	echo "</table>";
	if(strlen($procComments1Upd) < 1)
	{
		echo "<div id=\"comment_1_$idupd\" name=\"comment_1_$idupd\" style=\"padding:5px;display:table;display:none\">";
	}
	else 
	{
		echo "<div id=\"comment_1_$idupd\" name=\"comment_1_$idupd\" style=\"padding:5px;display:table\">";
	}
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";  
	echo "<tr>";
	echo "<td colspan=\"4\" align=\"left\">";
		echo "<input type=\"button\" style=\"margin-left:0; height:25px\" value=\"FitToText\" onclick=\"resizeFitText(1,$idupd)\">";
		echo "<input type=\"button\" style=\"margin-left:0; height:25px\" value=\"Reset\" onclick=\"resizeReset(1,$idupd)\">";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td colspan=\"4\"><textarea rows=\"3\" cols=\"90\" name=\"procComments1_$idupd\" id=\"procComments1_$idupd\">$procComments1Upd</textarea></td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";
	echo "<tr>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procCreateDate2_$idupd\" value=\"$procCreateDate2Upd\" id=\"procCreateDate2_$idupd\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procCreateDate2_$idupd\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procOutLabDate2_$idupd\" value=\"$procOutLabDate2Upd\" id=\"procOutLabDate2_$idupd\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procOutLabDate2_$idupd\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procFromLabDate2_$idupd\" value=\"$procFromLabDate2Upd\" id=\"procFromLabDate2_$idupd\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procFromLabDate2_$idupd\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<script>";
		echo "\$(document).ready(function(){\$(\"#showCommentButton2_$idupd\").click(function(){\$(\"#comment_2_$idupd\").show();});$(\"#hideCommentButton2_$idupd\").click(function(){\$(\"#comment_2_$idupd\").hide();});});";
		echo "</script>";
		echo "<input type=\"button\" id=\"showCommentButton2_$idupd\" style=\"margin-left:0; padding:2px 10px; height:25px\" value=\"Show\">";
		echo "<input type=\"button\" id=\"hideCommentButton2_$idupd\" style=\"margin-left:0; padding:2px 10px; height:25px\" value=\"Hide\">";
		echo "</td>";
		echo "</tr>";
	echo "</table>";
	if(strlen($procComments2Upd) < 1)
	{
		echo "<div id=\"comment_2_$idupd\" name=\"comment_2_$idupd\" style=\"padding:5px;display:table;display:none\">";
	}
	else 
	{
		echo "<div id=\"comment_2_$idupd\" name=\"comment_2_$idupd\" style=\"padding:5px;display:table\">";
	}
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";  
	echo "<tr>";
	echo "<td colspan=\"4\" align=\"left\">";
		echo "<input type=\"button\" style=\"margin-left:0; height:25px\" value=\"FitToText\" onclick=\"resizeFitText(2,$idupd)\">";
		echo "<input type=\"button\" style=\"margin-left:0; height:25px\" value=\"Reset\" onclick=\"resizeReset(2,$idupd)\">";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td colspan=\"4\"><textarea rows=\"3\" cols=\"90\" name=\"procComments2_$idupd\" id=\"procComments2_$idupd\">$procComments2Upd</textarea></td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";
	echo "<tr>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procCreateDate3_$idupd\" value=\"$procCreateDate3Upd\" id=\"procCreateDate3_$idupd\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procCreateDate3_$idupd\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procOutLabDate3_$idupd\" value=\"$procOutLabDate3Upd\" id=\"procOutLabDate3_$idupd\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procOutLabDate3_$idupd\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procFromLabDate3_$idupd\" value=\"$procFromLabDate3Upd\" id=\"procFromLabDate3_$idupd\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procFromLabDate3_$idupd\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<script>";
		echo "\$(document).ready(function(){\$(\"#showCommentButton3_$idupd\").click(function(){\$(\"#comment_3_$idupd\").show();});$(\"#hideCommentButton3_$idupd\").click(function(){\$(\"#comment_3_$idupd\").hide();});});";
		echo "</script>";
		echo "<input type=\"button\" id=\"showCommentButton3_$idupd\" style=\"margin-left:0; padding:2px 10px; height:25px\" value=\"Show\">";
		echo "<input type=\"button\" id=\"hideCommentButton3_$idupd\" style=\"margin-left:0; padding:2px 10px; height:25px\" value=\"Hide\">";
		echo "</td>";
		echo "</tr>";
	echo "</table>";
	if(strlen($procComments3Upd) < 1)
	{
		echo "<div id=\"comment_3_$idupd\" name=\"comment_3_$idupd\" style=\"padding:5px;display:table;display:none\">";
	}
	else 
	{
		echo "<div id=\"comment_3_$idupd\" name=\"comment_3_$idupd\" style=\"padding:5px;display:table\">";
	}
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";  
	echo "<tr>";
	echo "<td colspan=\"4\" align=\"left\">";
		echo "<input type=\"button\" style=\"margin-left:0; height:25px\" value=\"FitToText\" onclick=\"resizeFitText(3,$idupd)\">";
		echo "<input type=\"button\" style=\"margin-left:0; height:25px\" value=\"Reset\" onclick=\"resizeReset(3,$idupd)\">";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td colspan=\"4\"><textarea rows=\"3\" cols=\"90\" name=\"procComments3_$idupd\" id=\"procComments3_$idupd\">$procComments3Upd</textarea></td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
}

function display_proc_form($id)
{
	global $distinctProcName;
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";        			
	echo "<tr><td colspan=\"4\" style=\"background-color:#d8d4ca; vertical-align:middle; color:#000; padding:5px; margin-bottom:10px\" >";
	echo "<h3>Procedure $id</h3></td></tr>";
	echo "<tr>";
	echo "<td style=\"padding:10px 0\">Procedure Name</td> <td>Procedure Type</td><td>Quadrant Number</td><td>Tooth Number</td>";
    echo "</tr>";
	echo "<tr>";
		echo "<td>";
		echo "<select name=\"procName_$id\" id=\"procName_$id\" onchange=\"javascript:populateProcType($id)\">";
		echo "<option value=\"\">Select Procedure Name</option>";
		foreach ($distinctProcName as $value) 
    	{
    		echo "<option value=\"$value\">$value</option>\n";
    	}
    	echo "</select>\n";
		echo "</td>";
   		echo "<td>";
   		echo "<select name=\"procType_$id\" id=\"procType_$id\"><option value=\"\">Select Procedure Type</option></select>";
		echo "</td>";
     	echo "<td>";
     	echo "<select name=\"procQuadrantNo_$id\" id=\"procQuadrantNo_$id\">";
     	$maxQuadNo = 8;
     	echo "<option value=\"\">Select Quadrant Number</option>";
     	for ($i = 1; $i <= $maxQuadNo; $i++)
     	{
     		echo "<option value=\"Q$i\">Q$i</option>\n";
     	}
     	echo "</select>"; 
     	echo "</td>";
     	echo "<td>";
     	echo "<select name=\"procToothNo_$id\" id=\"procToothNo_$id\">";
     	$maxTootNo = 8;
     	echo "<option value=\"\">Select Tooth Number</option>";
     	for ($i = 1; $i <= $maxTootNo; $i++)
     	{
     		echo "<option value=\"$i\">$i</option>\n";
     	}
     	echo "</select>"; 
     	echo "</td>";
	echo "</tr>";
	echo "<tr><td colspan=\"4\">&nbsp;</td></tr>";
	echo "</table>";
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";
    echo "<tr>";
		echo "<td>Procedure Date</td><td>Out To Lab</td><td>Back From Lab</td><td>Comments:</td>";
    echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procCreateDate1_$id\" id=\"procCreateDate1_$id\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procCreateDate1_$id\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procOutLabDate1_$id\" id=\"procOutLabDate1_$id\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procOutLabDate1_$id\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procFromLabDate1_$id\" id=\"procFromLabDate1_$id\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procFromLabDate1_$id\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
	echo "<script>";
		echo "\$(document).ready(function(){\$(\"#showCommentButton1_$id\").click(function(){\$(\"#comment_1_$id\").show();});$(\"#hideCommentButton1_$id\").click(function(){\$(\"#comment_1_$id\").hide();});});";
		echo "</script>";
		echo "<input type=\"button\" id=\"showCommentButton1_$id\" style=\"margin-left:0; padding:2px 10px; height:25px\" value=\"Show\">";
		echo "<input type=\"button\" id=\"hideCommentButton1_$id\" style=\"margin-left:0; padding:2px 10px; height:25px\" value=\"Hide\">";
		echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "<div id=\"comment_1_$id\" name=\"comment_1_$id\" style=\"padding:5px;display:table;display:none\">";
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";  
	echo "<tr>";
	echo "<td colspan=\"4\" align=\"left\">";
		echo "<input type=\"button\" style=\"margin-left:0; height:25px\" value=\"FitToText\" onclick=\"resizeFitText(1,$id)\">";
		echo "<input type=\"button\" style=\"margin-left:0; height:25px\" value=\"Reset\" onclick=\"resizeReset(1,$id)\">";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td colspan=\"4\"><textarea rows=\"3\" cols=\"90\" name=\"procComments1_$id\" id=\"procComments1_$id\"></textarea></td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";
	echo "<tr>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procCreateDate2_$id\" id=\"procCreateDate2_$id\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procCreateDate2_$id\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procOutLabDate2_$id\" id=\"procOutLabDate2_$id\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procOutLabDate2_$id\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procFromLabDate2_$id\" id=\"procFromLabDate2_$id\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procFromLabDate2_$id\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<script>";
		echo "\$(document).ready(function(){\$(\"#showCommentButton2_$id\").click(function(){\$(\"#comment_2_$id\").show();});$(\"#hideCommentButton2_$id\").click(function(){\$(\"#comment_2_$id\").hide();});});";
		echo "</script>";
		echo "<input type=\"button\" id=\"showCommentButton2_$id\" style=\"margin-left:0; padding:2px 10px; height:25px\" value=\"Show\">";
		echo "<input type=\"button\" id=\"hideCommentButton2_$id\" style=\"margin-left:0; padding:2px 10px; height:25px\" value=\"Hide\">";
		echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "<div id=\"comment_2_$id\" name=\"comment_2_$id\" style=\"padding:5px;display:table;display:none\">";
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";  
	echo "<tr>";
	echo "<td colspan=\"4\" align=\"left\">";
		echo "<input type=\"button\" style=\"margin-left:0; height:25px\" value=\"FitToText\" onclick=\"resizeFitText(2,$id)\">";
		echo "<input type=\"button\" style=\"margin-left:0; height:25px\" value=\"Reset\" onclick=\"resizeReset(2,$id)\">";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td colspan=\"4\"><textarea rows=\"3\" cols=\"90\" name=\"procComments2_$id\" id=\"procComments2_$id\"></textarea></td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";
	echo "<tr>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procCreateDate3_$id\" id=\"procCreateDate3_$id\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procCreateDate3_$id\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procOutLabDate3_$id\" id=\"procOutLabDate3_$id\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procOutLabDate3_$id\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<input type=\"text\" name=\"procFromLabDate3_$id\" id=\"procFromLabDate3_$id\">";
		echo "<script>";
		echo "\$(function() {\$( \"#procFromLabDate3_$id\" ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true}).val();})";
		echo "</script>";
		echo "</td>";
		echo "<td>";
		echo "<script>";
		echo "\$(document).ready(function(){\$(\"#showCommentButton3_$id\").click(function(){\$(\"#comment_3_$id\").show();});$(\"#hideCommentButton3_$id\").click(function(){\$(\"#comment_3_$id\").hide();});});";
		echo "</script>";
		echo "<input type=\"button\" id=\"showCommentButton3_$id\" style=\"margin-left:0; padding:2px 10px; height:25px\" value=\"Show\">";
		echo "<input type=\"button\" id=\"hideCommentButton3_$id\" style=\"margin-left:0; padding:2px 10px; height:25px\" value=\"Hide\">";
		echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "<div id=\"comment_3_$id\" name=\"comment_3_$id\" style=\"padding:5px;display:table;display:none\">";
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" >";  
	echo "<tr>";
	echo "<td colspan=\"4\" align=\"left\">";
		echo "<input type=\"button\" style=\"margin-left:0; height:25px\" value=\"FitToText\" onclick=\"resizeFitText(3,$id)\">";
		echo "<input type=\"button\" style=\"margin-left:0; height:25px\" value=\"Reset\" onclick=\"resizeReset(3,$id)\">";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td colspan=\"4\"><textarea rows=\"3\" cols=\"90\" name=\"procComments3_$id\" id=\"procComments3_$id\"></textarea></td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
}
?>
<script type="text/javascript">
function resizeReset(row,id)
{
	var controlId = id;
	var commentTAId = 'procComments' + row + '_' + controlId;
	var ta = document.getElementById(commentTAId);
  	ta.rows = 3 ;
}
function resizeFitText(row,id)
{
	var controlId = id;
	var commentTAId = 'procComments' + row + '_' + controlId;
	var textarea = document.getElementById(commentTAId);
	var lines = textarea.value.split('\n');
	var width = textarea.cols;
	var height = 1;
	for (var i = 0; i < lines.length; i++)
	{
		var linelength = lines[i].length;
	  	if (linelength >= width)
		{
	  		height += Math.ceil(linelength / width);
		}
	}
	height += lines.length;
	textarea.rows = height;
}
function datePicker(id, inputName)
{
	var controlId = id;
	var controlInputName = inputName;
	var datePickerVar = $(function() {$( '#' + inputName + id ).datepicker({ dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'calendar.ico', buttonImageOnly: true }).val();});
	return datePickerVar;
}
function populateProcType(id)
{
	var controlId = id;
	var controlProcName = 'procName_' + controlId;
	var controlProcType = 'procType_' + controlId;
	var procIdArrJs = <?php echo json_encode($procId);?>;
	var procNameArrJs = <?php echo json_encode($procName);?>;
	var procTypeArrJs = <?php echo json_encode($procType);?>;

	var procNameList = document.getElementById(controlProcName);
	var procNameListSelectedValue= procNameList[procNameList.selectedIndex].text;

	var procTypeList = document.getElementById(controlProcType);
	procTypeList.options.length = 1;
	//procTypeList.options[procTypeList.options.length] = new Option("Select Procedure Type", "");
	for (var index in procNameArrJs)
	{
		if (procNameArrJs[index] === procNameListSelectedValue)
		{
			procTypeList.options[procTypeList.options.length] = new Option(procTypeArrJs[index], procTypeArrJs[index]);
		}
	}
}
function validateProc(id)
{
	//alert ('inside validate proc');
	var controlId = id;
	//var controlToothNo = 'procToothNo_' +controlId;
	var controlProcName = 'procName_' + controlId;
	var controlProcType = 'procType_' + controlId;
	var procNameList = document.getElementById(controlProcName);
	var procNameListSelectedValue= procNameList[procNameList.selectedIndex].value;
	var procTypeList = document.getElementById(controlProcType);
	var procTypeListSelectedValue= procTypeList[procNameList.selectedIndex].value;
	//var controlProcNameVal = document.caseData.controlProcName.value;
	//var controlProcTypeVal = document.caseData.controlProcType.value;
	//alert( 'Procedure ' + id + ' Name: ' +  controlProcNameVal + ' Type: ' + controlProcTypeVal);
	//alert( 'Procedure ' + id + ' Name: ' +  procNameListSelectedValue + ' Type: ' + procTypeListSelectedValue);
	if((procNameListSelectedValue == "") || (procTypeListSelectedValue == ""))
	{
		alert( "Please select ProcName and ProcType values before you can proceed!" );
	   	procNameList.focus();
	    return false;
	}
}
function validateProcHdr(id)
{
	//alert ('inside validate proc');
	var controlId = id;
	//var controlToothNo = 'procToothNo_' + controlId;
	var controlProcName = 'procName_' + controlId;
	var controlProcType = 'procType_' + controlId;
	
	var procNameList = document.getElementById(controlProcName);
	var procNameListSelectedValue= procNameList[procNameList.selectedIndex].value;
	var procTypeList = document.getElementById(controlProcType);
	var procTypeListSelectedValue= procTypeList[procNameList.selectedIndex].value;
	//var procToothNoList = document.getElementById(controlToothNo);
	//var procToothNoListSelectedValue= procTypeList[procToothNoList.selectedIndex].value;
	//var controlProcNameVal = document.caseData.controlProcName.value;
	//var controlProcTypeVal = document.caseData.controlProcType.value;
	//alert( 'Procedure ' + id + ' Name: ' +  controlProcNameVal + ' Type: ' + controlProcTypeVal);
	//alert( 'Procedure ' + id + ' Name: ' +  procNameListSelectedValue + ' Type: ' + procTypeListSelectedValue);
	if((procNameListSelectedValue == "") || (procTypeListSelectedValue == "") || (procToothNoListSelectedValue == ""))
	{
		alert( "Please select ProcName and ProcType before you can proceed!" );
	   	procNameList.focus();
	    return false;
	}
	return false;
}
function enableProcEntry(id)
{
	var controlId = id;
	var controlProcCreateDt1 = 'procCreateDate1_' + controlId;
}
</script>
