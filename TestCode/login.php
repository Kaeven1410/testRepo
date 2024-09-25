<?php
	$Msg = null;
	session_start();
	
	if (isset($_SESSION['fname'])){ // LOGOUT
		
		// Display multiple login error message
		if (!empty($_SESSION['error'])){
			$Msg = $_SESSION['error'];
		// Display logout message
		} else {
			$Msg = "<p style='color:green'><strong>Thank you for signing up!</strong></p>";
		}
		
		// renew or delete current session_id from database
		if (isset($_SESSION['session_id']) && (isset($_POST['logout_button']) || $_SESSION['timesup']) && $_SESSION['session_id'] != 'none'){
			
			// Display auto logout message
			if ($_SESSION['timesup']){
				$Msg = "<p style='color:red'>Your session has expired.</p>";
			}
			
			$conn = @mysqli_connect("localhost","root","") or die("Unable to connect to database.");
			@mysqli_select_db($conn,"cos20031_proj") or die ("Unable to select database");
			$sesID = $_SESSION['session_id'];
            
			$delSes = "UPDATE userlist SET session_id='none' WHERE session_id='$sesID'";
            
            // Execute query
            @mysqli_query($conn, $delSes);
           
			@mysqli_close($conn);
		}
		// remove all sessions value and destroy session
		unset($_SESSION['fname']);
		unset($_SESSION['lname']);
		unset($_SESSION['email']);
		unset($_SESSION['pass']);
		unset($_SESSION['id']);
		unset($_SESSION['error']);
		unset($_SESSION['time']);
		unset($_SESSION['timesup']);
		session_destroy();
		
	}else { // LOGIN
		$conn = @mysqli_connect("localhost","root","") or die("Unable to connect to database.");
		@mysqli_select_db($conn,"cos20031_proj") or die ("Unable to select database");
				
        if (isset($_POST["login_button"])){
			
            $id = $_POST['email'];
			$pass = hash('sha256',$_POST["password"]);
			
            // $chkEmail = "SELECT email FROM userlist WHERE email='$id';";
			
            $getUser = "SELECT * FROM userlist WHERE email='$id' AND pass='$pass'";
            
            // echo $getUser;
            // Execute query
            // $valid = @mysqli_query($conn, $chkEmail);
            $valid = @mysqli_query($conn, $getUser);
			
			// Check if Email input has been registered
			$row = 0;
			if ($valid){
				$row = @mysqli_num_rows($valid);
			}
			
			if ($row > 0){ // Obtain user data
				
				// $chkPass = "SELECT * FROM userlist WHERE email='$id';";
                
                // // Execute query
                // $result = @mysqli_query($conn, $chkPass);
				
				// $ori_pass = @mysqli_fetch_array($result);
                $dbUserData = @mysqli_fetch_array($valid);
                
				// Check if Password input matches with the one in database
				// if ($pass == $ori_pass['pass']){
					
                $_SESSION['fname'] = $dbUserData['fname'];
                $_SESSION['lname'] = $dbUserData['lname'];
                $_SESSION['email'] = $dbUserData['email'];
                $_SESSION['pass'] = $dbUserData['pass'];
                $_SESSION['id'] = $dbUserData['id'];
                $_SESSION['session_id'] = $dbUserData['session_id'];
                $_SESSION['time'] = $dbUserData['time'];
                // echo $_SESSION['session_id'];
                $id = $_SESSION['id'];
                
                // echo $_SESSION['email'];
                // Reset session_id if previous login session
                // did not logout for a long time
                if ((time()-$_SESSION['time'])>300 || (time()-$_SESSION['time'])<-300){
                    $dbUserData['session_id'] = "none";
                }
                
                // --- ADVANCE FEATURE ---
                // prevent multiple logins
                if ($dbUserData['session_id'] == "none"){
                    $sessionID = session_id();
                    $time = time();
                    
                    $updateSession = "UPDATE userlist SET session_id='$sessionID',time='$time' WHERE id='$id'";
                    
                    // Execute query
                    @mysqli_query($conn, $updateSession);
                    
                    $_SESSION['session_id'] = $sessionID;
                    $_SESSION['time'] = $time;
                }
                
                header("Location: dashboard.php");
				// } else {
					// $Msg = "<p style='color:red'><strong>Wrong password</strong></p>";
				// }
				
				// @mysqli_free_result($result);
			} else {
				$Msg = "<p style='color:red'><strong>Invalid username or password!</strong></p>";
			}
			@mysqli_free_result($valid);
		}
		@mysqli_close($conn);
		
	}
?>

<!DOCTYPE html>

	<!-- Description:  -->
	<!-- Author:  -->
	<!-- Date:  -->

<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Login Page"/>
	<meta name="keywords" content="login"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- CSP policy solution -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'none'; script-src 'self'; connect-src 'self'; img-src 'self'; style-src 'self';base-uri 'self';form-action 'self'">
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<title>Sign Up</title>
	<link rel="icon" href="image/logo.png"/>
</head>
<body class="register">

	<form method="post" action="login.php">
		<img src="image/logo.png" alt="Logo"  width="100%" height="100%"/>
		<h1>Sign In</h1>
		<fieldset>
			<table id="login">
				<tr>
				  <td><input type="text" name="email" placeholder="Email*" id="email"/></td>
				</tr>
				<tr>
				  <td><input type="password" name="password" placeholder="Password*"/></td>
				</tr>
			</table>
		</fieldset>
		<div>
			<input type="reset" value="Reset"/>
			<input type="submit" value="Login" name="login_button"/>
		</div>
	</form>
	<div>
		<?php echo $Msg; ?>
		<p>Haven't register?</br><a href="register.php">REGISTER</a></p>
	</div>
</body>
</html>