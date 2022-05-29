<?php 
	include_once "conn1.php";
	if(isset($_POST['loginUserBtn']))
	{
		$userNameVar = $_POST['userName'];
		$passWordVar = $_POST['passWord'];
		// Verify if userId is present...
		$query = "select count(*) as COUNT from user_tbl where USER_ID = '" . $userNameVar . "'";
		$result = mysqli_query($con, $query);
		while ($row = mysqli_fetch_assoc($result)) 
		{
			$cntRow = $row['COUNT'];
			echo "$cntRow";
			if ($cntRow == 0)
			{
				header("Location: /lab/login.php?userId=$userNameVar");
			}
		}
		$query1 = "select USER_ID, USER_PWD, USER_ROLE from user_tbl where USER_ID = '" . $userNameVar . "'";
		$result1 = mysqli_query($con, $query1);
		while ($row1 = mysqli_fetch_assoc($result1)) 
		{
			$userNameRet = $row1['USER_ID'];
			$passWordRet = $row1['USER_PWD'];
			$userRoleRet = $row1['USER_ROLE'];
			if ($passWordVar != $passWordRet)
			{ 
				header("Location: /lab/login.php?pwdId=1");
			}
			else 
			{
				session_start();
				$_SESSION['userName'] = $userNameRet;
				$_SESSION['userRole'] = $userRoleRet;
				header("Location: /lab/search_display_cases.php");
			}
		}
	}
?>
