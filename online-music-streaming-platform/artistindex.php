
<?php 
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
include("includes/config.php");
include("includes/classes/User.php");


if(isset($_GET['artistLoggedIn'])) {
    $artistLoggedIn = new Artist($con, $_GET['artistLoggedIn']);

}
else {
    echo "Artist name variable was not passed into the page. Check the openPage JS function";
    exit();
}
}
else {
    include("includes/config.php");
    include("includes/classes/User.php");
	if(isset($_SESSION['artistLoggedIn'])) {
        $artistLoggedIn = new ArtistProfile($con, $_SESSION['artistLoggedIn']);
        $artistname = $artistLoggedIn->getEmail();
        echo "<script>artistLoggedIn = '$artistname';</script>";
    }
    else {
        header("Location: artistregister.php");
    }
	$url = $_SERVER['REQUEST_URI'];
	echo "<script>openPageArtist('$url')</script>";
	//exit();
	
}
?>

<html>
<head>
	<title>MUSIC | ARTIST PORTAL</title>
	<link rel="icon" href="../assets/images/icons/play.png" type="image/x-icon"/>
	<link rel="shortcut icon" href="../assets/images/icons/play.png" type="image/x-icon"/>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/script.js"></script>
</head>

<body>

	<div id="mainContainer">

		<div id="topContainer">

			<?php include("includes/artistnavBarContainer.php"); ?>

			<div id="mainViewContainer">

				<div id="mainContent">
				<div style="text-align: center;">
					<h2> Welecome Artist </h2>
    				<button onclick="location.href='release.php'" style="color: white; background-color: blue; border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 4px;">New Release</button>
					<br>
					<button onclick="location.href='analytics.php'" style="color: white; background-color: blue; border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 4px;">Analytics</button>

				</div>

                </div>


</div>

</div>

</div>

</body>

</html>