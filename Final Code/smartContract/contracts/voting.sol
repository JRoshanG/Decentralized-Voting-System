// SPDX-License-Identifier: MIT
pragma solidity >=0.8.0 <0.9.0;

// Start of the contract
contract Election {
    // The contract defines a struct called candidate, which has two 
    // proterties: a name and a vote count for candidate
    struct Candidate {
        string name;
        uint voteCount;
    }
    // The contract also defines a struct called voter, which has three properties:
    // authorized, voted and vote. 
    struct Voter {
        bool authorized;
        bool voted;
        uint vote;
    }

    // Stores the Address of the Owner
    address public owner;

    // Stores the Name of election
    string public electionName;

    // Mapping of addresses to voter structs
    mapping(address => Voter) public voters;

    // An array of candidate structs
    Candidate[] public candidates;

    // Stores total votes in election, start time of election, end Time of election
    uint public totalVotes;
    uint public startTime;
    uint public endTime;

    // Stores if election has ended
    bool public ended;

    // Decrelation of variable
    uint voteIndex;

    // It is a modifies called ownerOnly,which requires that the message sender is 
    // the owner of the contract before executing the function.
    modifier ownerOnly() {
        require(
            msg.sender == owner,
            "Only the contract owner can perform this action."
        );
        _;
    }

    //The contract defines a constructor that initializes the owner, election name, 
    // start and end times, and a boolean flag to indicate whether the election has ended.
    constructor(string memory _name, uint _startTime, uint _endTime) {
        owner = msg.sender;
        electionName = _name;
        startTime = _startTime;
        endTime = _endTime;
        ended = false;
    }

    // The function addCandidate allows the contract owner to add a new candidate to the election,
    // if election has not ended and current time is within the voting period. 
    function addCandidate(string memory _name) public ownerOnly {
        require(ended == false, "Election already Ended");
        require(
            block.timestamp <= endTime,
            "Cannot add candidate outside of voting period."
        );
        require(bytes(_name).length != 0, "Blank name not allowed.");
        candidates.push(Candidate(_name, 0));
    }

    // The function returns the number of candidates in the candidate array. 
    function getNumCandidate() public view returns (uint) {
        return candidates.length;
    }

    // The function authorize allows the contract owner to authorize a voter to vote in election. 
    // The election should not be ended 
    function authorize(address _person) public ownerOnly {
        require(ended == false, "Election already Ended");
        require(_person != address(0), "Invalid address.");
        voters[_person].authorized = true;
    }

    // The function allows voter to vote their prefered candidate.
    // The voter should vote in the voting time and
    // voter should be authorize and should have voted. 
    function vote(uint _voteIndex) public {
        require(ended == false, "Election already Ended");
        require(
            block.timestamp >= startTime && block.timestamp <= endTime,
            "Cannot vote outside of voting period."
        );
        require(voters[msg.sender].authorized, "Voter not authorized.");
        require(!voters[msg.sender].voted, "Voter already voted.");
        require(_voteIndex < candidates.length, "Invalid candidate index.");

        voters[msg.sender].vote = _voteIndex;
        voters[msg.sender].voted = true;
        candidates[_voteIndex].voteCount += 1;
        totalVotes += 1;
    }

    // This function allows contract owner to deauthorize the voter. 
    // The vote of the voter after deauthorization will be withdrawn. 
    function deauthorize(address _person) public ownerOnly {
        require(ended == false, "Election already Ended");
        voters[_person].authorized = false;
        voteIndex = voters[_person].vote;
        if (voters[_person].voted == true) {
            candidates[voteIndex].voteCount -= 1;
            totalVotes -= 1;
        }
        voters[_person].voted = false;
    }

    // This function ends the election so no further transaction can occur. 
    function endElection() public ownerOnly {
        ended = true;
    }

    // This function checks for the winner of election and returns the name the candidate. 
    function getWinner() public view returns (string memory) {
        uint maxVotes = 0;
        uint winnerCount = 0;
        string memory winnerNames;

        for (uint i = 0; i < candidates.length; i++) {
            if (candidates[i].voteCount > maxVotes) {
                maxVotes = candidates[i].voteCount;
                winnerCount = 1;
                winnerNames = candidates[i].name;
            } else if (candidates[i].voteCount == maxVotes && maxVotes > 0) {
                winnerCount++;
                winnerNames = string(
                    abi.encodePacked(winnerNames, " and ", candidates[i].name)
                );
            }
        }

        // Check if there are multiple candidate with same number of vote, and declares the tie. 
        if (winnerCount == 1) {
            return winnerNames;
        } else if (winnerCount > 1) {
            return string(abi.encodePacked("Tie between ", winnerNames));
        } else {
            return "No winner yet";
        }
    }
}
