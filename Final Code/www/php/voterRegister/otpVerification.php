
<?php
// // This is a PHP script that starts a session, connects to a database, and retrieves the OTP from the database for the current voter. 
// It then compares the OTP entered by the voter on the previous page with the OTP retrieved from the database. 
// If the OTPs match, the script redirects the user to the "walletAddress.html" page, otherwise, 
// it displays an error message and redirects the user to the "mail.php" page.
session_start();
// connection to database
$conn = mysqli_connect('localhost', 'root', '');
$database = $_COOKIE['database'];;

//checking connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} else{
    $db = mysqli_select_db($conn, 'voter form submission'); // selecting database
    $query = "SELECT `OTP` FROM `{$database}` WHERE VoterID = '$_SESSION[voterID]'"; // creating query to get OTP
    $query_run = $conn->query($query); // executing query
    $query_array = mysqli_fetch_array($query_run); 
    $otpNumber = $query_array['OTP']; // extracting OTP from Number
    $otp = $_POST['otpNumber']; // Getting OTP from the Form 

    if ($otpNumber == $otp) { // Comaprision of Form and Generated OTP
        header("Location: ../../html/voterRegister/walletAddress.html"); // Redirect to wallet address form
    }else { // Try Again
        echo '<script>
        window.location.href = "mail.php";
        alert("Invalid Credential Given, Try Again!!!");
        </script>';
    }
}
$conn->close(); // Close connection
?>
