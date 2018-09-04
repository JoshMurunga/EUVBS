<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>EUVBS</title>
		<link rel="stylesheet" href="css/styles.css">
    </head>
    <body id="body">
	<?php
	ob_start();
	session_start();
	include_once 'DbConnect.php';

	$_SESSION['message']='';
	
	$error = false;
	
	if(isset($_POST['login'])){
		//clean up user's inputs to prevent sql injection attack
		$contact = trim($_POST['contact']);
		$contact = strip_tags($contact);
		$contact = htmlspecialchars($contact);
		
		$password = trim($_POST['password']);
		$password = strip_tags($password);
		$password = htmlspecialchars($password);
		
		if(empty($contact)){
			$error = true;
			$_SESSION['message']='Enter Contact' ;
		}
		else if(!is_numeric($contact)){
			$error = true;
			$_SESSION['message']='Contacts must be digits.';
		}
		
		if(empty($password)){
			$error = true;
			$_SESSION['message']='Enter Password.';
		}
		
		if(!$error){
			$pass = hash('sha256', $password);
			
			$query = "SELECT * FROM users WHERE user_contact='$contact' and password='$pass'";
			$result = mysql_query ($query);
			$row = mysql_fetch_array($result);
			$count = mysql_num_rows($result);
			
			if ($count==1){
				$user_type = $row['user_type'];
				if($user_type=='admin'){
					$_SESSION['admin'] = $row['user_id'];
					header("Location: adminpage.php");
				}
				else{
					$_SESSION['user'] = $row['user_id'];
					header("Location: booking.php");
				}
			}
			else{
				$_SESSION['message']='Invalid Credentials.';
			}
		}
	}
	?>
	
	<div class="loginpage">
        <form action="index.php" method="POST" autocomplete="off">
			<div id="title"><body><img src="images/egertonlogo.jpg" id="logo">Egerton University Vehicle Booking System(EUVBS): </br></br>Member Login</div>
            <label for="contact" class="sr-only">Contact:&nbsp;&nbsp;&nbsp;</label>
			<input type="text" name="contact" id="contact" placeholder="Enter Your Phone Number" size="30" required/><br><br>
            <label for="pass" class="sr-only">Password:</label>
			<input type="password" name="password" id="pass" placeholder="Enter Your Password" size="30" required/><br><br>
            <input type="submit" name="login" value="Log in"/>
            <div id="info" ><strong><?=$_SESSION['message']?></strong></div>
            <div id="register">Click here to <a href="SignUp.php">Register</a> an account</div></br>
        </form></br>
    </div>
	<?php ob_end_flush(); ?>	
    </body>
</html>