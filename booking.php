<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>EUVBS Home</title>
		<link rel="stylesheet" href="css/styles.css">
		<img src="images/egerton.png" width="1350" height="130" id="vehicleheader">
		<div class="head">
			Welcome<??>
			<div id="logout">
				<form action="AdminLogout.php" method="POST">
					<input type="submit" value="Log Out" name="logout"/>
				</form>
			</div>
		</div>	
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
	
	if(isset($_POST['perform'])){
		$task = $_POST['Tasks'];
		if(empty($task)){//checking whether an option has been chosen
			$_SESSION['message']='No Operation Chosen' ;
		}
		else{
			switch ($task) {
				case "book":
					header("location:bookRequest.php");
					break;
				case "cancel":
					header("location:cancelRequest.php");
					break;
				case "postpone":
					header("location:postponeRequest.php");
					break;
				case "pending":
					header("location:pendingRequest.php");
					break;
				case "confirm":
					header("location:confirmedRequest.php");
					break;
				default:
					$_SESSION['message']='Invalid Choice Made';
					break;
			}
		}
	}
	?>
	
	<div id="bookings">
		<?php
		$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
		$userRow=mysql_fetch_array($res);
		
		$bresult = mysql_query ("SELECT * FROM book_request WHERE user_contact=".$userRow['user_contact']);
		$bcount = mysql_num_rows($bresult);
		echo "Your Pending Requests: $bcount<br><br>";
		
		$cresult = mysql_query ("SELECT * FROM bookings WHERE user_contact=".$userRow['user_contact']);
		$ccount = mysql_num_rows($cresult);
		echo "Your Confirmed Bookings: $ccount<br><br>";
		?>
		<div class="tasks">
			<form action="booking.php" method="POST"><br>  
				<h4>Select an Operation to Perform and Click GO:</h4>
				<select name="Tasks" >
					<option value="">---Select an Operation---</option>
					<option value="book">Request a Booking</option>
					<option value="cancel">Cancel a Booking</option>
					<option value="postpone">PostPone a Booking</option>
					<option value="pending">Pending Requests</option>				
					<option value="confirm">Confirmed Requests</option>
				</select>
				<input type="submit" value="Go" name="perform" id="submit" /><br>
            </form>
            <span id="message"><strong><?=$_SESSION['message']?></strong></span>
		</div>
    </div>
	<?php ob_end_flush(); ?>
	</body>
</html>