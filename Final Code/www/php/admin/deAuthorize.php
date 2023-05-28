<?php
// This script receives a JSON message from the front-end containing a voter ID and updates the database accordingly. 
$message = json_decode(file_get_contents('php://input'), true);

// Extracting the voter ID from the message
$voterID = $message['message'];

// Creating a connection to the database
$conn = mysqli_connect('localhost', 'root', '');

// Checking for connection errors
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // Selecting the database
    $db = mysqli_select_db($conn, 'voter form submission');
    $addresses = $_COOKIE['address'];

    // Updating the voter's registration status in the database to false
    $query = "UPDATE `$addresses` SET `Registered`=false WHERE VoterID='$voterID'";
    mysqli_query($conn, $query);

}
// Closing the database connection
$conn->close();

?>