<?php
include '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];

    $sql = "INSERT INTO users (username, firstName, lastName, email, password) VALUES ('$username', '$fname', '$lname', '$email', '$password')";
    $result = $con->query($sql);

    if ($result) {
        echo 'User added successfully.';
    } else {
        echo 'Error adding user: ' . $conn->error;
    }
}
