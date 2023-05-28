<?php

// Initializing variable from voterDatabase.html
$address = $_GET['address'];
$subject = "Decentralized Voting System Address Verification";
$body = "Your $address has been Successfully Authorized";
$sender = "Decentralized Voting System";

// connection to database
$conn = mysqli_connect('localhost', 'root', '');

// checking for connnection 
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // selecting database 
    $db = mysqli_select_db($conn, 'voter form submission');
    $addresses = $_COOKIE['address'];

    // updating database to set "Registered" to true for the given address
    $query = "UPDATE `$addresses` SET `Registered`= true WHERE Address = '$address'";
    if ($conn->query($query)) {
        echo '<script> alert("Record updated Successfully") </script>';
    } else {
        // error handling if query fails
        echo mysqli_error($conn);
        echo '<script> alert("Error updating record") </script>';
    }

    // getting email of the voter for sending verification email
    $query = "SELECT `Email` FROM `$addresses` WHERE Address='$address'";
    $result = mysqli_query($conn, $query);
    $email = mysqli_fetch_assoc($result);
    $receiver = $email["Email"];

    // sending email to the voter for address verification complete
    if (mail($receiver, $subject, $body, $sender)) {
        echo ("Verification Send Successfully");
        header("Location: ../../html/admin/voterAuth.php");
    } else {
        echo ("Sorry Failed to send mail, Try Again Later");
        header("Location: ../../html/admin/voterAuth.php");
    }

}
// closing database connection
$conn->close();
?>