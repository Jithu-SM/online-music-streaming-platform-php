
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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        p {
            color: #555;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Welcome, Admin<?php //echo $email; ?>!</h2>
    <p>This is the admin dashboard.</p>
   
    <h2>Add User</h2>
    <form action="add_user.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="firstname">First Name:</label>
        <input type="text" name="fname" required><br>
        <label for="lastname">Last Name:</label>
        <input type="text" name="lname" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Add User</button>
    </form>

    <h2>Add Artist</h2>
    <form action="add_artist.php" method="post">
        <label for="artist_name">Artist Name:</label>
        <input type="text" name="artist_name" required><br>
        <button type="submit">Add Artist</button>
    </form>

    <h2>Add Song</h2>
    <form action="add_song.php" method="post">
        <label for="title">Song Title:</label>
        <input type="text" name="title" required><br>
        <label for="artist_id">Artist ID:</label>
        <input type="text" name="artist_id" required><br>
        <button type="submit">Add Song</button>
    </form>
</body>
</html>

    <a href="logout.php">Logout</a>
</body>
</html>
