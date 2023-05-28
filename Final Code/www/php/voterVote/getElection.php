
<?php
// // This code is a PHP script that receives a POST request with a JSON payload containing a message. 
// It then extracts the voter's name and address from a database and checks if the address exists in any election addresses stored in the database. 
// If it does, it adds the election address to an array and sends it back as a JSON response
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON payload from the request
    $json_data = file_get_contents('php://input');
    $payload = json_decode($json_data, true);
    // Extract the address from the payload
    $address = $payload['message'];

    // Code to Extract Voter Name and Address from Database

    // Establish a connection to the database
    $conn = mysqli_connect('localhost', 'root', '');
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $db = mysqli_select_db($conn, 'voter form submission'); // Select the database 
        // Query the election addresses from the database
        $query = "SELECT `Election Name`, `Election Address` FROM `electionaddress` WHERE 1";
        // If there are results, loop through them
        $result = mysqli_query($conn, $query);
        $i = 0;
        $voterAddress = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $electionAddress = $row["Election Address"];
                // Query the voter's address in each election database
                $voterQuery = "SELECT * FROM `$electionAddress` WHERE Address = '$address'";
                $voterResult = mysqli_query($conn, $voterQuery);
                // If the voter's address exists in the election database, add it to the array
                if (mysqli_num_rows($voterResult) > 0) {
                    $voterAddress[$i] = $electionAddress;
                    $i = $i + 1;
                }
            }
            // Send the election addresses that match the voter's address as a JSON response
            echo json_encode($voterAddress);
        }

    }
}
// Close the database connection
mysqli_close($conn);

?>