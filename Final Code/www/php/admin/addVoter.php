<?php
session_start();

// Initializing variable from voterDatabase.html
$firstName = $_POST['firstName'];
$middleName = $_POST['middleName'];
$lastName = $_POST['lastName'];
$voterID = $_POST['voterID'];
$email = $_POST['email'];
$dob = $_POST['DOB'];

// connection to database
$conn = mysqli_connect('localhost', 'root', '');

// checking for connnection 
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // selecting the database to use
    $db = mysqli_select_db($conn, 'voter form submission');
    // getting the address of the election from the cookie set in the "voterDatabase.html" page
    $addresses = $_COOKIE['address'];
    // checking if the voter already exists in the database
    $query = "SELECT * FROM `{$addresses}` WHERE VoterID = $voterID";
    $query_run = $conn->query($query);
    $query_array = mysqli_fetch_array($query_run);
    if ($query_array > 0) {
        // redirecting to the "voterDatabase.html" page with an alert message if the voter already exists
        echo '<script>
        window.location.href = "../../html/admin/voterDatabase.html";
        alert("Voter Already Exists in Database");
        </script>';
    } else {
        // inserting new voter data into the database 
        $query = "INSERT INTO `{$addresses}` (`FirstName`, `MiddleName`, `LastName`, `VoterID`, `Email`, `DOB`, `Address`, `OTP`, `Registered`) VALUES ('$firstName','$middleName','$lastName','$voterID','$email','$dob',null,null,false)";
        $query_run = $conn->query($query);
        // redirecting to the "voterDatabase.html" page with an alert message if the voter has been successfully added
        echo '<script>
        window.location.href = "../../html/admin/voterDatabase.html";
        alert("Voter has been Successfully Added");
        </script>';
    }

}
$conn->close();
?>