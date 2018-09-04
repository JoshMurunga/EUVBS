<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Vehicle Information</title>
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/tables.css">
		<img src="images/egerton.png" width="1350" height="130" id="vehicleheader">
		<div class="vehicleheader">Vehicle Information and the related operations</div>
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
	
	$error = false;
	
	if(isset($_POST['AddVehicle'])){
		$vehicle_type = $_POST['vehicle_type'];
		$number_plate = $_POST['number_plate'];
		$driver_id = $_POST['driver_id'];
		$capacity = $_POST['capacity'];
		$availability = $_POST['availability'];
		
		if(empty($vehicle_type)){
			$error = true;
			$_SESSION['message']='Failed! Please Select<br>Type of Vehicle.';
		}
		
		if(strlen($number_plate)<7){
			$error = true;
			$_SESSION['message']='Failed! Invalid Number<br>Plate.';
		}
		else{
			$query = "SELECT number_plate FROM vehicles WHERE number_plate='$number_plate'";
		
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
		
			if($count!=0){
				$error = true;
				$_SESSION['message']='Failed! Number Plate<br>Already Registered.';
			}
		}
		
		if(empty($vehicle_type)){
			$error = true;
			$_SESSION['message']='Failed! Please Select<br>Type of Vehicle.';
		}
		
		if(!is_numeric($capacity)){
			$error = true;
			$_SESSION['message']='Failed! Capacity must<br>be digits.';
		}
		
		if(empty($availability)){
			$error = true;
			$_SESSION['message']='Failed! Please Select<br>Vehicle Availability.';
		}
		
		if(!$error){
			$query = "INSERT INTO vehicles(vehicle_type,number_plate,driver_id,capacity,availability) VALUES('$vehicle_type','$number_plate','$driver_id','$capacity','$availability')";
			$res = mysql_query($query);
			
			if ($res){
				$_SESSION['message']='Success! You Have<br>Registered A New Vehicle.';
			}
			else{
				$_SESSION['message']='Error! Something went<br>wrong, please try again';
			}
		}
    }
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
                <th><div class="delete">Remove</div></th>
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
									var vehicle=confirm('Are You Sure You Want To Remove?');
									if(vehicle)
										return true;
									else
										return false;
								}
							</script>							
								<td>									
									<a href='delete.php? del=$row[vehicle_id]' id=deleteButton onclick='return ConfirmSubmitr();'><img src='images/delete.gif'></a>
								</td>							
						  </tr>";
				}
			}
			?>
		</table>
	</div>
	<div id="addvehicle">
		<div id="add">Register New Vehicle</div>
		<form action="vehicleInfo.php" method="POST">
			<label for="vehicle_type" id="input">Vehicle Type:</label>
			<select name="vehicle_type">
				<option value="">--Choose Vehicle Type--</option>
				<option value="Bus">Bus</option>
				<option value="Mini-Bus">Mini-Bus</option>
				<option value="Van">Van</option>
				<option value="Double-Cabin">Double-Cabin</option>
			</select><br><br>
			<label for="number_plate" id="input"> Number Plate:</label>
			<input type="text" name="number_plate" value="" placeholder="Enter Vehicle Number Plate" required/></br></br>
			<label for="driver_id" id="input">Driver Id:  </label>
			<select name="driver_id">
				<?php
				$presult = mysql_query("SELECT * FROM drivers");
				echo "<option value=''>--Choose Driver Id--</option>";
				while($prow = mysql_fetch_array($presult)){
					$driver_id = $prow['driver_id'];
					echo "<option value='$driver_id'>$driver_id</option>"; 
				}
				?>
			</select><br><br>
			<label for="capacity"id="input">Capacity:</label>
			<input type="text" name="capacity" value="" placeholder="Enter Capacity" /></br></br>
			<label for="availability" id="input">Availability:</label>
			<select name="availability">
				<option value="">--Select Availability--</option>
				<option value="Y">Yes</option>
				<option value="N">No</option>
			</select><br><br>
			<script>
				function ConfirmSubmit(){
					var vehicle=confirm("Add new Vehice?");
					if(vehicle)
						return true;
					else
						return false;
				}
			</script>
			<input type="submit" value="Add Vehicle" name="AddVehicle" id="addV" onclick="return ConfirmSubmit();"/></br>
			<div class="alert"><?=$_SESSION['message'];?></div>
		</form>
	</div>
	<?php ob_end_flush(); ?>	
    </body>
</html>