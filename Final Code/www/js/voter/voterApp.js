// Importing Ethers Library from node_modules for interacting with SmartContract
const { ethers } = require("ethers");
// This line initializes the provider object using the ethers library. 
// The Web3Provider class is used to create a new provider object that connects to an Ethereum node via the window.ethereum object. 
// The window.ethereum object is provided by a browser's Ethereum-compatible wallet, such as MetaMask.
const provider = new ethers.providers.Web3Provider(window.ethereum);
// This line initializes the signer object using the getSigner() method of the provider object. 
// The signer object is used to sign transactions with the private key of the current user.
const signer = provider.getSigner();
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

// Store WalletAddress 
let walletAddress;
// alert("Success");

// retrieves the wallet address of the current user
provider.getSigner().getAddress()
  .then(address => {
    // The wallet address is assigned to the walletAddress variable.
    walletAddress = address;
  })
  .then(() => {
    // the AddressChecker() function is called with the walletAddress as its argument.
    AddressChecker(walletAddress);
  })
  // If there is an error retrieving the wallet address, the catch block logs the error to the console.
  .catch(error => {
    console.error(error);
  });

// This is an async function called AddressChecker, which takes an address parameter as input.
async function AddressChecker(address) {
  // It sets a cookie to store the voter's wallet address. The cookie is set to expire in 24 hours.
  document.cookie = "voterWallet=" + address + "; expires=" + new Date(Date.now() + 24 * 60 * 60 * 1000).toUTCString() + "; path=/";

  // It sends a POST request to a PHP script (getElection.php) using the fetch API. The message in the payload is the voter's wallet address.
  var payload = { message: address };
  const receiveAddress = await fetch('../../php/voterVote/getElection.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  });

  // It retrieves the response from the PHP script as JSON, which contain an array of contract addresses authorized for the voter.
  const addresses = await receiveAddress.json();

  // initializes an empty array called authorizeElection, which will be used to store the authorized contract addresses.
  authorizeElection = [];
  // It iterates through each contract address in the array obtained from the PHP script and checks if the voter is authorized to vote in that contract 
  // by calling the voters function on the contract and passing the voter's wallet address as a parameter. If the voter is authorized, it adds the contract address to the authorizeElection array.
  for (let i = 0; i < addresses.length; i++) {
    const contractAddress = addresses[i];
    contract = new ethers.Contract(contractAddress, abi, signer);
    const VoterDetail = await contract.voters(address);
    if (VoterDetail.authorized == true) {
      authorizeElection.push(contractAddress);
    }
  }

  // It retrieves the <select> element with an id of passAddress, and adds an <option> element for each authorized contract address to the select dropdown menu. 
  // The option text contains the election name and contract address, while the option value is set to the contract address.
  const select = document.getElementById('passAddress');
  for (let i = 0; i < authorizeElection.length; i++) {
    const option = document.createElement('option');
    const authorizedAddress = authorizeElection[i];
    contract = new ethers.Contract(authorizedAddress, abi, signer);
    const electionName = await contract.electionName();
    option.text = electionName + " -- " + authorizedAddress;
    option.value = authorizedAddress;
    select.appendChild(option);
  }
}

// declares an async function named electionDetail.
async function electionDetail() {
  // retrieves the value of an HTML element with an id attribute of "passAddress", and assigns it to a variable named contractAddress.
  contractAddress = document.getElementById("passAddress").value;
  // sets a cookie named "Contract Address" with the value of contractAddress, an expiration date of 24 hours from the current time, and a path of "/".
  document.cookie = "contractAddress=" + contractAddress + "; expires=" + new Date(Date.now() + 24 * 60 * 60 * 1000).toUTCString() + "; path=/";
  // creates a new instance of an ethers.Contract object, with the contractAddress, abi, and signer variables passed as arguments
  contract = new ethers.Contract(contractAddress, abi, signer);
  // calls the electionName method of the contract object, and assigns the result to a variable named electionName
  const electionName = await contract.electionName();
  // sets the innerHTML property of an HTML element with an id attribute of "electionName" to the string "Election Name: ", followed by the value of the electionName variable
  document.getElementById("electionName").innerHTML = "Election Name: " + electionName;
  // calls the getNumCandidate method of the contract object, and assigns the result to a variable named candidates
  const candidates = await contract.getNumCandidate();
  // parses the value of the candidates variable as a hexadecimal number, and assigns the result to a variable named candidateLength
  const candidateLength = parseInt(candidates, 16);
  // sets the innerHTML property of an HTML element with an id attribute of "passCandidate" to an empty string
  document.getElementById("passCandidate").innerHTML = "";
  // retrieves an HTML element with an id attribute of "passCandidate", and assigns it to a variable named select
  const select = document.getElementById("passCandidate");
  // creates a new HTML option element, sets its text property to the string "Select Candidate Name to Vote...", sets its value property to an empty string, and appends it to the select element
  const option = document.createElement('option');
  option.text = "Select Candidate Name to Vote...";
  option.value = "";
  select.appendChild(option);
  // loops through the integers from 0 to candidateLength - 1, and for each integer i, it calls the candidates method of the contract object with i as an argument, 
  // and assigns the result to a variable named candidateName. It then creates a new HTML option element, sets its text property to the value of candidateName.name, 
  // sets its value property to i, and appends it to option. 
  for (var i = 0; i < candidateLength; i++) {
    const candidateName = await contract.candidates(i);
    const option = document.createElement('option');
    option.text = candidateName.name;
    option.value = i;
    select.appendChild(option);
  }
  alertMe(contractAddress);
}

// declares an asynchronous function named voteCandidate
async function voteCandidate() {
  // retrieves the value of the selected candidate number from the HTML element with the ID passCandidate and assigns it to the variable candidateNumber
  candidateNumber = document.getElementById("passCandidate").value;
  // retrieves the stored contract address from the cookies using a regular expression to extract the value of the Contract Address cookie and assigns it to the variable contractAddress
  var contractAddress = document.cookie.replace(/(?:(?:^|.*;\s*)contractAddress\s*\=\s*([^;]*).*$)|^.*$/, "$1");
  // retrieves the stored wallet address from the cookies using a regular expression to extract the value of the voterWallet cookie and assigns it to the variable walletAddress
  var walletAddress = document.cookie.replace(/(?:(?:^|.*;\s*)voterWallet\s*\=\s*([^;]*).*$)|^.*$/, "$1");

  // creates a new ethers.Contract object using the stored contract address, ABI, and signer
  contract = new ethers.Contract(contractAddress, abi, signer);
  // retrieves the voter details for the stored wallet address using the voters() function from the smart contract and assigns it to the voter constant
  const voter = await contract.voters(walletAddress);
  // retrieves the voted property from the voter object and assigns it to the constant voted
  const voted = voter.voted;
  // This checks if the voter has not yet cast their vote
  if (voted == false) {
    // casts the vote for the selected candidate using the vote() function from the smart contract
    await contract.vote(candidateNumber);
    // displays an alert to indicate that the vote was cast successfully
    alert("SuccessFully Voting to Candidate....");
  } else {
    // displays an alert to indicate that the voter has already cast their vote
    alert("You have Already Cast a Vote...");
  }
}

// function alertMe takes a contractAddress as a parameter
async function alertMe(contractAddress) {
  // contract variable is assigned to a new instance of ethers.Contract using the contractAddress passed as an argument, along with the ABI and signer objects
  contract = new ethers.Contract(contractAddress, abi, signer);

  // number of candidates is fetched from the contract using the getNumCandidate method and stored in the candidates variable
  const candidates = await contract.getNumCandidate();
  // candidateLength variable is assigned the parsed integer value of candidates, which is in hexadecimal format
  const candidateLength = parseInt(candidates, 16);
  // innerHTML property of the candidateDetails element is cleared
  document.getElementById("candidateDetails").innerHTML = "";
  // candidateTable variable is assigned the candidateDetails element
  const candidateTable = document.getElementById("candidateDetails");

  // loop is used to iterate over each candidate, from index 0 to candidateLength - 1.
  for (var i = 0; i < candidateLength; i++) {
    // For each candidate, the candidates object is fetched using the candidates method of the contract and the current index as an argument. 
    // The returned object is assigned to the candidate variable.
    const candidate = await contract.candidates(i);
    // candidateNo variable is assigned the current index plus 1.
    const candidateNo = i + 1;
    // candidateName variable is assigned the name property of the candidate object
    const candidateName = candidate.name;
    // candidateVotes variable is assigned the voteCount property of the candidate object.
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

  // retrieves the stored wallet address from the cookies using a regular expression to extract the value of the voterWallet cookie and assigns it to the variable walletAddress
  var walletAddress = document.cookie.replace(/(?:(?:^|.*;\s*)voterWallet\s*\=\s*([^;]*).*$)|^.*$/, "$1");
  // retrieves the voter details for the stored wallet address using the voters() function from the smart contract and assigns it to the voter constant
  const voter = await contract.voters(walletAddress);
  // retrieves the voted property from the voter object and assigns it to the constant voted
  const voted = voter.voted;

  if (voted == true) {
    // Getting the index of the voted candidate
    const voterDetail = await contract.voters(walletAddress);
    const candidateIndex = voterDetail.vote;
    // Get the name of the voted candidate
    const candidateDetail = await contract.candidates(candidateIndex);
    const candidateName = candidateDetail.name;

    // Display the name of the voted candidate
    document.getElementById("vote").innerHTML = "You have voted to candidate: " + candidateName;
  } else {
    // Display you have not voted yet. 
    document.getElementById("vote").innerHTML = "You have to not voted yet";
  }

  // The winner of the election is fetched using the getWinner method of the contract and assigned to the winner variable
  const winner = await contract.getWinner();
  // The innerHTML property of the winner element is set to a string that includes the winner's name
  document.getElementById("winner").innerHTML = "The winner of Election is: " + winner;
}

module.exports = {
  electionDetail,
  voteCandidate,
  alertMe
}

