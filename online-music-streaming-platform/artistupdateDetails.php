<?php
include("includes/config.php");
include("includes/classes/ArtistProfile.php");



// Check if the form is submitted for updating password
if (isset($_POST['updatePassword'])) {
    $oldPassword = $_POST['oldPassword'];
    $newPassword1 = $_POST['newPassword1'];
    $newPassword2 = $_POST['newPassword2'];
    $artistLoggedIn = new ArtistProfile($con, $_SESSION['artistLoggedIn']);
    $artistLoggedIn->updatePassword($oldPassword, $newPassword1, $newPassword2); // Method for updating password
}
?>

<!-- Your HTML form -->


    <div class="container">
        <h2>UPDATE PASSWORD</h2>
        <form method="post" action="">
            <input type="password" class="oldPassword" name="oldPassword" placeholder="Current password">
            <input type="password" class="newPassword1" name="newPassword1" placeholder="New password">
            <input type="password" class="newPassword2" name="newPassword2" placeholder="Confirm password">
            <span class="message"></span>
            <button type="submit" class="button" name="updatePassword">SAVE</button>
        </form>
    </div>
</div>
