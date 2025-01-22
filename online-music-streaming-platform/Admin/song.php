<?php
// Replace these variables with your MySQL database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "musicdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// View songs
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // Modify your SQL query to include the search filter
    $sql_view = "SELECT * FROM songs WHERE title LIKE '%$search%'";
} else {
    $sql_view = "SELECT * FROM songs";
}

$result_view = $conn->query($sql_view);


// Update song
if(isset($_POST['update_song'])) {
    $id = $_POST['id'];
    $new_name = $_POST['new_name'];
    $sql_update = "UPDATE songs SET title='$new_name' WHERE id=$id";
    $conn->query($sql_update);
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Delete song
if(isset($_POST['delete_song'])) {
    $id = $_POST['id'];
    $sql_delete = "DELETE FROM songs WHERE id=$id";
    $conn->query($sql_delete);
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Songs</title>
    <style>
        body {
            background-color: #222;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2 {
            color: #ffa500;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px;
        }
        th {
            background-color: #444;
        }
        tr:nth-child(even) {
            background-color: #333;
        }
        form {
            margin-bottom: 10px;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="submit"] {
            padding: 5px;
            margin-right: 10px;
        }
        input[type="submit"] {
            background-color: #ffa500;
            border: none;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #ff8000;
        }
        .form-container {
            width: 50%; /* Adjust the width as needed */
            margin: 0 auto;
            text-align: center;
        }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"],
        .form-container input[type="submit"] {
            display: block;
            width: calc(100% - 20px);
            margin: 10px auto;
        }

        .form-container input[type="submit"] {
            width: auto;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1>Manage Songs</h1>

   <!-- Search Form -->
   <form method="get">
        <label for="search">Search Song Title:</label>
        <input type="text" name="search" id="search" placeholder="Enter title">
        <input type="submit" value="Search">
    </form>
</div>
    <!-- View Songs -->
    <h2>Songs</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Play</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result_view->num_rows > 0) {
            while($row = $result_view->fetch_assoc()) {
                $audio_path = '/music/' . $row["path"];
                echo "<tr>
                    <td>".$row["id"]."</td>
                    <td>".$row["title"]."</td>
                    <td><audio controls><source src='".$audio_path."' type='audio/mpeg'></audio></td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='id' value='".$row["id"]."'>
                            <input type='text' name='new_name' placeholder='New Title'>
                            <input type='submit' name='update_song' value='Update'>
                            <input type='submit' name='delete_song' value='Delete'>
                        </form>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No songs found</td></tr>";
        }
        ?>
    </table>
    <button onclick="goToDashboard()">Go Back to Dashboard</button>
    <script>
        function goToDashboard() {
            window.location.href = "dashboard.php"; // Replace with your dashboard page URL
        }
    </script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
