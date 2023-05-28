window.addEventListener('load', async () => {
    // Check if web3 is injected by Metamask
    if (window.ethereum) {
      window.web3 = new Web3(ethereum);
      try {
        // Request account access if needed
        await ethereum.enable();
      } catch (error) {
        // User denied account access...
      }
    }
    // Legacy dapp browsers...
    else if (window.web3) {
        window.web3 = new Web3(web3.currentProvider);
    }
    // Non-dapp browsers...
    else {
      alert('Non-Ethereum browser detected. You should consider trying MetaMask!');
      window.location.href = '../../index.html'
    }
  
    // Check if user is authorized admin with a specific wallet address
    const authorizedAddress = '0x108E82f3ba7CC22b3903D6F9Bd2234C08f26bF81';
    const currentAddress = await window.web3.eth.getAccounts();
    if (currentAddress[0].toLowerCase() !== authorizedAddress.toLowerCase()) {
      alert('You are not authorized to log in as an admin.');
      window.location.href = '../../index.html';
    }
  });
  