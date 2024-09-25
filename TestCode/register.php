<?php session_start(); ?>

<!DOCTYPE html>

	<!-- Description:  -->
	<!-- Author:  -->
	<!-- Date:  -->

<html lang="en">
<head>
	<meta charset='utf-8' />
    <meta name="author" content=""/>
	<meta name="description" content="Registration Page"/>
	<meta name="keywords" content="register"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<title>Register</title>
	<link rel="icon" href="image/logo.png"/>
</head>
<body class="register">
	
	<form method="post" action="reg_confirm.php">
		<img src="image/logo.png" alt="Logo"  width="100%" height="100%"/>
		<h1>Register</h1>
		<p>Create a new account</p>
		<fieldset>
			<table>
				<tr>
				  <td><input type="text" name="fname" placeholder="First Name*"/></td>
				  <td><input type="text" name="lname" placeholder="Last Name*"/></td>
				</tr>
				<tr  id="email_field">
				  <td colspan="2"><input type="email" name="email" placeholder="Email*" id="email"/></td>
				</tr>
				<tr>
				  <td><input type="password" name="pass" placeholder="Password*"/></td>
				  <td><input type="password" name="c_pass" placeholder="Confirm Password*"/></td>
				</tr>
			</table>
		</fieldset>
		<div>
			<input type="reset" value="Reset"/>
			<input type="submit" value="Register" name="submit"/>
		</div>
	</form>
	<div>
		<?php
			// Display ERROR messages if any
			if (!empty($_SESSION['error'])){
				echo $_SESSION['error'];
				unset($_SESSION['error']);
			}
		?>
		<p>Already Register?<br/><a href="login.php">SIGN IN</a></p>
	</div>
</body>
</html>

<?php 
session_destroy(); ?>