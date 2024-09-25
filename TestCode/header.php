<header>
	<ul>
		<li id="prod"><img src="image/logo.png" alt="Logo"  width="70px" height="70px"/></li>
		<?php
			// Display if user is logged in
			if ((isset($_SESSION['fname'])) && (isset($_SESSION['lname']))){
				echo "<li><form action='login.php' method='post'><input type='submit' name='logout_button' value='LOGOUT'></form></li><li id='reg'>";
				
				// Display if the current page is NOT account page
				if (basename($_SERVER['PHP_SELF']) != "account.php"){
					
					echo "<a href='account.php'><img src='image/p_pic.png' alt='settings icon' width='30px' height='30px'/><span>".$_SESSION['fname']." ".$_SESSION['lname']."</span></a></li>
					";
					
				// Display if the current page IS account page
				} else {
					echo "<a href='dashboard.php'>Dashboard</a></li>";
				}
			// Display for visitor
			} else {
				echo "<li><a href='register.php'>Register</a></li>
		<li id='reg'><a href='login.php'>Sign in</a></li>";
			}
		?>
	</ul>
</header>