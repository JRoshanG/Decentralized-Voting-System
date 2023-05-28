<?php
// This is a PHP script for deleting a voter record from a database.

session_start(); // starting the PHP session

// Initializing variable from voterDatabase.html
$voterID = $_POST['voterID']; // getting voter ID from a form

// connection to database
$conn = mysqli_connect('localhost', 'root', '');

// checking for connnection 
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $db = mysqli_select_db($conn, 'voter form submission'); // selecting the database
    $addresses = $_COOKIE['address']; // getting the table name from a cookie
    $query = "SELECT * FROM `{$addresses}` WHERE VoterID = $voterID"; // creating a query to check if the voter record exists
    $query_run = $conn->query($query); // executing the query
    $query_array = mysqli_fetch_array($query_run); // fetching the result of the query

    if ($query_array == 0) { // if the query result is empty
        echo '<script>
        window.location.href = "../../html/admin/voterDatabase.html";
        alert("Voter does not Exist...");
        </script>';
        // redirect to the admin page and show an error message
    } else {
        $query = "DELETE FROM `{$addresses}` WHERE VoterID=$voterID"; // creating a query to delete the voter record
        $query_run = $conn->query($query); // executing the query
        echo '<script>
        window.location.href = "../../html/admin/voterDatabase.html";
        alert("Voter has been Successfully Removed...");
        </script>';
        // redirect to the admin page and show a success message
    }

}
$conn->close(); // closing the database connection
?>