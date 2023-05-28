<?php
session_start();
//require 'mail.php';
// Initializing variable from form data
$firstName = $_POST['firstName'];
$middleName = $_POST['middleName'];
$lastName = $_POST['lastName'];
$_SESSION['voterID'] = $_POST['voterID'];
$dob = strval($_POST['DOB']);
$_SESSION['email'] = $_POST['email'];
$database = $_COOKIE['database'];
// connection to database
$conn = mysqli_connect('localhost', 'root', '');

//check database connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} else{
    $db = mysqli_select_db($conn, 'voter form submission');
    // Select voter data from the database 
    $query = "SELECT * FROM `{$database}` WHERE VoterID = '$_SESSION[voterID]'";
    $query_run = $conn->query($query);
    $query_array = mysqli_fetch_array($query_run);

    // Verify the given credentials
    if ($firstName == $query_array['FirstName'] and $middleName == $query_array['MiddleName'] 
    and $lastName ==$query_array['LastName'] and $dob == $query_array['DOB'] and $_SESSION['email'] == $query_array['Email']) {
        header("Location: mail.php"); // Redirect to mail.php if the credentials are vaild
        
    } else{
        // Redirect back to voterRegistration.php if the credentials are invalid
        echo '<script>
        window.location.href = "../../html/voterRegister/voterRegistration.php";
        alert("Invalid Credential Given, Try Again!!!");
        </script>';
        die();
    }
}
// Close database connection
$conn->close();
?>
