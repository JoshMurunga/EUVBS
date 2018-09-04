<html>
    <head>
        <meta charset="UTF-8">
        <title>PostPone Booking</title>
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/tables.css">
		<img src="images/egerton.png" width="1350" height="130" id="vehicleheader">
		<div class="vehicleheader">PostPone Booking</div>
		<div id="buttons">
			<form action="buttons.php" method="POST">
				<input type="submit" value="Go Back" name="cback"/>
				<input type="submit" value="Cancel a Requests" name="cancel"/>
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
	
	if(isset($_POST['postpone'])){
		$booking_id = $_POST['booking_id'];
		$date = $_POST['date'];
		
		if(empty($booking_id)){
			$error = true;
			$_SESSION['message']='Failed! Please Select<br>Your Booking Id.';
		}
		
		if(empty($date)){
			$error = true;
			$_SESSION['message']='Failed! Please Select<br>Date and Time.';
		}
		
		if(!$error){
			$query = "update bookings set date_of_trip='$date' where booking_id='$booking_id'";
			$res = mysql_query($query);
			
			if ($res){
				$_SESSION['message']='Success! You Have<br>PostPone Your Booking.';
			}
			else{
				$_SESSION['message']='Error! Something went<br>wrong, please try again';
			}
		}
	}
	?>
	
	<div class="table">
		<div id="add"><h1>Your Bookings</h1></div>
		<table border="1" width="700">
			<tr>
				<th>Booking Id</th>
				<th>Vehicle Number Plate</th>
                <th>No. of People</th>
				<th>Date and Time</th>
                <th>No. of Days</th>
				<th>Party</th>
            </tr>
			<?php
			$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
			$userRow=mysql_fetch_array($res);
			
			$dresult = mysql_query("SELECT * FROM bookings WHERE user_contact=".$userRow['user_contact']);
			$count = mysql_num_rows($dresult);
       
			if($count > 0){
				while($row = mysql_fetch_array($dresult)){
					$booking_id = $row['booking_id'];
					$vehicle_number_plate = $row['vehicle_number_plate'];
					$num_of_people = $row['num_of_people'];
					$date_of_trip = $row['date_of_trip'];
					$num_of_days = $row['num_of_days'];
					$party = $row['party'];
                        
					echo "<tr>
							<div class='tableCols'>
								<td>$booking_id</td>
								<td>$vehicle_number_plate</td>
								<td>$num_of_people</td>
								<td>$date_of_trip</td>
								<td>$num_of_days</td>
								<td>$party</td>
							</div>	
						 </tr>";
				}
			}
			?>
		</table>
	</div>
	<div id="addvehicle">
		<div id="add">PostPone Information</div>
		<form action="postponeRequest.php" method="POST">
			<label for="booking_id" id="input">Booking Id:  </label>
			<select name="booking_id">
				<?php
				$presult = mysql_query("SELECT booking_id FROM bookings WHERE user_contact=".$userRow['user_contact']);
				echo "<option value=''>--Select Booking Id--</option>";
				while($prow = mysql_fetch_array($presult)){
					$booking_id = $prow['booking_id'];
					echo "<option value='$booking_id'>$booking_id</option>"; 
				}
				?>
			</select><br><br>
			<label for="date" class="sr-only">Date and Time:</label>
			<input type="Text" id="demo1" name="date"  placeholder="Click Icon To Pick Date and Time"><br><a href="javascript:NewCal('demo1','yyyymmdd',true,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a><br><br>
			<script>
				function ConfirmSubmit(){
					var vehicle=confirm("PostPone To This Date?");
					if(vehicle)
						return true;
					else
						return false;
				}
			</script>
			<input type="submit" value="POSTPONE" name="postpone" id="addV" onclick="return ConfirmSubmit();"/></br></br>
			<div class="alert"><?=$_SESSION['message'];?></div>
		</form>
	</div>
	<?php ob_end_flush(); ?>	
    </body>
</html>