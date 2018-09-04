<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Maintenance Information</title>
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/tables.css">
		<img src="images/egerton.png" width="1350" height="130" id="vehicleheader">
		<div class="vehicleheader">Maintenance Information and the related operations</div>
		<div id="buttons">
			<form action="buttons.php" method="POST">
				<input type="submit" value="Go Back" name="back"/>
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
		<div id="add"><h1>Current Vehicles available</h1></div>
		<table border="1" width="700">
			<tr>
				<th>Vehicle Id</th>
                <th>Vehicle Type</th>
                <th>Number Plate</th>
                <th>Driver Id</th>
                <th>Capacity</th>
                <th>Availability</th>
                <th><div class="delete">Mark For/Release From Maintenance </div></th>
            </tr>
			<?php
			$result = mysql_query ("SELECT * FROM vehicles");
			$count = mysql_num_rows($result);
       
			if($count > 0){
				while($row = mysql_fetch_array($result)){
					$vehicle_id = $row['vehicle_id'];
					$vehicle_type = $row['vehicle_type'];
					$number_plate = $row['number_plate'];
					$driver_id = $row['driver_id'];
					$capacity = $row['capacity'];
					$availability = $row['availability'];
                        
					echo "<tr>
							<div class='tableCols'>
								<td>$vehicle_id</td>
								<td>$vehicle_type</td>
								<td>$number_plate</td>
								<td>$driver_id</td>
								<td>$capacity</td>
								<td>$availability</td>
							</div>
							<script>
								function ConfirmSubmitr(){
									var vehicle=confirm('Change Availability Status?');
									if(vehicle)
										return true;
									else
										return false;
								}
							</script>							
								<td>									
									<a href='delete.php? approve=$row[number_plate]' id=deleteButton onclick='return ConfirmSubmitr();'><img src='images/approve.gif'></a>
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