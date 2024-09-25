<?php
	session_start();
	
	// Check if ANY inputs are empty
	if ( (!empty($_POST['fname'])) && (!empty($_POST['lname'])) && (!empty($_POST['email'])) && (!empty($_POST['pass'])) && (!empty($_POST['c_pass']))){ 
        echo 'first point';
		// Check if Passwords match
		if ($_POST['pass'] == $_POST['c_pass']){
			$conn = @mysqli_connect("localhost","root","") or die("Unable to connect to database.");
			@mysqli_select_db($conn,"cos20031_proj") or die ("Unable to select database");
			
            $fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$email = $_POST['email'];
            
			$pass = hash('sha256',$_POST['pass']);
			$session_id = "none";
			
            $validate = "SELECT email FROM userlist WHERE email='$email';";
			
            // Execute query
            $user_exist = @mysqli_query($conn, $validate);
			
			// Check if Email has been registered
			$row = 0;
			if ($user_exist){
				$row = mysqli_num_rows($user_exist);
			}
			
			@mysqli_free_result($user_exist);
			
			if ($row == 0){ // Register new user
				
				$query = "INSERT INTO userlist(fname,lname,email,pass,session_id) VALUES('$fname','$lname','$email','$pass','$session_id');";
                
                // Execute query
                @mysqli_query($conn, $query);
                
			} else { // Displays error when User/Email already exist in database
				$_SESSION['error'] = "<p style='color:red'><strong>Failed! User already exist.</strong></p>";
				header("Location: register.php");
			}
			
			
			// @mysqli_free_result($row);
			@mysqli_close($conn);
		} else { // Displays error when passwords does not match
			$_SESSION['error'] = "<p style='color:red'><strong>Password does not match!</strong></p>";
			header("Location: register.php");
		}
	} else { // Displays error message when not all inputs are set
		$_SESSION['error'] = "<p style='color:red'><strong>Input fields is not complete!</strong></p>";
		header("Location: register.php");
	}
?>

<!DOCTYPE html>

	<!-- Description:  -->
	<!-- Author:  -->
	<!-- Date:  -->

<html lang="en">
<head>
	<meta charset='utf-8' />
    <meta name="author" content=""/>
	<meta name="description" content="Confirm Registration Page"/>
	<meta name="keywords" content="register,confirm"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<title>Registration Success</title>
	<link rel="icon" href="image/logo.png"/>
</head>

<body id="confirm">
	<div>
		<p style='color:green'><strong>You have successfully registered!</strong></p>
		<p><a href="login.php">Click here</a> to Sign In now</p>
	</div
</body>
</html>