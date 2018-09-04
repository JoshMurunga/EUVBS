<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Users Information</title>
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/tables.css">
		<img src="images/egerton.png" width="1350" height="130" id="vehicleheader">
		<div class="vehicleheader">Users Information</div>
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
		<div id="add"><h1>Current Registered Users of The System</h1></div>
		<table border="1" width="700">
			<tr>
                <th>User Name</th>
                <th>User Contact</th>
                <th><div class="delete">Remove</div></th>
            </tr>
			<?php
			$result = mysql_query ("SELECT * FROM users");
			$count = mysql_num_rows($result);
       
			if($count > 0){
				while($row = mysql_fetch_array($result)){
					$username = $row['user_name'];
					$user_contact = $row['user_contact'];
                 
					echo "<tr>
							<div class='tableCols'>
								<td>$username</td>
								<td>$user_contact</td>
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
									<a href='delete.php? delete=$row[user_contact]' id=deleteButton onclick='return ConfirmSubmitr();'><img src='images/delete.gif'></a>
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