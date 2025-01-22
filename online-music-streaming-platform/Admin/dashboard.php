<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
}

$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 10px;
        }

        p {
            color: #ccc;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        a:hover {
            background-color: #45a049;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }
    </style>
</head>
<body background="../assets/images/music.jpg">
    <header>
        <h1>Welcome, Admin </h1>
    </header>
    
    <div class="container">
        <p>Welcome to admin dashboard.</p>
       
        <h2><a href="user.php">Manage Users</a></h2>
        <h2><a href="artist.php">Manage Artists</a></h2>
        <h2><a href="song.php">Manage Songs</a></h2>
        <h2><a href="genre.php">Manage Genres</a></h2>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
