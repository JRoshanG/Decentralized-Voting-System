<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../../css/admin/admin.css">
  <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.36/dist/web3.min.js"></script>
  <script src="../../js/admin/adminAuth.js"></script>
  <script src="../../dist/adminPanel.js"></script>

  <style>
    h3 {
      text-align: center;
    }

    ol#candidateList {
      display: flex;
      flex-direction: column;
      align-items: center;
      list-style-position: inside;
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
    <li><a href="voterAuth.php">Voter Authorize</a></li>
    <li><a href="adminPanel.php" style="color: antiquewhite;">Election </a></li>
  </ul>
  <h1 class="title" id="electionName"></h1>

  <!--  The Code is a form that allows the user to select an election type from a drop-down list. 
  The selected election type is then passed to a JavaScript function called passContract() when the user clicks the submit button.-->
  <div class="container">
    <h1 class="title">SELECT ELECTION ADDRESS </h1>
    <form id="form">
      <div class="row">
        <div class="col-25">
          <label for="address">ELECTION NAME:</label>
        </div>
        <div class="col-75">

          <!-- The code retrieves the election names and addresses from a MySQL database using PHP. 
        It then stores the retrieved data in an array called $voters. -->

          <?php
          // Code to Extract Voter Name and Address from Database
          $conn = mysqli_connect('localhost', 'root', '');
          if (!$conn) {
            die("Connection failed: " . $conn->connect_error);
          } else {
            $db = mysqli_select_db($conn, 'voter form submission');
            $query = "SELECT `Election Name`, `Election Address` FROM `electionaddress` WHERE 1";
            $result = mysqli_query($conn, $query);
            $voters = array();
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $voters[] = array("electionName" => $row["Election Name"], "address" => $row["Election Address"]);
              }
            }
          }
          ?>
          <!-- The code uses a select element to display the election names and addresses retrieved from the database. 
          It also includes an option with no value to prompt the user to select an election type. -->

          <select id="passAddress" class="required">
            <option value="">Select Election Type</option>

            <!-- The code uses a foreach loop to iterate through the $voters array and generate an option element for each election type. 
            The value attribute of each option element is set to the corresponding election address. -->
            
            <?php
            foreach ($voters as $voter) {
              ?>
              <option value="<?php echo $voter["address"]; ?>">
                <?php echo ($voter["electionName"]); ?>   <?php echo ('  --  '); ?>   <?php echo $voter["address"]; ?>
              </option>
              <?php
            }
            mysqli_close($conn);
            ?>
          </select>
        </div>
      </div>
      <div class="row">
      <!-- The passContract() function is called when the user clicks the submit button. 
      This function takes the selected election address and passes it to another function for further processing. -->
        <button type="button" onclick="bundle.passContract()">Submit</button>
      </div>
    </form>
  </div>

<!-- This is a code for a form to add a candidate for an election. This form includes a label for the
candidate name and an input field to enter the name. It has a submit button, which calls a JavaScript
function name passCandidate() when clicked -->
  <div class="container" style="margin-top: 20px;">
    <h1 class="title">ADD ELECTION CANDIDATE</h1>

    <form id="form">
      <div class="row">
        <div class="col-25">
          <label for="candidateName">Candidate Name:</label>
        </div>
        <div class="col-75">
          <input type="text" id="candidateName" class="required" placeholder="Enter Candidate Name to Add">
        </div>
      </div>
      <div class="row">
        <button type="button" onclick="bundle.passCandidate()">Submit</button>
      </div>
    </form>
    <h3>LIST OF CANDIDATE IN ELECTION</h3>
    
    <!-- It is an order list which contains a list of candidate passed through Javascript -->
    <ol id="candidateList" style="font-size: 20px;">

    </ol>
  </div>

<!-- This is a code for a form to deauthorize a voter. This form includes a label for Voter ID and an input --
field to enter Voter ID. It has a submit button, which calls a JavaScript function name deauthVoter() when clicked -->
  <div class="container display" style="margin-top: 20px;">
    <h1 class="title">DEAUTHORIZE VOTER</h1>

    <form id="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="row">
        <div class="col-25">
          <label for="voterID">Voter ID:</label>
        </div>
        <div class="col-75">
          <input type="text" id="voterID" class="required" placeholder="Enter VoterID to Deauthorize">
        </div>
      </div>
      <div class="row">
        <button type="button" onclick="bundle.deauthVoter()">Submit</button>
      </div>
    </form>
  </div>

</body>

</html>