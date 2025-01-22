<?php
if(isset($_POST['loginButton'])) {
	//Login button was pressed
	$username = $_POST['loginUsername'];
	$password = $_POST['loginPassword'];

	$result = $account->login($username, $password);

	if($result == true) {
		$_SESSION['userLoggedIn'] = $username;
		header("Location: index.php");
	}

}

if(isset($_POST['artistloginButton'])) {
	//Login button was pressed
	$username = $_POST['loginemail'];
	$password = $_POST['loginPassword'];

	$result = $account->login($username, $password);

	if($result == true) {
		$_SESSION['artistLoggedIn'] = $username;
		header("Location: artistindex.php");
	}

}
?>