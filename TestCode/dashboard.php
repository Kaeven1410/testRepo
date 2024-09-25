<?php
	session_start();
	
	// prevent multiple logins
	if (!isset($_SESSION['session_id'])){
		
        header("Location: login.php");
	}
    
	
	// Auto logout user after 60 seconds of inactivity
	$_SESSION['timesup'] = false;
	if (isset($_SESSION['time']) && ((time()-$_SESSION['time'])>300)){
		$_SESSION['timesup'] = true;
		header("Location: login.php");
	} else { // Update time if still active
		$time = time();
		if (isset($_SESSION['email'])){
			$email = $_SESSION['email'];
		//}
		
            $conn = @mysqli_connect("localhost","root","") or die("Unable to connect to database.");
            @mysqli_select_db($conn,"cos20031_proj") or die ("Unable to select database");
            
            $update_session = "UPDATE userlist SET time='$time' WHERE email='$email'";
            
            // Execute query
            @mysqli_query($conn, $update_session);
            
            @mysqli_close($conn);
            $_SESSION['time'] = $time;
        }
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
	<meta name="description" content="Dashboard Page"/>
	<meta name="keywords" content="main"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title>Smart Property Management</title>
	<link rel="icon" href="image/logo.png"/>
</head>
<body>
	<?php include 'header.php'; ?>
	<article>
	<h1 id="here">Smart Property Management Dashboard</h1>
        <div style="margin: auto; text-align: center;">
		<ul id="prod_list">
			<li>
				<img src="image/module1.png" alt="module1" width="150%"/>
				<strong>Module 1</strong><br/>
			</li>
			<li>
				<img src="image/module2.png" alt="module2"/>
				<strong>Module 2</strong><br/>
			</li>
			<li>
				<img src="image/module3.png" alt="module3"/>
				<strong>Module 3</strong><br/>
			</li>
			
			
		</ul>
        </div>
	</article>
	<footer>
		<p>2024 &bull; <a href="contactus.php">Contact Us</a></p>
	</footer>
</body>
</html>