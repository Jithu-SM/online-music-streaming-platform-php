<?php

include("includes/config.php");
include("includes/classes/User.php");
 $artistLoggedIn = new ArtistProfile($con, $_SESSION['artistLoggedIn']);
 $artistname = $artistLoggedIn->getArtistname();
 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['createAlbum'])) {
    // Handle album creation
    $albumTitle = $_POST['albumTitle'];
    $artistid = $artistLoggedIn->getArtistid();
    $genre = $_POST['genre'];
// Handle cover art upload
$artworkDir = "assets/images/artwork/";
if (!file_exists($artworkDir)) {
    mkdir($artworkDir, 0777, true);
}

$artworkFile = $_FILES["artwork"];
$allowedImageExtensions = array("jpg", "jpeg", "png", "gif");
$imageExtension = strtolower(pathinfo($artworkFile["name"], PATHINFO_EXTENSION));

if (in_array($imageExtension, $allowedImageExtensions)) {
    $artworkFileName = uniqid() . "." . $imageExtension;
    $artworkDestination = $artworkDir . $artworkFileName;
    move_uploaded_file($artworkFile["tmp_name"], $artworkDestination);

    // Insert album details into the database
    $sql = "INSERT INTO albums (title, artist, genre, artworkPath) 
            VALUES ('$albumTitle', '$artistid', '$genre', '$artworkDestination') 
            ON DUPLICATE KEY UPDATE title='$albumTitle', artist='$artistid', genre='$genre', artworkPath='$artworkDestination'";
    if ($con->query($sql) === TRUE) {
        echo "Album created/updated successfully. ";
    } else {
        echo "Error creating/updating album: " . $con->error;
    }
}
 }

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Upload</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/register.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .centerSection {
            text-align: center;
            margin-top: 20px;
        }

        #createAlbumForm {
            max-width: 500px;
            margin: 20px auto;
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #555;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #444;
            color: #fff;
        }

        input[type="file"] {
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container button {
            padding: 10px 20px;
            background-color: #ffcd00;
            color: #1e1e1e;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .button-container a {
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="centerSection">
        <h2>Create Album</h2>
    </div>
    <div id="createAlbumForm">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <p>
                <label for="albumTitle">Album Title</label>
                <input id="albumTitle" name="albumTitle" type="text" placeholder="e.g. Album Title" value="" required>
            </p>
            <p>
            <?php
    $sql = "SELECT id, name FROM genres";
$result = $con->query($sql);

// Check if there are rows in the result set
if ($result->num_rows > 0) {
    echo "<label for='genre'>Select Genre:</label>";
    echo "<select name='genre' id='genre'>";
    echo "<option value=''>Select a genre</option>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $categoryId = $row["id"];
        $categoryName = $row["name"];
        echo "<option value='$categoryId'>$categoryName</option>";
    }

    echo "</select>";
}
?>
            </p>
            <p>
                <label for="artwork">Select Cover Art</label>
                <input type="file" name="artwork" id="artwork" accept="image/*" required>
            </p>
            <p>
                <input type="submit" name="createAlbum" value="Create Album">
            </p>
        </form>
    </div>
<div style="text-align: center; margin-top: 20px;">
        <a href="artistindex.php"><button style="padding: 10px 20px; background-color: #ffcd00; color: #1e1e1e; border: none; cursor: pointer; border-radius: 5px;">Go Back to Artist Index</button></a>
    </div>
</body>
</html>
