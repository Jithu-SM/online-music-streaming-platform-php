<?php
// Include necessary configuration files and classes
include("includes/includedFiles.php");

$user=$userLoggedIn->getUsername();
    // Query to fetch playlist information created by the logged-in user
    $playlistQuery = "SELECT id, name FROM playlists WHERE owner = '$user'";
    $playlistResult = $con->query($playlistQuery);

    if ($playlistResult->num_rows > 0) {
        // Display each playlist's songs
        while ($playlistRow = $playlistResult->fetch_assoc()) {
            $playlistId = $playlistRow['id'];
            $playlistName = $playlistRow['name'];

            echo "<h2>Playlist: $playlistName</h2>";

            // Query to fetch songs in the playlist
            $songsQuery = "SELECT songs.id, songs.title, artists.name 
            FROM songs 
            INNER JOIN playlistsongs ON songs.id = playlistsongs.songId 
            INNER JOIN artists ON songs.artist = artists.id 
            WHERE playlistId = $playlistId";
            $songsResult = $con->query($songsQuery);

            if ($songsResult->num_rows > 0) {
                echo "<ul>";
                
                while ($songRow = $songsResult->fetch_assoc()){
                    $songId = $songRow['id'];
                    $songTitle = $songRow['title'];
                    $artistName = $songRow['name'];
                
                echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $songId . "\", tempPlaylist, true)'>
					</div>
                    <div class='trackInfo'>
						<span class='trackName'>&#9;        " . $songTitle . "</span>
						<span class='artistName'>       " . $artistName . "</span>
					</div>";

                }
                echo "</ul>";
            } else {
                echo "<p>No songs found in this playlist.</p>";
            }
        }
    } else {
        echo "<p>No playlists found for this user.</p>";
    }
    

?>
