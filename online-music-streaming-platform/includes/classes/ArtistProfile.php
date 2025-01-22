<?php
class ArtistProfile {
    private $con;
    private $email;

    public function __construct($con, $email) {
        $this->con = $con;
        $this->email = $email;
    }

    // Method to update email
    public function updateEmail($newEmail) {
        $query = $this->con->prepare("UPDATE artists SET email = ? WHERE email = ?");
        $query->bind_param("si", $newEmail, $this->email);
        $query->execute();
        // Additional error handling and success message if required
    }

    // Method to update password
    public function updatePassword($oldPassword, $newPassword1, $newPassword2) {
        // Implement logic to update password, perform validation, and execute SQL query
        if($newPassword1==$newPassword2)
        {
            $sql_update = "UPDATE artists SET password='$newPassword1' WHERE email='$this->email'";
            $this->con->query($sql_update);}
    }
    public function getArtistid() {
        $query = mysqli_query($this->con, "SELECT id FROM artists WHERE email='$this->email'");
        $row = mysqli_fetch_array($query);
        return $row['id'];
    }

    // Other methods for fetching data, etc.
}
?>