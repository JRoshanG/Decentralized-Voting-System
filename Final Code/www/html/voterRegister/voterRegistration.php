<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../css/voterRegister/voterRegistration.css">
  <title>Application Form</title>
</head>

<body>
  <nav>
    <ul>
      <li><a href="../../index.html">Exit</a></li>
    </ul>
  </nav>
  <div class="container">
    <h1 class="title">SELECT ELECTION ADDRESS </h1>

    <!-- The form uses the PHP to connect to a MySQL database, retrieve the election names and addresses, 
    and display them as options in a drop-down list. When the user selects an election address and clicks the "Submit" button, 
    a JavaScript function is called to store the selected address in a cookie, which will be used later to store the user's information in the 
    correct database.  -->

    <form id="form">
      <div class="row">
        <div class="col-25">
          <label for="address">ELECTION NAME:</label>
        </div>
        <div class="col-75">
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
          <select id="passAddress" class="required">
            <option value="">Select Election Type</option>

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
        <button type="button" onclick="selectDatabase()">Submit</button>
      </div>
    </form>
  </div>

  <!-- the form collects the user's first name, middle name (optional), last name, voter ID number, date of birth, and email address. 
  When the user clicks the "Submit" button, the form data is sent to a PHP script located at "../../php/voterRegister/form.php" using the HTTP POST method. 
  This script will verify the user's information and insert it into the appropriate MySQL database based on the election address stored in the cookie. -->
  
  <h1 class="title">Decentralized Voting System Voter Verification</h1>
  <div class="container">
    <form id="form" action="../../php/voterRegister/form.php" method="POST">
      <div class="row">
        <div class="col-25">
          <label for="firstName">First Name</label>
        </div>
        <div class="col-75">
          <input type="text" id="firstName" name="firstName" placeholder="Your first name.." required>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="middleName">Middle Name</label>
        </div>
        <div class="col-75">
          <input type="text" id="middleName" name="middleName" placeholder="Your middle name..">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="lastName">Last Name</label>
        </div>
        <div class="col-75">
          <input type="text" id="lastName" name="lastName" placeholder="Your last name.." required>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="voterID">Voter ID Number</label>
        </div>
        <div class="col-75">
          <input type="number" id="voterID" name="voterID" placeholder="Your Voter ID Number.." required>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="DOB">Date of Birth</label>
        </div>
        <div class="col-75">
          <input type="text" id="DOB" name="DOB" placeholder="YYYY-MM-DD" required>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="email">Email</label>
        </div>
        <div class="col-75">
          <input type="email" id="email" name="email" placeholder="Your Email Address.." required>
        </div>
      </div>
      <div class="row">
        <input type="submit" value="Submit">
      </div>
    </form>
  </div>
  <script>
    function selectDatabase() {
      database = document.getElementById("passAddress").value;
      document.cookie = "database=" + database + "; expires=" + new Date(Date.now() + 24 * 60 * 60 * 1000).toUTCString() + "; path=/";
    }
  </script>
</body>

</html>