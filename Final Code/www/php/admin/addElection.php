<?php
// The purpose of the script is to add a new election address to a database table named 'electionaddress' and create a new table in the database with the given election address as its name.

$electionName = $_POST['electionName']; // get the value of 'electionName' from the form submission
$electionAddress = $_POST['electionAddress']; // get the value of 'electionAddress' from the form submission

// establish connection to database
$conn = mysqli_connect('localhost', 'root', '');

// check if the connection is established or not
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $db = mysqli_select_db($conn, 'voter form submission'); // select the database
    $query = "SELECT * FROM `electionaddress` WHERE 'Election Address' = '$electionAddress'"; // query to check if election address already exists
    $query_run = $conn->query($query); // execute the query
    $query_array = mysqli_fetch_array($query_run); // fetch the result of the query
    if ($query_array > 0) { // if election address already exists
        echo '<script>
        window.location.href = "../../html/admin/voterDatabase.html";
        alert("Election Address already Exists in Database");
        </script>';
    } else {
        $query = "INSERT INTO `electionaddress`(`Election Name`, `Election Address`) VALUES ('$electionName','$electionAddress')"; // insert election name and address into the database
        $query_run = $conn->query($query); // execute the query
        $query = "CREATE TABLE `$electionAddress` (
            FirstName text,
            MiddleName text,
            LastName text,
            VoterID int PRIMARY KEY,
            Email text,
            DOB date,
            Address text NULL,
            OTP int(11) NULL,
            Registered tinyint(1)
          )"; // create table for the election using the election address as table name
        $query_run = $conn->query($query); // execute the query

        echo '<script>
        window.location.href = "../../html/admin/voterDatabase.html";
        alert("Election Address has been Successfully Added");
        </script>';
    }

}
$conn->close(); // close the database connection
?>