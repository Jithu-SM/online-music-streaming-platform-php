<?php
// Include necessary configuration files and classes
include("includes/config.php");
include("includes/classes/User.php");

// Check if the artist is logged in
if(isset($_SESSION['artistLoggedIn'])) {

    $email=$_SESSION['artistLoggedIn'];
    
    
    $artistIdQuery = "SELECT id FROM artists WHERE email = '$email'";
    $artistIdResult = $con->query($artistIdQuery);

    if ($artistIdResult->num_rows > 0) {
        $row = $artistIdResult->fetch_assoc();
        $artistId = $row['id'];
    }

    // Query to get the total number of plays per song for the logged-in artist
    $sql = "SELECT title, plays FROM songs WHERE artist = $artistId";
    $result = $con->query($sql);

    // Query to get the total number of plays for the artist
    $totalPlaysSql = "SELECT SUM(plays) AS total_plays FROM songs WHERE artist = $artistId";
    $totalPlaysResult = $con->query($totalPlaysSql);
    $totalPlaysRow = $totalPlaysResult->fetch_assoc();
    $totalPlays = $totalPlaysRow['total_plays'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Artist Analytics - Your Plays</title>
    
</head>
<body>
<?php include("includes/artistnavBarContainer.php"); ?>
    <h1>Your Plays</h1>
    <?php if(isset($totalPlays)) : ?>
        <p>Total Plays: <?php echo $totalPlays; ?></p>
        <table border="1">
            <tr>
                <th>Title</th>
                <th>Plays</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row["title"]."</td>
                            <td>".$row["plays"]."</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No songs found for this artist</td></tr>";
            }
            ?>
        </table>
    <?php else : ?>
        <p>No artist found or no plays recorded yet.</p>
    <?php endif; ?>
    <div style="text-align: center; margin-top: 20px;">
        <a href="artistindex.php"><button style="padding: 10px 20px; background-color: #ffcd00; color: #1e1e1e; border: none; cursor: pointer; border-radius: 5px;">Go Back to Artist Index</button></a>
    </div>

    <!-- Other analytics representations or additional queries can be added here -->

</body>
</html>
