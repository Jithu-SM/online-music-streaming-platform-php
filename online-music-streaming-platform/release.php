<?php

include("includes/config.php");
include("includes/classes/User.php");
 $artistLoggedIn = new ArtistProfile($con, $_SESSION['artistLoggedIn']);
 $artistname = $artistLoggedIn->getArtistname();
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

        #uploadform {
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

        input,
        select {
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
    <div  class="centerSection">
    <h2>Upload Music</h2>
</div>
<div id="uploadform">
<form action="release.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="title">Title</label>
	    <input id="title" name="title" type="text" placeholder="e.g. Song Title" value="" required>
	</p>
    <p>
        <label for="musicFile">Select Music File</label>
        <input type="file" name="musicFile" id="musicFile" accept=".mp3, .ogg, .wav" required>
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
<br>
<?php
$artistid=$artistLoggedIn->getArtistid();
$sql = "SELECT id, title FROM albums WHERE artist='$artistid'";
$result = $con->query($sql);

// Check if there are rows in the result set
if ($result->num_rows > 0) {
    echo "<label for='album'>Select Album:</label>";
    echo "<select name='album' id='album'>";
    echo "<option value=''>Select an album</option>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $categoryId = $row["id"];
        $categoryName = $row["title"];
        echo "<option value='$categoryId'>$categoryName</option>";
    }

    echo "</select>";
}
?>
</p>
        <input type="submit" value="Upload">
    </form>
</div>
<div style="text-align: center; margin-top: 20px;">
        <a href="createalbum.php"><button style="padding: 10px 20px; background-color: #ffcd00; color: #1e1e1e; border: none; cursor: pointer; border-radius: 5px;">Create an album</button></a>
    </div>

<div style="text-align: center; margin-top: 20px;">
        <a href="artistindex.php"><button style="padding: 10px 20px; background-color: #ffcd00; color: #1e1e1e; border: none; cursor: pointer; border-radius: 5px;">Go Back to Artist Index</button></a>
    </div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadDir = "assets/music/";

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir,0777,true);
    }

    $musicFile = $_FILES["musicFile"];

    $allowedExtensions = array("mp3", "ogg", "wav");
    $fileExtension = strtolower(pathinfo($musicFile["name"], PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        die("Error: Invalid file format. Allowed formats: " . implode(", ", $allowedExtensions));
    }

    $fileName = uniqid() . "." . $fileExtension;
    $destination = $uploadDir . $fileName;

    if (move_uploaded_file($musicFile["tmp_name"], $destination)) {
        // Database configuration
        $dbHost = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "musicdb";

        // Create a database connection
        $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $title=$_POST['title'];
        $artistid=$artistLoggedIn->getArtistid();
        $genre=$_POST['genre'];
        $album=$_POST['album'];
        function getAudioDurationInMinutes($filePath)
        {
            require_once('getid3/getid3.php');
        
            $getID3 = new getID3();
            $fileInfo = $getID3->analyze($filePath);
        
            if (isset($fileInfo['playtime_seconds'])) {
                $seconds = $fileInfo['playtime_seconds'];
        
                // Calculate minutes and remaining seconds
                $minutes = floor($seconds / 60);
                $remainingSeconds = $seconds % 60;
        
                // Format the result as minute:second
                $duration = sprintf('%02d:%02d', $minutes, $remainingSeconds);
        
                return $duration;
            } else {
                return false;
            }
        }
        
        // Example usage
        $duration = getAudioDurationInMinutes($destination);
        
        
        // Insert file path into the database
        $filePath = $destination; // Adjust this if the actual path is different
        $sql = "INSERT INTO songs (title,artist,album,genre,duration,path,plays) VALUES ('$title','$artistid','$album','$genre','$duration','$filePath','0')";

        if ($conn->query($sql) === TRUE) {
            echo "File uploaded and record inserted into the database successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "Error uploading file.";
    }
}
?>
