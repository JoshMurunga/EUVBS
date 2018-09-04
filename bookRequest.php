<html>
    <head>
        <meta charset="UTF-8">
        <title>Book</title>
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/tables.css">
		<img src="images/egerton.png" width="1350" height="130" id="vehicleheader">
		<div class="vehicleheader">Booking</div>
		<div id="buttons">
			<form action="buttons.php" method="POST">
				<input type="submit" value="Go Back" name="cback"/>
				<input type="submit" value="Cancel a Requests" name="cancel"/>
				<input type="submit" value="PostPone a Requests" name="postpone"/>
				<input type="submit" value="View Pending Requests" name="pending"/>
				<input type="submit" value="View Confirmed Requests" name="confirmed"/>
				<input type="submit" value="Log Out" name="logout"/>
			</form>
		</div>
		<script language="javascript" type="text/javascript" src="script/datetimepicker.js"></script>
    </head>
    <body id="body">
	<?php
	ob_start();
	session_start();
	include_once 'DbConnect.php';
	
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	
	$_SESSION['message']='';

	$error = false;
	
	if(isset($_POST['book'])){
		$user_contact = $_POST['user_contact'];
		$no_of_people = $_POST['no_of_people'];
		$date = $_POST['date'];
		$days = $_POST['days'];
		$party = $_POST['party'];
		
		if(!is_numeric($user_contact)){
			$error = true;
			$_SESSION['message']='Failed! Contact<br>must be digits.';
		}
		if(strlen($user_contact)<10){
			$error = true;
			$_SESSION['message']='Failed! Contact<br>must be 10 digits.';
		}
		if(strlen($user_contact)>10){
			$error = true;
			$_SESSION['message']='Failed! Contact<br>must be 10 digits.';
		}
		else{
			$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
			$userRow=mysql_fetch_array($res);
			
			if($user_contact==$userRow['user_contact']){
				$query = "SELECT user_contact FROM users WHERE user_contact=".$userRow['user_contact'];
				$result = mysql_query($query);
				$count = mysql_num_rows($result);
		
				if($count==0){
					$error = true;
					$_SESSION['message']='Failed! Enter Correct<br>Contact.';
				}
			}
			else{
				$error = true;
				$_SESSION['message']='Failed! This Is Not<br> Your Contact.';
			}
			
		}
		
		if(!is_numeric($no_of_people)){
			$error = true;
			$_SESSION['message']='Failed! No. of<br>people must be digits.';
		}
		
		if(!is_numeric($days)){
			$error = true;
			$_SESSION['message']='Failed! No. of Days<br> must be digits.';
		}
		
		if(!$error){
			$query = "INSERT INTO book_request(user_contact,no_of_people,date_of_trip,num_of_days,party) VALUES('$user_contact','$no_of_people','$date','$days','$party')";
			$res = mysql_query($query);
			
			if ($res){
				$_SESSION['message']='Success! You Have<br>Submitted a Request.';
			}
			else{
				$_SESSION['message']='Error! Something went<br>wrong, please try again';
			}
		}
	}
	?>
	
	<form action="bookRequest.php" method="POST">
		<div class="signup">
			<h1>Booking Information</h1></br>
			<label for="user_contact" class="sr-only">Contact:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input type="text" name="user_contact" id="u_id" placeholder="Enter Your Contact" required /><br></br>
			<label for="no_of_people" class="sr-only">No. of People:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input type="text" name="no_of_people" id="n_people" placeholder="Enter Number of People" required/><br></br>
			<label for="date" class="sr-only">Date and Time:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input type="Text" id="demo1" name="date"  placeholder="Click Icon To Pick Date and Time"><a href="javascript:NewCal('demo1','yyyymmdd',true,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a><br><br>
			<label for="days" class="sr-only">No. of Days:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input type="text" name="days" id="n_days" placeholder="Enter Number of Days" required /><br></br>
			<label for="party" class="sr-only">Party:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<select name="party">
				<option value="">--Select Party--</option>
				<option value="Students">Students</option>
				<option value="Lecturers">Lecturers</option>
				<option value="Staff">Staff</option>
			</select><br><br>
			<script>
				function ConfirmSubmit(){
					var x=confirm("Are you sure you want to submit your data");
					if(x)
						return true;
					else
						return false;
				}
			</script>
			<input type="submit" name="book" value="REQUEST" onclick="return ConfirmSubmit();"/><br></br>
			<div class="alert"><strong><?=$_SESSION['message']?></strong></div>
		</div>
	</form></br></br>
	<?php ob_end_flush(); ?>	
    </body>
</html>