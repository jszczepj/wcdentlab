<?php 
        session_start();
        session_destroy();
        include_once "conn1.php";
	mysqli_close($con);
	header("Location: /lab/login.php");
?>