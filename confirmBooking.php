<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Confirm Booking</title>
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/tables.css">
		<img src="images/egerton.png" width="1350" height="130" id="vehicleheader">
		<div class="vehicleheader">Confirm Bookings</div>
		<div id="buttons">
			<form action="buttons.php" method="POST">
				<input type="submit" value="Go Back" name="back"/>
				<input type="submit" value="View Confirmed Bookings" name="cbooking"/>
				<input type="submit" value="Log Out" name="logout"/>
			</form>
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
	
	$_SESSION['message']='';
	
	$error = false;
	
	if(isset($_POST['confirm'])){
		$request_id = $_POST['request_id'];
		$number_plate = $_POST['number_plate'];
		$driver_id = $_POST['driver_id'];
		
		if(empty($request_id)){
			$error = true;
			$_SESSION['message']='Failed! Please Select<br>Request Id.';
		}
		
		if(empty($number_plate)){
			$error = true;
			$_SESSION['message']='Failed! Please Select<br>Vehicle No. Plate.';
		}
		
		if(empty($driver_id)){
			$error = true;
			$_SESSION['message']='Failed! Please Select<br>Driver Id.';
		}
		
		if(!$error){
			$fresult = mysql_query("SELECT * FROM book_request WHERE request_id='$request_id'");
			$frow = mysql_fetch_array($fresult);
			
			$user_contact = $frow['user_contact'];
			$no_of_people = $frow['no_of_people'];
			$date_of_trip = $frow['date_of_trip'];
			$num_of_days = $frow['num_of_days'];
			$party = $frow['party'];
			
			if($fresult){
				$iresult = mysql_query("INSERT INTO bookings (vehicle_number_plate,assigned_driver_id,date_of_trip,num_of_days,user_contact,party,num_of_people) VALUES ('$number_plate','$driver_id','$date_of_trip','$num_of_days','$user_contact','$party','$no_of_people')");
				
				if($iresult){
					$zresult = mysql_query("DELETE FROM book_request WHERE request_id='$request_id'");
					
					if($zresult){
						$aresult = mysql_query("UPDATE vehicles SET availability='N' WHERE number_plate='$number_plate'");
						
						if($aresult){
							$dresult = mysql_query("UPDATE drivers SET availability='N' WHERE driver_id='$driver_id'");
							
							if($dresult){
								$_SESSION['message']='Success! Booking Confirmed';
							}
						}
					}
				}
			}
		}
	}
	?>
	
	<div class="table">
		<div id="add"><h1>Current Booking Requests</h1></div>
		<table border="1" width="700">
			<tr>
				<th>Req ID</th>
				<th>User Contact</th>
                <th>No. of People</th>
                <th>Date and Time</th>
                <th>No. of Days</th>
                <th>Party</th>
            </tr>
			<?php
			$result = mysql_query ("SELECT * FROM book_request ORDER BY date_of_trip asc");
			$count = mysql_num_rows($result);
       
			if($result){
				while($row = mysql_fetch_array($result)){
					$request_id = $row['request_id'];
					$user_contact = $row['user_contact'];
					$no_of_people = $row['no_of_people'];
					$date_of_trip = $row['date_of_trip'];
					$num_of_days = $row['num_of_days'];
					$party = $row['party'];
				
					echo "<tr>";
					echo	"<div class='tableCols'>";
					echo		"<td>$request_id</td>";
					echo		"<td>$user_contact</td>";
					echo		"<td>$no_of_people</td>";
					echo		"<td>$date_of_trip</td>";
					echo		"<td>$num_of_days</td>";
					echo		"<td>$party</td>";
					echo	"</div>";
					echo "</tr>";
				}
			}
			?>
		</table>
	</div>
	<div id="addvehicle">
		<div id="add">Confirm Booking Info.</div>
		<form action="confirmBooking.php" method="POST">
			<label for="request_id" id="input">Request Id:</label>
			<select name="request_id">
				<?php
				$rresult = mysql_query("SELECT * FROM book_request");
				echo "<option value=''>--Select Request Id--</option>";
				while($rrow = mysql_fetch_array($rresult)){
					$request_id = $rrow['request_id'];
					echo "<option value='$request_id'>$request_id</option>"; 
				}
				?>
			</select><br><br>
			<label for="number_plate" id="input"> Number Plate:</label>
			<select name="number_plate">
				<?php
				$nresult = mysql_query("SELECT * FROM vehicles");
				echo "<option value''>--Select Vehicle No. Plate--</option>";
				while($nrow = mysql_fetch_array($nresult)){
					$availability = $nrow['availability'];
					if($availability=='Y'){
						$number_plate = $nrow['number_plate'];
						echo "<option value'$number_plate'>$number_plate</option>";
					}
				}
				?>
			</select><br><br>
			<label for="driver_id" id="input">Driver Id:  </label>
			<select name="driver_id">
				<?php
				$presult = mysql_query("SELECT * FROM drivers");
				echo "<option value=''>--Choose Driver Id--</option>";
				while($prow = mysql_fetch_array($presult)){
					$davailability = $prow['availability'];
					if($davailability=='Y'){
						$driver_id = $prow['driver_id'];
						echo "<option value='$driver_id'>$driver_id</option>"; 
					}
				}
				?>
			</select><br><br>
			<script>
				function ConfirmSubmit(){
					var vehicle=confirm("Confirm This Booking?");
					if(vehicle)
						return true;
					else
						return false;
				}
			</script>
			<input type="submit" value="CONFIRM" name="confirm" id="addV" onclick="return ConfirmSubmit();"/></br>
			<div class="alert"><?=$_SESSION['message'];?></div>
		</form>
	</div>
	<?php ob_end_flush(); ?>	
    </body>
</html>