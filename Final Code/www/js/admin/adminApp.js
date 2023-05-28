// Importing Ethers Library from node_modules for interacting with SmartContract
const { ethers } = require("ethers");

// Variable for storing Smart Contract Addresses 
var contractAddress;

// Appilication Binary Information which is a specification that defines how to interact with a smart contract. 
// It is essentially a set of rules that define how functions are called and data is encoded and decoded for smart contracts.
const abi = [
  {
    "inputs": [
      {
        "internalType": "string",
        "name": "_name",
        "type": "string"
      },
      {
        "internalType": "uint256",
        "name": "_startTime",
        "type": "uint256"
      },
      {
        "internalType": "uint256",
        "name": "_endTime",
        "type": "uint256"
      }
    ],
    "stateMutability": "nonpayable",
    "type": "constructor"
  },
  {
    "inputs": [
      {
        "internalType": "string",
        "name": "_name",
        "type": "string"
      }
    ],
    "name": "addCandidate",
    "outputs": [],
    "stateMutability": "nonpayable",
    "type": "function"
  },
  {
    "inputs": [
      {
        "internalType": "address",
        "name": "_person",
        "type": "address"
      }
    ],
    "name": "authorize",
    "outputs": [],
    "stateMutability": "nonpayable",
    "type": "function"
  },
  {
    "inputs": [
      {
        "internalType": "uint256",
        "name": "",
        "type": "uint256"
      }
    ],
    "name": "candidates",
    "outputs": [
      {
        "internalType": "string",
        "name": "name",
        "type": "string"
      },
      {
        "internalType": "uint256",
        "name": "voteCount",
        "type": "uint256"
      }
    ],
    "stateMutability": "view",
    "type": "function"
  },
  {
    "inputs": [
      {
        "internalType": "address",
        "name": "_person",
        "type": "address"
      }
    ],
    "name": "deauthorize",
    "outputs": [],
    "stateMutability": "nonpayable",
    "type": "function"
  },
  {
    "inputs": [],
    "name": "electionName",
    "outputs": [
      {
        "internalType": "string",
        "name": "",
        "type": "string"
      }
    ],
    "stateMutability": "view",
    "type": "function"
  },
  {
    "inputs": [],
    "name": "endElection",
    "outputs": [],
    "stateMutability": "nonpayable",
    "type": "function"
  },
  {
    "inputs": [],
    "name": "endTime",
    "outputs": [
      {
        "internalType": "uint256",
        "name": "",
        "type": "uint256"
      }
    ],
    "stateMutability": "view",
    "type": "function"
  },
  {
    "inputs": [],
    "name": "ended",
    "outputs": [
      {
        "internalType": "bool",
        "name": "",
        "type": "bool"
      }
    ],
    "stateMutability": "view",
    "type": "function"
  },
  {
    "inputs": [],
    "name": "getNumCandidate",
    "outputs": [
      {
        "internalType": "uint256",
        "name": "",
        "type": "uint256"
      }
    ],
    "stateMutability": "view",
    "type": "function"
  },
  {
    "inputs": [],
    "name": "getWinner",
    "outputs": [
      {
        "internalType": "string",
        "name": "",
        "type": "string"
      }
    ],
    "stateMutability": "view",
    "type": "function"
  },
  {
    "inputs": [],
    "name": "owner",
    "outputs": [
      {
        "internalType": "address",
        "name": "",
        "type": "address"
      }
    ],
    "stateMutability": "view",
    "type": "function"
  },
  {
    "inputs": [],
    "name": "startTime",
    "outputs": [
      {
        "internalType": "uint256",
        "name": "",
        "type": "uint256"
      }
    ],
    "stateMutability": "view",
    "type": "function"
  },
  {
    "inputs": [],
    "name": "totalVotes",
    "outputs": [
      {
        "internalType": "uint256",
        "name": "",
        "type": "uint256"
      }
    ],
    "stateMutability": "view",
    "type": "function"
  },
  {
    "inputs": [
      {
        "internalType": "uint256",
        "name": "_voteIndex",
        "type": "uint256"
      }
    ],
    "name": "vote",
    "outputs": [],
    "stateMutability": "nonpayable",
    "type": "function"
  },
  {
    "inputs": [
      {
        "internalType": "address",
        "name": "",
        "type": "address"
      }
    ],
    "name": "voters",
    "outputs": [
      {
        "internalType": "bool",
        "name": "authorized",
        "type": "bool"
      },
      {
        "internalType": "bool",
        "name": "voted",
        "type": "bool"
      },
      {
        "internalType": "uint256",
        "name": "vote",
        "type": "uint256"
      }
    ],
    "stateMutability": "view",
    "type": "function"
  }
];

// This line initializes the provider object using the ethers library. 
// The Web3Provider class is used to create a new provider object that connects to an Ethereum node via the window.ethereum object. 
// The window.ethereum object is provided by a browser's Ethereum-compatible wallet, such as MetaMask.
const provider = new ethers.providers.Web3Provider(window.ethereum);

// This line initializes the signer object using the getSigner() method of the provider object. 
// The signer object is used to sign transactions with the private key of the current user.
const signer = provider.getSigner();

//This variable is intended to hold an instance of a contract, but has not been initialized yet.
var contract;

// IT is a JavaScript function called notEmpty that checks if a value is empty and displays an alert if it is. 
// The function takes a parameter called checker that is the value to be checked.
function notEmpty(checker) {
  if (!checker) {
    alert("Input text cannot be empty!");
  } else {
    return true;
  }
}

// It Defines an 'async' function called 'passContract'
async function passContract() {
  // It  retrieves the value of an input field with the id "passAddress" and assigns it to the contractAddress variable.
  contractAddress = document.getElementById("passAddress").value;
  // It calls the notEmpty function  with the contractAddress variable as its parameter, and assigns the result to the isEmpty constant.
  const isEmpty = notEmpty(contractAddress);
  // checks if the isEmpty constant is true.
  if (isEmpty == true) {
    // It creates a new instance of the ethers.Contract class using the contractAddress, abi, and signer variables. 
    // This creates a connection to the Ethereum smart contract at the specified address.
    contract = new ethers.Contract(contractAddress, abi, signer);
    // This block of code wraps the next few lines in a try...catch statement, which handles any errors that might occur when interacting with the smart contract.
    try {
      // retrieves the value of a function called electionName from the smart contract, using the await keyword to wait for the result to be returned before continuing execution of the function.
      electionName = await contract.electionName();
      // sets the inner HTML of an element with the id "electionName" to the value of electionName.
      document.getElementById("electionName").innerHTML = electionName;
      //  sets a cookie with the name "address" and the value of contractAddress. The cookie is set to expire 24 hours from the current time, and is set to be accessible to all pages on the current domain.
      document.cookie = "address=" + contractAddress + "; expires=" + new Date(Date.now() + 24 * 60 * 60 * 1000).toUTCString() + "; path=/";
      // This line calls a function called candidateList.
      candidateList();
      // If an error occurs in the try block, this line logs the error to the console.
    } catch (error) {
    }
  }
}

// This code defines an async function called passCandidate that adds a new candidate to an Ethereum smart contract. 
// The function retrieves the contract address from a cookie, creates a new instance of the ethers.Contract class, and calls a function on the contract to add the new candidate. 
// If the candidate name is empty, the function displays an error message and does not attempt to add the candidate.
async function passCandidate() {
  // retrieves the contract address from a cookie named "address" and assigns it to the contractAddress variable.
  var contractAddress = document.cookie.replace(/(?:(?:^|.*;\s*)address\s*\=\s*([^;]*).*$)|^.*$/, "$1");
  // creates a new instance of the ethers.Contract class using the contractAddress, abi, and signer variables. 
  // This creates a connection to the Ethereum smart contract at the specified address.
  contract = new ethers.Contract(contractAddress, abi, signer);
  // retrieves the value of an input field with the id "candidateName" and assigns it to the candidateName variable.
  candidateName = document.getElementById("candidateName").value;
  // Checks if candidateName is Empty or Not
  const isEmpty = notEmpty(candidateName);
  if (isEmpty == true) {
    try {
      //  calls a function called addCandidate on the smart contract, passing in the candidateName variable as a parameter. 
      // The await keyword is used to wait for the function to complete before continuing execution of the function.
      await contract.addCandidate(candidateName);
      // displays an alert message indicating that the new candidate has been added.
      alert("Candidate " + candidateName + " has been successfully added");
      // calls a function called candidateList.
      candidateList();
      // If an error occurs in the try block, this line logs the error to the console.
    } catch (error) {
    }
  }
}

//  retrieves the number of candidates registered in the election smart contract using the getNumCandidate() function and converts the hexadecimal number to decimal. 
// It then clears the candidate list displayed on the webpage and creates a new ul element to display the updated list of candidates.
async function candidateList() {
  const candidates = await contract.getNumCandidate();
  const candidateLength = parseInt(candidates, 16);
  document.getElementById("candidateList").innerHTML = "";
  const candidateList = document.getElementById("candidateList");
  // uses a for loop to iterate through each candidate registered in the smart contract and retrieves their name using the candidates() function. 
  // For each candidate, a new li element is created and their name is added as a text node to the li. The li element is then appended to the ul list created earlier.
  for (var i = 0; i < candidateLength; i++) {
    const candidateName = await contract.candidates(i);
    var item = document.createElement("li");
    const listName = document.createTextNode(candidateName.name);
    item.appendChild(listName);
    candidateList.appendChild(item);
    // logs the name of each candidate to the console for debugging purposes.
  }
}

// The function authorizes a voter by their Metamask wallet address by calling the 'authorize()' function of the smart contract. 
async function authorizeAddress(voterAddress) {
  try {
    // Retrieves the smart contract address from the cookie created earlier. it extract the address value from the cookie. 
    contractAddress = document.cookie.replace(/(?:(?:^|.*;\s*)address\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    // Creates an instance of the smart contract using the 'ethers.Contract' function and passes in the contract address, ABI, and signer. 
    contract = new ethers.Contract(contractAddress, abi, signer);
    // Calls the authorize() function of the contract, passing in the voterAddress parameter.
    await contract.authorize(voterAddress);
    // Displays an alert message indicating that the voter has been authorized.
    alert("Candidate " + voterAddress + " has been successfully Authorized");
    //  Redirects the user to a PHP script (updateDatabase.php) with the authorized voter address as a URL parameter.
    window.location.href = "../../php/admin/updateDatabase.php?address=" + voterAddress;
    // Catches any errors that occur within the try block.
  } catch (error) {
    // Displays an alert message indicating that the authorization failed.
    alert("Authorize Address Failed");
  }
}

// It is an 'async' function that takes no arguments. 
async function deauthVoter() {
  // The contractAddress variable is initialized by getting the contract address from the cookie
  var contractAddress = document.cookie.replace(/(?:(?:^|.*;\s*)address\s*\=\s*([^;]*).*$)|^.*$/, "$1");
  // Creates an instance of the smart contract using the 'ethers.Contract' function and passes in the contract address, ABI, and signer. 
  contract = new ethers.Contract(contractAddress, abi, signer);
  // The voterID variable is initialized by getting the value of the input field with the ID "voterID".
  voterID = document.getElementById("voterID").value;
  const isEmpty = notEmpty(voterID);
  if (isEmpty == true) {
    try {
      // The payload object is created with a message property set to the value of voterID.
      const payload = { message: voterID };
      // The response variable is initialized by making a POST request to a PHP file that converts the voter ID to an address using the payload object.
      const response = await fetch('../../php/admin/voterToaddress.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });

      // The address variable is initialized by extracting the JSON response from the response object.
      const address = await response.json();

      // The try block attempts to deauthorize the voter with the address retrieved from the PHP file using the deauthorize method on the contract object. 
      // The await keyword is used to wait for the transaction to be confirmed on the blockchain before continuing.
      try {
        await contract.deauthorize(address);
        // If the deauthorization is successful, an alert is displayed indicating that the voter has been successfully deauthorized.
        alert("VoterID " + address + " has been successully Deauthorize");
        // The payload object is created with a message property set to the value of voterID.
        const payload = { message: voterID };
        // The response variable is initialized by making a POST request to a PHP file that converts the voter ID to an address using the payload object.
        await fetch('../../php/admin/deAuthorize.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });

      } catch (error) {
        console.log(error);
        // If an error occurs during the deauthorization process, the error is logged to the console and an alert is displayed indicating that the deauthorization failed.
        alert("Deauthorize VoterID " + address + " Failed");
      }
    } catch (error) {
      alert("DeAuthorize Voter Address Failed");
    }
  }
}

// This function takes a Unix timestamp as its input and returns a formatted date and time string in the local timezone of the user's browser.
function unixDateConverter(unixTime) {
  const date = new Date(unixTime * 1000); // Create a new Date object with the Unix time
  const localDate = date.toLocaleDateString(); // Get the local date in the format of the user's browser
  const localTime = date.toLocaleTimeString(); // Get the local time in the format of the user's browser
  const dateTimeString = `${localDate} : ${localTime}`;
  return dateTimeString;
}

// This is an asynchronous function named alertMe that retrieves information about an election from a smart contract and updates a web page with the relevant information.
async function alertMe() {
  // Retrieves the Ethereum address of the deployed contract from the browser cookies and assigns it to contractAddress.
  contractAddress = document.cookie.replace(/(?:(?:^|.*;\s*)address\s*\=\s*([^;]*).*$)|^.*$/, "$1");
  // Creates a new instance of the deployed contract using the address, ABI and signer object.
  contract = new ethers.Contract(contractAddress, abi, signer);
  // Retrieves the HTML element with ID electionDetail.
  const electionDetail = document.getElementById("electionDetail");
  // Calls the electionName function from the deployed contract and assigns the returned value to electionName.
  const electionName = await contract.electionName();
  // Calls the startTime function from the deployed contract and assigns the returned Unix timestamp value to startTimeUnix.
  const startTimeUnix = await contract.startTime();
  // Calls the endTime function from the deployed contract and assigns the returned Unix timestamp value to endTimeUnix.
  const endTimeUnix = await contract.endTime();

  // Calls the unixDateConverter function (which converts a Unix timestamp to a local date and time string) with startTimeUnix as an argument and assigns the returned value to startTime.
  startTime = unixDateConverter(startTimeUnix);
  // Calls the unixDateConverter function with endTimeUnix as an argument and assigns the returned value to endTime.
  endTime = unixDateConverter(endTimeUnix);

  // Inserts a new row at the end of the electionDetail table and assigns it to row.
  const row = electionDetail.insertRow(-1);
  // Inserts a new cell in the new row (row) and assigns it to electionNameCell.
  const electionNameCell = row.insertCell(0);
  // Sets the innerHTML of electionNameCell to the value of electionName.
  electionNameCell.innerHTML = electionName;
  // Inserts a new cell in row and assigns it to electionStartTimeCell.
  electionStartTimeCell = row.insertCell(1);
  // Sets the innerHTML of electionStartTimeCell to the value of startTime.
  electionStartTimeCell.innerHTML = startTime;
  // Inserts a new cell in row and assigns it to electionEndTimeCell.
  electionEndTimeCell = row.insertCell(2);
  // Sets the innerHTML of electionEndTimeCell to the value of endTime.
  electionEndTimeCell.innerHTML = endTime;
  // Inserts a new cell in row and assigns it to endElectioncell.
  endElectioncell = row.insertCell(3);
  // Creates a new HTML button element and assigns it to button.
  const button = document.createElement("button");
  // Sets the innerHTML of button to "End Election".
  button.innerHTML = "End Election";
  // Sets the type attribute of button to "button".
  button.setAttribute("type", "button");
  // Sets the float CSS style property of button to "left".
  button.style.float = "left";
  // Adds an event listener to the "End Election" button so that when it is clicked, the endElection() function in the smart contract.
  button.addEventListener("click", async () => {
    await contract.endElection();
  });
  // Appends the "End Election" button to the last cell of the row in the election detail table:
  endElectioncell.appendChild(button);

  // Gets the total number of votes cast in the election from the smart contract and displays it on the web page:
  totalVote = await contract.totalVotes();
  document.getElementById("totalVotes").innerHTML = totalVote;

  // Gets the number of candidates in the election from the smart contract, iterates over the list of candidates and displays their names and vote counts in a table on the web page:
  const candidates = await contract.getNumCandidate();
  const candidateLength = parseInt(candidates, 16);
  const candidateTable = document.getElementById("candidateDetails");
  for (var i = 0; i < candidateLength; i++) {
    const candidate = await contract.candidates(i);
    const candidateNo = i + 1;
    const candidateName = candidate.name;
    const candidateVotes = candidate.voteCount;

    // Adding the candidate to the table
    const row = candidateTable.insertRow(-1);
    const candidateNoCell = row.insertCell(0);
    candidateNoCell.innerHTML = candidateNo;
    const candidateNameCell = row.insertCell(1);
    candidateNameCell.innerHTML = candidateName;
    const candidateVotesCell = row.insertCell(2);
    candidateVotesCell.innerHTML = candidateVotes;
  }

  // Gets the winner of the election from the smart contract and displays their name on the web page:
  const winner = await contract.getWinner();
  document.getElementById("winner").innerHTML = "The winner of Election is: " + winner;
}

module.exports = {
  passContract,
  passCandidate,
  candidateList,
  authorizeAddress,
  deauthVoter,
  alertMe,
}