<?php
session_start();
// get wallet address from user input
$walletAddress = $_POST['walletAddress'];
//get voterID from session variable
$voterID = $_SESSION['voterID'];

//connection to database
$conn = mysqli_connect('localhost', 'root', '');
// get database name from cookie
$database = $_COOKIE['database'];;

//checking connection
if (!$conn) {
     // if connection failed, display error message and terminate script
    die("Connection failed: " . $conn->connect_error);
} else{
    // select database 
    $db = mysqli_select_db($conn, 'voter form submission');
    // update the 'Address' field in the appropriate row of the database with the user's wallet address
    $query = "UPDATE `{$database}` SET `Address`= '$walletAddress' WHERE VoterID='$voterID'";
    $conn->query($query);
    // display success message and redirect user to index page
    echo '<script>
        window.location.href = "../../index.html";
        alert("Your Wallet Address Has Been Successfully Registered");
        </script>';
}
// close database connection
$conn->close();
?>