<?php
session_start();

// Generating a random number
$otp = rand(0, 999999);

$voterID = $_SESSION['voterID'];
$receiver = $_SESSION['email'];
$subject = "Decentralized Voting System Verification Code";
$body = "Your Verification Code is $otp";
$sender = "Decentralized Voting System";
$database = $_COOKIE['database'];;

//connection to database
$conn = mysqli_connect('localhost', 'root', '');

//checking connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} else{
    // selecting the database 
    $db = mysqli_select_db($conn, 'voter form submission');
    // updating OTP in database
    $query = "UPDATE `{$database}` SET `OTP`= $otp WHERE VoterID='$voterID'";
    $conn->query($query);
}   

// sending email
if (mail($receiver, $subject, $body, $sender)){
    header("Location: ../../html/voterRegister/otpVerification.html");
}else{
    echo ("Sorry Failed to send mail, Try Again Later");
    header("Location: ../../html/voterRegister/voterRegistration.php");
}
$conn->close();
?>