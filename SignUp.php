<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>EUVBS Registration</title>
		<link rel="stylesheet" href="css/styles.css">
    </head>
    <body id="body">
	<?php
	ob_start();
	session_start();

	include_once 'DbConnect.php';
	$error = false;
	
	if(isset($_POST['register'])){
		//clean up user's inputs to prevent sql injection attack
		$username = trim($_POST['username']);
		$username = strip_tags($username);
		$username = htmlspecialchars($username);
		
		$contact = trim($_POST['contact']);
		$contact = strip_tags($contact);
		$contact = htmlspecialchars($contact);
		
		$password = trim($_POST['password']);
		$password = strip_tags($password);
		$password = htmlspecialchars($password);

	
		//user's input validation
		//username
		if(strlen($username)<3){
			$error = true;
			$_SESSION['message']='Failed! Name must have atleat 3 characters.';
		}
		else if(!preg_match("/^[a-zA-Z ]+$/",$username)){
			$error = true;
			$_SESSION['message']='Failed! Name must contain at least alphabets and space.';
		}
	
		//contact
		if(strlen($contact)<10){
			$error = true;
			$_SESSION['message']='Failed! Contact must be atleast 10 digits.';
		}
		else if(strlen($contact)>10){
			$error = true;
			$_SESSION['message']='Failed! Contact cannot be more than 10 digits.';
		}
		else if(!is_numeric($contact)){
			$error = true;
			$_SESSION['message']='Failed! Contacts must be digits.';
		}
		else{
			$query = "SELECT user_contact FROM users WHERE user_contact='$contact'";
		
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
		
			if($count!=0){
				$error = true;
				$_SESSION['message']='Failed! Provided contact is already registerd.';
			}
		}
	
		//password
		if($_POST['password']==($_POST['confirmP'])){
			if(strlen($password) < 8){
				$error = true;
				$_SESSION['message']='Failed! Password must have atleast 8 characters.';
			}
		}
		else{
			$error = true;
			$_SESSION['message']='Failed! Two passwords do not match!';
		}
		
		if(!$error){
			//password encryption
			$pass = hash('sha256', $password);
	
			$query = "INSERT INTO users(user_name,user_contact,password) VALUES('$username','$contact','$pass')";
			$res = mysql_query($query);
			
			if ($res){
				$_SESSION['message']='Registration Successful! <a href="index.php">Log in</a> with your credentials';
			
				unset($username);
				unset($contact);
				unset($password);
			}
			else{
				$_SESSION['message']='Error! Something went wrong, please try again.';
			}
		}
	}
	
	?>

	<form action="SignUp.php" method="POST">
		<div class="signup">
			<h1>Registration</h1></br>
			<label for="user" class="sr-only">Username:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input type="text" name="username" id="user" placeholder="Enter Username" required /><br></br>
			<label for="contact" class="sr-only">Contact:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input type="text" name="contact" id="contact" placeholder="Enter Phone Number" required/><br></br>
			<label for="pass" class="sr-only">Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input type="password" name="password" id="pass" placeholder="Enter Password" required /><br></br>
			<label for="cPass" class="sr-only">Confirm Password:</label>
			<input type="password" name="confirmP" id="cPass" placeholder="Confirm Your Password" required /><br></br>
			<script>
				function ConfirmSubmit(){
					var x=confirm("Are you sure you want to submit your data");
					if(x)
						return true;
					else
						return false;
				}
			</script>
			<input type="submit" name="register" value="REGISTER" onclick="return ConfirmSubmit();"/><br></br>
			<div class="alert"><strong><?=$_SESSION['message']?></strong></div>
			<div id="login">Already Registered? Click here to <a href="index.php">Log in</a> to your account</div></br>
		</div>
	</form></br></br>
	<?php ob_end_flush(); ?>
	</body>
</html>