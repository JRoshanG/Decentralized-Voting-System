<?php
// This script receives a JSON message from the front-end containing a voter ID and updates the database accordingly. 
// It also retrieves the corresponding voter's address from the database and returns it in JSON format
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

    // Retrieving the corresponding voter's address from the database
    $query = "SELECT  Address FROM `${addresses}` WHERE VoterID='$voterID'";
    $result = mysqli_query($conn, $query);
    $array = mysqli_fetch_assoc($result);
    $address = $array["Address"];

}
// Closing the database connection
$conn->close();

// Setting the response header to JSON format and returning the voter's address
header('Content-Type: application/json');
echo json_encode($address);
?>