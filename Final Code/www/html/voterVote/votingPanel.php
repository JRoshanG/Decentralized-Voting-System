<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voting Panel</title>
  <link rel="stylesheet" href="../../css/voterVote/voter.css">
  <script src="../../dist/votingPanel.js"></script>
</head>

<body>
  <nav>
    <!-- The navigation bar has a link to exit the page and return to the index.html page. -->
    <ul>
      <li><a href="../../index.html">Exit</a></li>
    </ul>
  </nav>

  <!-- The  form has a drop-down menu to select the election name and a submit button to retrieve the election details. -->
  <div class="container">
    <h1 class="title">SELECT ELECTION NAME </h1>
    <form id="form">
      <div class="row">
        <div class="col-25">
          <label for="address">Election Name:</label>
        </div>
        <div class="col-75">
          <select id="passAddress" class="required">
            <option value="">Select Election Type</option>
          </select>
        </div>
      </div>
      <div class="row">
        <button type="button" onclick="bundle.electionDetail()">Submit</button>
      </div>
    </form>
  </div>
  <h1 class="title" id="electionName"></h1>

  <!-- The  form has a drop-down menu to select the candidate name and a submit button to cast the vote for the selected candidate. -->
  <div class="container">
    <h1 class="title">SELECT CANDIDATE NAME TO VOTE </h1>
    <form id="form">
      <div class="row">
        <div class="col-25">
          <label for="address">Candidate Name:</label>
        </div>
        <div class="col-75">
          <select id="passCandidate" class="required">
          </select>
        </div>
      </div>
      <div class="row">
        <button type="button" onclick="bundle.voteCandidate()">Submit</button>
      </div>
    </form>
  </div>

  <!-- The table displays the candidate details with columns for the candidate number, name, and vote count. -->
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
  <!-- Finally, there is an empty h2 element with an id of "winner" that is  intended to display the winner of the election from JavaScript -->
  <h2 id="vote" class="title"></h2>
  <h2 id="winner" class="title">
</body>

</html>