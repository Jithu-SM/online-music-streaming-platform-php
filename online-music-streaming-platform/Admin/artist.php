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

// View users
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // Modify your SQL query to include the search filter
    $sql_view = "SELECT * FROM artists WHERE name LIKE '%$search%'";
} else {
    $sql_view = "SELECT * FROM artists";
}
$result_view = $conn->query($sql_view);

// Add user
if(isset($_POST['add_artist'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql_add = "INSERT INTO artists (name, email, password) VALUES ('$name', '$email', '$password')";
    $conn->query($sql_add);
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Update user
if(isset($_POST['update_artist'])) {
    $id = $_POST['user_id'];
    $new_name = $_POST['new_name'];
    $new_email = $_POST['new_email'];
    $sql_update = "UPDATE artists SET name='$new_name', email='$new_email' WHERE id=$id";
    $conn->query($sql_update);
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Delete user
if(isset($_POST['delete_artist'])) {
    $id = $_POST['user_id'];
    $sql_delete = "DELETE FROM artists WHERE id=$id";
    $conn->query($sql_delete);
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
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
    <h1>Manage Artists</h1>

    <!-- Add User Form -->
    <h2>Add Artist</h2>
    <form method="post">
        Userame: <input type="text" name="name" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="add_artist" value="Add Artist">
    </form>
    <h2>Artists</h2>
    <!-- Search Form -->
   <form method="get">
        <label for="search">Search Artist:</label>
        <input type="text" name="search" id="search" placeholder="Enter username">
        <input type="submit" value="Search">
    </form>
</div>
    <!-- View Users -->
   
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result_view->num_rows > 0) {
            while($row = $result_view->fetch_assoc()) {
                echo "<tr>
                    <td>".$row["id"]."</td>
                    <td>".$row["name"]."</td>
                    <td>".$row["email"]."</td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='user_id' value='".$row["id"]."'>
                            <input type='text' name='new_name' placeholder='New Name'>
                            <input type='email' name='new_email' placeholder='New Email'>
                            <input type='submit' name='update_artist' value='Update'>
                            <input type='submit' name='delete_artist' value='Delete'>
                        </form>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No users found</td></tr>";
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
