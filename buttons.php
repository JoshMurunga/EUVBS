<?php
include_once 'DbConnect.php';

if(isset($_POST['logout'])){
	session_start();
	session_destroy();
	header("Location:index.php");

}
else if(isset($_POST['back'])){
	header("Location:adminpage.php");
}
else if(isset($_POST['cbooking'])){
	header("Location:confirmedBooking.php");
}
else if(isset($_POST['back1'])){
	header("Location:confirmBooking.php");
}
else if(isset($_POST['cback'])){
	header("Location:booking.php");
}
else if(isset($_POST['pending'])){
	header("Location:pendingRequest.php");
}
else if(isset($_POST['confirmed'])){
	header("Location:confirmedRequest.php");
}
else if(isset($_POST['cancel'])){
	header("Location:cancelRequest.php");
}
else if(isset($_POST['postpone'])){
	header("Location:postponeRequest.php");
}
?>