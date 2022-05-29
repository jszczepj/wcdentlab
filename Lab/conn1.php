<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
if (!isset($_SESSION['userName']))
{
	header("Location: /lab/login.php");
}
// Create connection
//$con=mysqli_connect("internal-db.s164528.gridserver.com","db164528","4dezin216!","db164528_DENTAL");
#$con=mysqli_connect("localhost","dentalimplantsmi_lab","Lab2020lab05+","dentalimplantsmi_dental");
$con=mysqli_connect("localhost","lab_app","Dental20220523+","dentalimplantsmi_dental");
// Check connection
if (mysqli_connect_errno())
{
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
