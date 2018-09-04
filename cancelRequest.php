<html>
    <head>
        <meta charset="UTF-8">
        <title>Cancel Booking</title>
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/tables.css">
		<img src="images/egerton.png" width="1350" height="130" id="vehicleheader">
		<div class="vehicleheader">Cancel Booking</div>
		<div id="buttons">
			<form action="buttons.php" method="POST">
				<input type="submit" value="Go Back" name="cback"/>
				<input type="submit" value="PostPone a Requests" name="postpone"/>
				<input type="submit" value="View Pending Requests" name="pending"/>
				<input type="submit" value="View Confirmed Requests" name="confirmed"/>
				<input type="submit" value="Log Out" name="logout"/>
			</form>
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
	?>
	
	<div class="table">
		<div id="add"><h1>Your Confirmed Bookings</h1></div>
		<table border="1" width="700">
			<tr>
				<th>Book Id</th>
				<th>Contact</th>
				<th>Vehicle No. Plate</th>
                <th>Assigned Driver Id</th>
                <th>No. of People</th>
				<th>Date and Time</th>
                <th>No. of Days</th>
				<th>Party</th>
				<th><div class="delete">Cancel Booking</div></th>
            </tr>
			<?php
			$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
			$userRow=mysql_fetch_array($res);
			
			$dresult = mysql_query("SELECT * FROM bookings WHERE user_contact=".$userRow['user_contact']);
			$dcount = mysql_num_rows($dresult);
			
			if($dcount > 0){
				while($drow = mysql_fetch_array($dresult)){
					$booking_id = $drow['booking_id'];
					$user_contact = $drow['user_contact'];
					$vehicle_number_plate = $drow['vehicle_number_plate'];
					$assigned_driver_id = $drow['assigned_driver_id'];
					$num_of_people = $drow['num_of_people'];
					$date_of_trip = $drow['date_of_trip'];
					$num_of_days = $drow['num_of_days'];
					$party = $drow['party'];
                        
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
									var rem=confirm('Are You Sure You Want To Cancel?');
									if(rem)
										return true;
									else
										return false;
								}
							</script>							
								<td>									
									<a href='delete.php? cancel=$drow[vehicle_number_plate]' id=deleteButton onclick='return ConfirmSubmitr();'><img src='images/delete.gif'></a>
								</td>
						  </tr>";
				}
			}
			?>
		</table>
	</div>
	
	<div class="table">
		<div id="add"><h1>Your Pending Requests</h1></div>
		<table border="1" width="700">
			<tr>
				<th>Request Id</th>
				<th>Contact</th>
                <th>Number of People</th>
				<th>Date and Time</th>
                <th>Number of Days</th>
				<th>Party</th>
				<th><div class="delete">Cancel Booking</div></th>
            </tr>
			<?php
			$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
			$userRow=mysql_fetch_array($res);
			
			$dresult = mysql_query("SELECT * FROM book_request WHERE user_contact=".$userRow['user_contact']);
			$dcount = mysql_num_rows($dresult);
			
			if($dcount > 0){
				while($prow = mysql_fetch_array($dresult)){
					$request_id = $prow['request_id'];
					$user_contact = $prow['user_contact'];
					$no_of_people = $prow['no_of_people'];
					$date_of_trip = $prow['date_of_trip'];
					$num_of_days = $prow['num_of_days'];
					$party = $prow['party'];
                        
					echo "<tr>
							<div class='tableCols'>
								<td>$request_id</td>
								<td>$user_contact</td>
								<td>$no_of_people</td>
								<td>$date_of_trip</td>
								<td>$num_of_days</td>
								<td>$party</td>
							</div>
							<script>
								function ConfirmSubmitr(){
									var rem=confirm('Are You Sure You Want To Cancel?');
									if(rem)
										return true;
									else
										return false;
								}
							</script>							
								<td>									
									<a href='delete.php? pcancel=$prow[request_id]' id=deleteButton onclick='return ConfirmSubmitr();'><img src='images/delete.gif'></a>
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