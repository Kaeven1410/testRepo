<?php 
	session_start(); 
	
	// Auto logout user after 15 minutes
	$_SESSION['timesup'] = false;
	if (isset($_SESSION['time'])){
		if((time()-$_SESSION['time'])>300){
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
	}
?>

<!DOCTYPE html>

	<!-- Description:  -->
	<!-- Author:  -->
	<!-- Date:  -->
	

<html lang="en">

<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Contact Us Page"/>
	<meta name="keywords" content="contact,student"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<title>Contacts</title>
	<link rel="icon" href="image/logo.png"/>
</head>

<body>
	<?php include 'header.php'; ?>
	<article id="contact">
		<h1>Contact Us</h1>
		<p><strong>Author:</strong> </p>
		<p><strong>Student ID:</strong> </p>
		<p><strong>Email:</strong> </p>
		
		<p id="disclaimer"><em>This website is created mainly for educational and non-commercial use only. It is a partial fulfillment for completion of unit COS20031 Computing Technology Design Project offered in Swinburne University of Technology, Sarawak Campus. The web-master and author(s) do not represent the business entity. The content of the pages of this website might be outdated or inaccurate, thus, the author(s) and web-master does not take any responsibility for incorrect information disseminated or cited from this website.</em></p>
	</article>
	<footer id="contact_f">
		<p><a href="dashboard.php">&lt;&lt; Back to Dashboard</a></p>
	</footer>
</body>

</html>