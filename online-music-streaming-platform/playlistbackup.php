<?php
include("includes/includedFiles.php");

// Check if the playlist ID is provided in the URL
$playlistId = isset($_GET['id']) ? $_GET['id'] : header("Location: index.php");

// Create an instance of the Playlist class
$playlist = new Playlist($con, $playlistId);

// Generate the playlist dropdown to add songs to other playlists
$playlistDropdown = Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Playlist Details</title>
    <!-- Add your CSS and other head elements -->
</head>
<body>

<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $playlist->getArtworkPath(); ?>" alt="Playlist Artwork">
    </div>
    <div class="rightSection">
        <h2><?php echo $playlist->getName(); ?></h2>
        <p>By <?php echo $playlist->getOwner(); ?></p>
        <p><?php echo $playlist->getNumberOfSongs(); ?> songs</p>
    </div>
</div>

<div class="tracklistContainer">
    <h2>Songs in the Playlist</h2>
    <ul class="tracklist">
        <?php foreach ($playlist->getSongIds() as $songId): ?>
            <?php $song = new Song($con, $songId); ?>
            <li class='tracklistRow'>
                <div class='trackInfo'>
                    <span class='trackName'><?php echo $song->getTitle(); ?></span>
                    <span class='artistName'><?php echo $song->getArtist()->getName(); ?></span>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="addSongToPlaylist">
    <h2>Add a Song to Another Playlist</h2>
    <?php echo $playlistDropdown; ?>
</div>

<!-- Other HTML content and scripts -->

</body>
</html>
