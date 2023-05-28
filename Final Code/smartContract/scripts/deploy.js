const { ethers } = require("hardhat");

async function deployContract(name, startTime, endTime){
    const Election = await ethers.getContractFactory("Election");
    const electionDeploy  = await Election.deploy(name, startTime, endTime);
    contractAddress = electionDeploy.address;
    console.log(contractAddress);
}

// Date and Time Format 2023-02-02T21:43
const name = "Election of Chiya and Coffee";
const startTime = "2022-06-01T00:00"
const endTime = "2023-06-01T00:00"
const date = new Date(startTime);
const startTimeUnix = date.getTime() / 1000;
const data = new Date(endTime);
const endTimeUnix = data.getTime() / 1000;

deployContract(name,startTimeUnix,endTimeUnix);

