<html>
	<head>
		<title>Login Page</title>
		<link rel="stylesheet" type="text/css" href="mainstyle.css">
	</head>
<body>
	<!-- form action="<?php //echo $_SERVER['PHP_SELF'];?>" name="loginUser" method="post" -->
	<form action="process_login.php" name="loginUser" method="post">
	<table width="1080" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td colspan="3" style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px" >
				<h1>Login Page</h1>
			</td>
			<td colspan="3" style="background-color:#d8d4ca; vertical-align:middle; color:#000; padding:10px; margin-bottom:10px" >
				<h2>Date: <?php echo date('jS F Y'); ?></h2>
			</td>
		</tr>
		<tr>
			<td colspan="2">User Name:</td>
		    <td> <input type="text" name="userName" value=""></td>
		</tr>			
		<tr>
			<td colspan="2">Password:</td>
		    <td> <input type="password" name="passWord" value=""></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan=2><button style="width:150px; height:40px" type="submit" name="loginUserBtn">Login</button></td>
		</tr>
	</table>
	<table width="1080" border="0" cellspacing="0" cellpadding="2">
		<tr>
		<?php 
			if(isset($_GET['userId']))
			{
				echo "User Id " . $_GET['userId'] . " not in the database. Please use different Id";
				echo "<BR>";
			}
			if(isset($_GET['pwdId']))
			{
				echo "Password is incorrect. Please check if the CAPS is on";
				echo "<BR>";
			}			
		?>
		</tr>
	</table>
	</form>
	</body>
</html>
	
