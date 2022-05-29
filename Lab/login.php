<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>System Login</title>
<style type="text/css">
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, cite, code,
del, dfn, em, font, ins, kbd, q, s, samp,
strike, strong, sub, sup, tt, var,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {
	border: 0;
	font-family: inherit;
	font-size: 100%;
	font-style: inherit;
	font-weight: inherit;
	margin: 0;
	outline: 0;
	padding: 0;
	vertical-align: baseline;
}

article, aside, details, figcaption, figure,
footer, header, hgroup, menu, nav, section {
	display: block;
}

label {
    width:60px;
    float:left;
    font-size:12px;
    line-height:24px;
    font-weight:normal;
	font-family:Tahoma, Geneva, sans-serif;

}


/*General rules*/
#form3 input {
    line-height:18px;
}
/*Text, email & tel input fields*/
#form3 input[type=text],
#form3 input[type=password],
#form3 input[type=tel] {
    width:300px;
    margin-bottom:8px;
    padding:2px 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border:1px solid #CCC;
}
/*Just the tel field*/
#form3 input[type=tel] {
    width:150px;
}
/*The Submit Button */
#form3 input[type=button] {
    margin-top:5px;
    margin-left:60px;
    padding:2px 20px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border:2px solid #ccc;
    background-color:#ccc;
    color:#fff;
    font-weight:bold;
}
#form3 button {
    margin-top:5px;
    margin-left:60px;
    padding:2px 20px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border:2px solid #ccc;
    background-color:#ccc;
    color:#fff;
    font-weight:bold;
}
#form3 input[type=text]:focus,
#form3 input[type=password]:focus,
#form3 input[type=tel]:focus{
    border:1px solid #09F;
    -webkit-box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.3);
-moz-box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.3);
box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.3);
}
#wrapper {
	width:500px;
	margin-top:100px;
	padding:40px;
	clear: both;
	display: block;
	margin-left: auto;
	margin-right: auto;
	-webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border:1px solid #CCC;
}
#login {
	width:400px;
	height:200px;
	margin-left: auto;
	margin-right: auto;
}
#login h1 {
	font-family:"Courier New", Courier, monospace;
	font-size:18px;
	margin:20px 60px;
}
#login .date {
	font-family:"Courier New", Courier, monospace;
	font-size:12px;
	margin:20px 60px;
}
#login .loginerror {
	font-family:"Courier New", Courier, monospace;
	color:#C00;
	font-size:14px;
	margin:20px 60px;
}
</style>
<link rel="stylesheet" href="style-mg.css" />
<script>
function setFocus()
{
	document.getElementById("name").focus();
}
</script>
</head>

<body onload="setFocus()">

<div id="wrapper">
<div id="login">
<h1>System Login</h1>

<form id="form3" action="/lab/process_login.php" name="loginUser" method="post">
<label for="name">User ID:</label><input name="userName" id="name" type="text" /><br />
<label for="password">Password:</label><input type="password" name="passWord" id="password" /><br />
<button type="submit" name="loginUserBtn">Login</button>

<p class="loginerror"><?php 
			if(isset($_GET['userId']))
			{
				echo "User ID " . $_GET['userId'] . " not in the database. <br>Please use different Id";
				echo "<br>";
			}
			if(isset($_GET['pwdId']))
			{
				echo "Password is incorrect. <br>Please check if the CAPS LOCK is on";
				echo "<br>";
			}			
		?></p>
</form>

<p class="date">System Date: <?php echo date('jS F Y'); ?></p>
</div>
</div>
</body>
</html>
