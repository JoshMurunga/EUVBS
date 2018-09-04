<html>
    <head>
        <meta charset="UTF-8">
        <title>Confirmed Booking</title>
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/tables.css">
		<img src="images/egerton.png" width="1350" height="130" id="vehicleheader">
		<div class="vehicleheader">Confirmed Bookings</div>
		<div id="buttons">
			<form action="buttons.php" method="POST">
				<input type="submit" value="Go Back" name="back1"/>
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
	
	
	?>
	
	<div class="table">
		<div id="add"><h1>Current Confirmed Bookings</h1></div>
		<table border="1" width="700">
			<tr>
				<th>Booking Id</th>
				<th>User Contact</th>
				<th>Vehicle Number Plate</th>
                <th>Assigned Driver Id</th>
                <th>No. of People</th>
				<th>Date and Time</th>
                <th>No. of Days</th>
				<th>Party</th>
				<th><div class="delete">Remove</div></th>
            </tr>
			<?php
			$result = mysql_query ("SELECT * FROM bookings");
			$count = mysql_num_rows($result);
       
			if($count > 0){
				while($row = mysql_fetch_array($result)){
					$booking_id = $row['booking_id'];
					$user_contact = $row['user_contact'];
					$vehicle_number_plate = $row['vehicle_number_plate'];
					$assigned_driver_id = $row['assigned_driver_id'];
					$num_of_people = $row['num_of_people'];
					$date_of_trip = $row['date_of_trip'];
					$num_of_days = $row['num_of_days'];
					$party = $row['party'];
                        
					echo "<tr>
							<div class='tableCols'>
								<td>$booking_id</td>
								<td>$user_contact</td>
								<td>$vehicle_number_plate</td>
								<td>$assigned_driver_id</td>
								<td>$num_of_people</td>
								<td>$date_of_trip</td>
								<td>$num_of_days</td>
								<td>$party</td>
							</div>
							<script>
								function ConfirmSubmitr(){
									var rem=confirm('Are You Sure You Want To Remove?');
									if(rem)
										return true;
									else
										return false;
								}
							</script>							
								<td>									
									<a href='delete.php? cance=$row[vehicle_number_plate]' id=deleteButton onclick='return ConfirmSubmitr();'><img src='images/delete.gif'></a>
								</td>
						  </tr>";
				}
			}
			?>
		</table>
	</div>
	<?php ob_end_flush(); ?>	
    </body>
</html>