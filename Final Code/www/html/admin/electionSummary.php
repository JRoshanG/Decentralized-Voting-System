<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.36/dist/web3.min.js"></script>
    <script src="../../js/admin/adminAuth.js"></script>
    <link rel="stylesheet" href="../../css/admin/admin.css">
    <script src="../../dist/adminPanel.js"></script>

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
        <li><a href="electionSummary.php" style="color: antiquewhite;">Election Summary</a></li>
        <li><a href="voterDatabase.html">Voter Database</a></li>
        <li><a href="voterAuth.php">Voter Authorize</a></li>
        <li><a href="adminPanel.php">Election </a></li>
    </ul>

    <!-- 
The election details table includes the election name, start time, end time, and a button to end the election.
 -->
    <h1 class="title">ELECTION DETAILS</h1>
    <table>
        <thead>
            <th>Election Name</th>
            <th>Election Start Time</th>
            <th>Election End Time</th>
            <th>End Election</th>
        </thead>
        <tbody id="electionDetail">
        </tbody>

    </table>

    <!-- The voter details table includes the number of voters, the number of authorized voters, and the number of authorized votes. -->
    <h1 class="title">VOTER DETAILS</h1>
    <table>
        <?php
        if (isset($_COOKIE['address'])) {


            // Code to Extract Voter Name and Address from Database
            $conn = mysqli_connect('localhost', 'root', '');
            if (!$conn) {
                die("Connection failed: " . $conn->connect_error);
            } else {
                $db = mysqli_select_db($conn, 'voter form submission');
                $addresses = $_COOKIE['address'];
                $query = "SELECT * FROM `$addresses` WHERE 1;";

                $result = mysqli_query($conn, $query);
                $totalVoters = mysqli_num_rows($result);

                $query = "SELECT * FROM `$addresses` WHERE Registered=true";
                $result = mysqli_query($conn, $query);
                $totalAuthorizedVoters = mysqli_num_rows($result);

            }
            ?>
            <tr>
                <th>No of Voters</th>
                <th>Authorized Voters</th>
                <th>Authorized Votes</th>
            </tr>
            <tr>
                <td>
                    <?php echo $totalVoters; ?>
                </td>
                <td>
                    <?php echo $totalAuthorizedVoters; ?>
                </td>
                <td id="totalVotes"></td>
            </tr>
            <?php
        }
        // mysqli_close($conn);
        ?>
    </table>

    <!-- The candidate details table includes the candidate number, candidate name, and candidate vote count. -->

    <h1 class="title">ELECTION CANDIDATE DETAILS</h1>
    <table>
        <thead>
            <th>Candidate No.</th>
            <th>Candidate Name</th>
            <th>Candidate Vote</th>
        </thead>
        <tbody id="candidateDetails">
        </tbody>

    </table>

    <h3 id="winner" class="title"> </h3>
    <!-- IT uses an event listener to call a function named "alertMe()" when the window loads -->
    <script>
        window.addEventListener('load', async () => {
            bundle.alertMe();
        });
    </script>

</html>