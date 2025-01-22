<?php
include("../../config.php");
if(!isset($_POST['artistname'])) {
	echo "ERROR: Could not set artist name";
	exit();

}


if(isset($_POST['email']) && $_POST['email'] != "") {
	$artistname = $_POST['artistname'];
	$email = $_POST['email'];

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "Email is invalid";
		exit();
	}

	$emailCheck = mysqli_query($con, "SELECT email FROM artists WHERE email = '$email' AND name != '$artistname'");
	if(mysqli_num_rows($emailCheck) > 0) {
		echo "Email is already in use";
		exit();
	}

	$updateQuery = mysqli_query($con, "UPDATE artists SET email = '$email' WHERE name = '$artistname'");
	echo "Update successful";
}
else {
	echo "You must provide an email";
}

?>