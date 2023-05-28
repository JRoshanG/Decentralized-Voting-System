<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.36/dist/web3.min.js"></script>
    <script src="../../js/admin/adminAuth.js"></script>
    <script src="../../dist/adminPanel.js"></script>
    <link rel="stylesheet" href="../../css/admin/admin.css">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <!-- Navigation Menu Bar to move Between Pages -->
    <ul>
        <li style="float:left;"><a href="adminPanel.php">Nepal Online DApp Voting System</a></li>
        <li><a href="../../index.html" style="margin-right: 25px;">Exit</a></li>
        <li><a href="electionSummary.php">Election Summary</a></li>
        <li><a href="voterDatabase.html">Voter Database</a></li>
        <li><a href="voterAuth.php" style="color: antiquewhite;">Voter Authorize</a></li>
        <li><a href="adminPanel.php">Election </a></li>
    </ul>

    <h1 class="title">Authorize Voter Address</h1>
    <table>
        <!-- The code first checks if there is a cookie named 'address' set, and if so, it connects to a MySQL database and
     retrieves the Voter ID and Address for all voters who are registered as 'false' and whose address is not null. -->
        <?php
        if (isset($_COOKIE['address'])) {


            // The code retrieves the voters names and addresses from a MySQL database using PHP. It then stores the retrieved data in an array called $voters.
            $conn = mysqli_connect('localhost', 'root', '');
            if (!$conn) {
                die("Connection failed: " . $conn->connect_error);
            } else {
                $db = mysqli_select_db($conn, 'voter form submission');
                $addresses = $_COOKIE['address'];
                $query = "SELECT VoterID, Address FROM `{$addresses}` WHERE Registered=false and Address IS NOT NULL";

                $result = mysqli_query($conn, $query);
                $voters = array();
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $voters[] = array("voterID" => $row["VoterID"], "address" => $row["Address"]);
                    }
                }
            }
            ?>
            <!-- a table is created with three columns: Voter ID, Voter Address, and Authorize Voter. 
            Each row of the table corresponds to a voter returned from the database query. 
            The Authorize Voter column contains a button that when clicked calls a JavaScript function 'bundle.authorizeAddress()' 
            and passes the voter's address as a parameter. -->
            <tr>
                <th>Voter ID</th>
                <th>Voter Address</th>
                <th>Authorize Voter</th>
            </tr>
            <?php
            foreach ($voters as $voter) {
                ?>
                <tr>
                    <td>
                        <?php echo $voter["voterID"]; ?>
                    </td>
                    <td>
                        <?php echo $voter["address"]; ?>
                    </td>
                    <td><button type="button" style="background-color: #4CAF50; padding: 8px 24px; float: left;"
                            onclick="bundle.authorizeAddress('<?php echo $voter["address"]; ?>')">Authorize
                            Address</button></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>

</body>

</html>