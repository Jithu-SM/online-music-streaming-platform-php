<?php
	
	
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    
        include("includes/config.php");
        include("includes/classes/User.php");
        include("includes/classes/Artist.php");
        include("includes/classes/Album.php");
        include("includes/classes/Song.php");
        include("includes/classes/Playlist.php");
    
    
        if(isset($_GET['artistLoggedIn'])) {
            $artistLoggedIn = new ArtistProfile($con, $_GET['artistLoggedIn']);
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
        echo "<script>openPage('$url')</script>";
        exit();
    }
    $artistLoggedIn = new ArtistProfile($con, $_SESSION['artistLoggedIn']);
?>

<div class="entityInfo">
	
	<div class="centerSection">
		<div class="userInfo">
			<h1><?php echo $artistLoggedIn->getArtistname(); ?></h1>
		</div>
	</div>

	<div class="buttonItems">
		
		<button class="button" onclick="openPage('artistupdateDetails.php')">ARTIST DETAILS</button>
		<button class="button" onclick="logout()">LOGOUT</button>

	</div>

</div>