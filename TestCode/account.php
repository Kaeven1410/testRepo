<?php
	session_start();
	
	// Auto logout user after 60 seconds of inactivity
	$_SESSION['timesup'] = false;
	if (isset($_SESSION['time']) && ((time()-$_SESSION['time'])>300)){
		$_SESSION['timesup'] = true;
		header("Location: login.php");
	} else { // Update time if still active
		$time = time();
		if (isset($_SESSION['email'])){
			$email = $_SESSION['email'];
		}
		
		$conn = @mysqli_connect("localhost","root","") or die("Unable to connect to database.");
		@mysqli_select_db($conn,"cos20031_proj") or die ("Unable to select database");
		
        $update_session = "UPDATE userlist SET time='$time' WHERE email='$email'";
		
		// Execute query
        @mysqli_query($conn, $update_session);
		
		@mysqli_close($conn);
		$_SESSION['time'] = $time;
	}
	
	$passErr = $emailErr = "";
	
	$current_user = $_SESSION['id'];
	
	$fname = $_SESSION['fname'];
	$lname = $_SESSION['lname'];
	$email = $_SESSION['email'];
	$pass = $_SESSION['pass'];
	
	// Prevent non-registered user from accessing website
	if (!(isset($_SESSION['fname']))){
		header("Location: login.php");
	} else {
		$conn = @mysqli_connect("localhost","root","") or die("Unable to connect to database.");
		@mysqli_select_db($conn,"cos20031_proj") or die ("Unable to select database");
		
		// Update first name and last name
		if (isset($_POST['e_name'])){
			if (!empty($_POST['lname']) && !empty($_POST['fname'])){
				
                $fname = $_POST['fname'];
				$lname = $_POST['lname'];
				
                $query = "UPDATE userlist SET fname='$fname', lname='$lname' WHERE id='$current_user'";
				
                // Execute query
                @mysqli_query($conn, $query);
				
				$_SESSION['fname'] = $fname;
				$_SESSION['lname'] = $lname;
			}
		// Update password
		} elseif (isset($_POST['e_pass'])){
			
			// Check if all input is filled
			if (!empty($_POST['current_pass']) && !empty($_POST['new_pass']) && !empty($_POST['confirm_pass'])){
				
				$cur_p = hash('sha256',$_POST['current_pass']);
				
                $query = "SELECT pass FROM userlist WHERE id='$current_user'";
				
                // Execute query
                $pass_exist = @mysqli_query($conn, $query);
				
				if ($pass_exist){
					$ori_pass = mysqli_fetch_array($pass_exist);
					
					// Check whether current password input is correct
					if ($ori_pass['pass'] == $cur_p){
						
						// Check if NEW Passwords match
						if ($_POST['new_pass'] == $_POST['confirm_pass']){
							$new_pass = hash('sha256',$_POST['new_pass']);
							$query = "UPDATE userlist SET pass='$new_pass' WHERE id='$current_user'";
							
							@mysqli_query($conn,$query) or die("Unable to update Password");
							
							$_SESSION['pass'] = $pass ;
							
							$passErr = "<p style='color:green'>Password changed!</p>";
						} else {
							$passErr = "<p style='color:red'>New and Confirm password do not match!</p>";
						}
					} else {
						$passErr = "<p style='color:red'>Wrong current password!</p>";
					}
				}
			}
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
	<meta charset='utf-8' />
    <meta name="author" content=""/>
	<meta name="description" content="Account Page"/>
	<meta name="keywords" content="account,user,edit,settings"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<title>Smart Property Management - <?php echo $fname." ".$lname ?></title>
	<link rel="icon" href="image/logo.png"/>
</head>
<body id="acc">
	<?php include 'header.php'; ?>
	<br/>
	<div>
		<img src="image/p_pic.png" alt="Profile picture"/>
		<h2><?php echo $fname." ".$lname; ?></h2>
		<p><?php echo $email; ?></p>
	</div>
	<form method="post" action="account.php" id="account">
			<fieldset>
				<legend>Personal Information</legend>
				<div>
					<?php
					if (isset($_POST['username'])){
						echo "<p>First name: <input type='text' name='fname' value='$fname'/>
						<p> Last name: <input type='text' name='lname' value='$lname'/></p>
						<input type='submit' value='Change' name='e_name'/>";
					} else {
						echo "<p>Name: ".$fname." ".$lname." <input type='submit' value='Edit Username' name='username' id='edit_name'/></p>";
					}
					?>
				</div>
			</fieldset>
			<fieldset>
				<legend>Change Password</legend>
				<p>Current Password:</p>
				<input type="password" name="current_pass"/>
				<p>New Password:</p>
				<input type="password" name="new_pass"/>
				<p>Confirm Password:</p>
				<input type="password" name="confirm_pass"/>
				<?php echo $passErr; ?>
				<p><input type="submit" value="Save Password" name="e_pass"/></p>
			</fieldset>
	</form>
	<footer>
		<p>2024 &bull; <a href="contactus.php">Contact Us</a></p>
	</footer>
</body>
</html>