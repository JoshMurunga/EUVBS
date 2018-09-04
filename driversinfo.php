<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Driver Information</title>
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/tables.css">
		<img src="images/egerton.png" width="1350" height="130" id="vehicleheader">
		<div class="vehicleheader">Driver Information and the related operations</div>
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
	
	if(isset($_POST['add_driver'])){
		$driver_id = $_POST['driver_id'];
		$driver_name = $_POST['driver_name'];
		$driver_contact = $_POST['driver_contact'];
		$availability = $_POST['availability'];
		
		if(!is_numeric($driver_id)){
			$error = true;
			$_SESSION['message']='Failed! Driver ID<br>must be digits.';
		}
		else{
			$query = "SELECT driver_id FROM drivers WHERE driver_id='$driver_id'";
		
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
		
			if($count!=0){
				$error = true;
				$_SESSION['message']='Failed! Driver ID<br> Already Exist.';
			}
		}
		
		if(strlen($driver_name)<3){
			$error = true;
			$_SESSION['message']='Failed! Name must have<br>atleat 3 characters.';
		}
		else if(!preg_match("/^[a-zA-Z ]+$/",$driver_name)){
			$error = true;
			$_SESSION['message']='Failed! Name must contain<br> at least alphabets and space.';
		}
		
		if(!is_numeric($driver_contact)){
			$error = true;
			$_SESSION['message']='Failed! Contacts<br>must be digits.';
		}
		else{
			$query = "SELECT driver_contact FROM drivers WHERE driver_contact='$driver_contact'";
		
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
		
			if($count!=0){
				$error = true;
				$_SESSION['message']='Failed! Driver With That<br>Contact Already Exist.';
			}
		}
		
		if(empty($availability)){
			$error = true;
			$_SESSION['message']='Failed! Please Select<br>Vehicle Availability.';
		}
		
		if(!$error){
			$query = "INSERT INTO drivers(driver_id,driver_name,driver_contact,availability) VALUES('$driver_id','$driver_name','$driver_contact','$availability')";
			$res = mysql_query($query);
			
			if ($res){
				$_SESSION['message']='Success! You Have<br>Registered A New Driver.';
			}
			else{
				$_SESSION['message']='Error! Something went<br>wrong, please try again';
			}
		}
	}
	?>
	
	<div class="table">
		<div id="add"><h1>Current Drivers available</h1></div>
		<table border="1" width="700">
			<tr>
				<th>Driver Id</th>
                <th>Driver Name</th>
                <th>Driver Contact</th>
                <th>Availability</th>
				<th><div class="delete">Change Availability</div></th>
                <th><div class="delete">Remove</div></th>
            </tr>
			<?php
			$result = mysql_query ("SELECT * FROM drivers");
			$count = mysql_num_rows($result);
       
			if($count > 0){
				while($row = mysql_fetch_array($result)){
					$driver_id = $row['driver_id'];
					$driver_name = $row['driver_name'];
					$driver_contact = $row['driver_contact'];
					$availability = $row['availability'];
                        
					echo "<tr>
							<div class='tableCols'>
								<td>$driver_id</td>
								<td>$driver_name</td>
								<td>$driver_contact</td>
								<td>$availability</td>
							</div>
							<script>
								function ConfirmSubmitc(){
									var vehicle=confirm('Change Availability Status?');
									if(vehicle)
										return true;
									else
										return false;
								}
							</script>							
								<td>									
									<a href='delete.php? dapprove=$row[driver_id]' id=deleteButton onclick='return ConfirmSubmitc();'><img src='images/approve.gif'></a>
								</td>
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
									<a href='delete.php? dele=$row[driver_id]' id=deleteButton onclick='return ConfirmSubmitr();'><img src='images/delete.gif'></a>
								</td>							
						  </tr>";
				}
			}
			?>
		</table>
	</div>
	<div id="addvehicle">
		<div id="add">Register New Driver</div>
		<form action="driversinfo.php" method="POST">
			<label for="driver_id" id="input">Driver Id:</label>
			<input type="text" name="driver_id" value="" placeholder="Enter Driver Id" required/></br></br>
			<label for="driver_name" id="input">Driver Name:</label>
			<input type="text" name="driver_name" value="" placeholder="Enter Driver Name" required/></br></br>
			<label for="driver_contact"id="input">Driver Contact:</label>
			<input type="text" name="driver_contact" value="" placeholder="Enter Driver Contact" required/></br></br>
			<label for="availability" id="input">Availability:</label>
			<select name="availability">
				<option value="">--Select Availability--</option>
				<option value="Y">Yes</option>
				<option value="N">No</option>
			</select><br><br>
			<script>
				function ConfirmSubmit(){
					var vehicle=confirm("Add New Driver?");
					if(vehicle)
						return true;
					else
						return false;
				}
			</script>
			<input type="submit" value="Add Driver" name="add_driver" id="addV" onclick="return ConfirmSubmit();"/></br></br>
			<div class="alert"><?=$_SESSION['message'];?></div>
		</form>
	</div>
	<?php ob_end_flush(); ?>	
    </body>
</html>