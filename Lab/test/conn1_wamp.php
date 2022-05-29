<?php
session_start();
if (!isset($_SESSION['userName']))
{
	header("Location: /lab/login.php");
}
// Create connection
$con=mysqli_connect("127.0.0.1","mysqluser1","15lipiec90","DENTAL");

// Check connection
if (mysqli_connect_errno($con))
{
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
