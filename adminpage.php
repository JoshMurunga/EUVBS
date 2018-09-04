<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>EUVBS Administrator Home</title>
		<link rel="stylesheet" href="css/styles.css">
		<img src="images/egerton.png" width="1350" height="130" id="vehicleheader">
		<div class="head">
			Welcome<??> Administrator
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
	
	if( !isset($_SESSION['admin']) ) {
		header("Location: index.php");
		exit;
	}
	
	$_SESSION['loginInfo']='';
	
	if(isset($_POST['perform'])){
		$task = $_POST['Tasks'];
		if(empty($task)){//checking whether an option has been chosen
			$_SESSION['loginInfo']='No Operation Chosen' ;
		}
		else{
			switch ($task) {
				case "vehicle":
					header("location:vehicleInfo.php");
					break;
				case "drivers":
					header("location:driversInfo.php");
					break;
				case "maintenance":
					header("location:maintenance.php");
					break;
				case "bookings":
					header("location:confirmBooking.php");
					break;
				case "users":
					header("location:users.php");
					break;
				default:
					$_SESSION['loginInfo']='Invalid Choice Made';
					break;
			}
		}
	}
	?>
	
	<div id="bookings">
		<?php
		$bresult = mysql_query ("SELECT * FROM book_request");
		$bcount = mysql_num_rows($bresult);
		echo "Total Booking Request: $bcount<br><br>";
		
		$cresult = mysql_query ("SELECT * FROM bookings");
		$ccount = mysql_num_rows($cresult);
		echo "Total Confirmed Bookings: $ccount<br><br>";
		
		$vresult = mysql_query ("SELECT * FROM vehicles WHERE vehicles.availability='y'");
		$vcount = mysql_num_rows($vresult);
		echo "Total Available Vehicles: $vcount<br><br>";
		
		$dresult = mysql_query ("SELECT * FROM drivers WHERE drivers.availability='y'");
		$dcount = mysql_num_rows($dresult);
		echo "Total Available Drivers: $dcount<br><br>";
		
		$result = mysql_query ("SELECT * FROM users");
		$count = mysql_num_rows($result);
		echo "Total Registerd Users: $count";
		?>
		<div class="tasks">
			<form action="adminpage.php" method="POST"><br>  
				<h4>Select an Operation to Perform and Click GO:</h4>
				<select name="Tasks" >
					<option value="">---Select an Operation---</option>
					<option value="bookings">Confirm Bookings</option>
					<option value="vehicle">Add and Remove vehicles</option>
					<option value="maintenance">Mark vehicle(s) for maintenance</option>
					<option value="drivers">Add and Remove Drivers</option>				
					<option value="users">Remove Users</option>
				</select>
				<input type="submit" value="Go" name="perform" id="submit" /><br>
            </form>
            <span id="loginInfo"><strong><?=$_SESSION['loginInfo']?></strong></span>
		</div>
    </div>
	<?php ob_end_flush(); ?>
	</body>
</html>