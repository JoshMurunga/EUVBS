<?php

include 'DbConnect.php';
session_start();
$_SESSION['admin']='';
if(isset($_GET['del'])){
    $id=$_GET['del'];
    $query="delete from vehicles where vehicle_id='$id'";
	$res = mysql_query($query);
    if($res){
        echo 'delete successful';
        header("location:vehicleInfo.php");
    }else{
        echo 'delete unsuccessful';
    }
}
else if(isset ($_GET['dele'])){
    $driver_id=$_GET['dele'];
    $query1="delete from drivers where driver_id='$driver_id'";
	$resu = mysql_query($query1);
     if($resu){
        echo 'delete successful';
        header("location:driversinfo.php");
    }else{
        echo 'delete unsuccessful';
    }
}
else if(isset ($_GET['delete'])){
    $user_contact=$_GET['delete'];
	$uquery = "select user_type from users where user_contact='$user_contact'";
	$uresult = mysql_query($uresult);
	$urow = mysql_fetch_array($uresult);
	$type = $urow['user_type'];
	if($type=='admin'){
		$_SESSION['admin']='Administrator account cannot be deleted!'; 
		header("location:users.php");
		break;
	}
	else{
		$que="delete from users where user_contact='$user_contact'";
		$result = mysql_query($que);
		if($result){
			$_SESSION['admin']='Account Deleted Successfully';
			header("location:users.php");

		}
		else{
			$_SESSION['admin']='Account Was Not Deleted'; 
		}
	}
    
}
else if(isset($_GET['approve'])){
    $plate=$_GET['approve'];
	$mquery = "select availability from vehicles where number_plate='$plate'";
	$mresult = mysql_query($mquery);
	$row = mysql_fetch_array($mresult);
	$avail = $row['availability'];
	if($avail=='Y'){
		$quer="update vehicles set availability='N' where number_plate='$plate'";
		$resul = mysql_query($quer);
		if($resul){
			echo 'delete successful';
			header("location:maintenance.php");
		}
		else{
			echo 'delete unsuccessful';
		}
	}
	else{
		$quer="update vehicles set availability='Y' where number_plate='$plate'";
		$resul = mysql_query($quer);
		if($resul){
			echo 'delete successful';
			header("location:maintenance.php");
		}
		else{
			echo 'delete unsuccessful';
		}
	}
    
}
else if(isset($_GET['dapprove'])){
    $d_id=$_GET['dapprove'];
	$dquery = "select availability from drivers where driver_id='$d_id'";
	$dresult = mysql_query($dquery);
	$drow = mysql_fetch_array($dresult);
	$davail = $drow['availability'];
	if($davail=='Y'){
		$dquer="update drivers set availability='N' where driver_id='$d_id'";
		$dresul = mysql_query($dquer);
		if($dresul){
			echo 'delete successful';
			header("location:driversinfo.php");
		}
		else{
			echo 'delete unsuccessful';
		}
	}
	else{
		$dquer="update drivers set availability='Y' where driver_id='$d_id'";
		$dresul = mysql_query($dquer);
		if($dresul){
			echo 'delete successful';
			header("location:driversinfo.php");
		}
		else{
			echo 'delete unsuccessful';
		}
	}
}
else if(isset($_GET['cancel'])){
	$nplate = $_GET['cancel'];
	
	$squery = mysql_query("SELECT * FROM bookings WHERE vehicle_number_plate='$nplate'");
	$srow = mysql_fetch_array($squery);
	$driver_id = $srow['assigned_driver_id'];
	
	if($squery){
		$presult = mysql_query("UPDATE vehicles SET availability='Y' WHERE number_plate='$nplate'");
		
		if($presult){
			$sresult = mysql_query("UPDATE drivers SET availability='Y' WHERE driver_id='$driver_id'");
			
			if($sresult){
				$cquery = "delete from bookings where vehicle_number_plate='$nplate'";
				$cresult = mysql_query($cquery);
				
				if($cresult){
					header("location:cancelRequest.php");
				}
				else{
					echo 'delete unsuccessful';
				}
			}
		}
	}
}
else if(isset($_GET['pcancel'])){
	$request_id = $_GET['pcancel'];
	$pcquery = "delete from book_request where request_id='$request_id'";
	$pcresult = mysql_query($pcquery);
    if($pcresult){
        echo 'delete successful';
        header("location:cancelRequest.php");
    }else{
        echo 'delete unsuccessful';
    }
}
else if(isset($_GET['cance'])){
	$nplate = $_GET['cance'];
	
	$squery = mysql_query("SELECT * FROM bookings WHERE vehicle_number_plate='$nplate'");
	$srow = mysql_fetch_array($squery);
	$driver_id = $srow['assigned_driver_id'];
	
	if($squery){
		$presult = mysql_query("UPDATE vehicles SET availability='Y' WHERE number_plate='$nplate'");
		
		if($presult){
			$sresult = mysql_query("UPDATE drivers SET availability='Y' WHERE driver_id='$driver_id'");
			
			if($sresult){
				$cquery = "delete from bookings where vehicle_number_plate='$nplate'";
				$cresult = mysql_query($cquery);
				
				if($cresult){
					header("location:confirmedBooking.php");
				}
				else{
					echo 'delete unsuccessful';
				}
			}
		}
	}
}
?> 
