const { ethers, Mnemonic, Wallet } = require("ethers");
//console.log("Ethers installed! Version:", ethers.version);
//const wallet = ethers.Wallet.createRandom();
require('dotenv').config();
const express = require('express');
const app = express();
app.use(express.json());
//const wallet = new ethers.Wallet("YOUR_PRIVATE_KEY", provider);
// Configuration

// Usage with environment variables
const rpcUrls = [
  `https://rpc.ankr.com/bsc/${process.env.BSC_API_KEY}`, // "https://rpc.ankr.com/bsc/YOUR_KEY"
  "https://bsc-dataseed.binance.org/",
  "https://bsc.publicnode.com"
];

// Utility: pick a random element
function getRandomRpcUrl() {
  const index = Math.floor(Math.random() * rpcUrls.length);
  return rpcUrls[index];
}


const url = getRandomRpcUrl();


// USDT ABI (simplified for transfers)
const usdtAbi = [
  "function transfer(address to, uint256 amount) returns (bool)",
  "function balanceOf(address account) view returns (uint256)",
  "function decimals() view returns (uint8)" // ✅ Add this line
];

const provider = new ethers.JsonRpcProvider(url);
// USDT contract instance (read-only)
const usdtContractRead = new ethers.Contract(process.env.USDT_CONTRACT, usdtAbi, provider);

async function getGasFees() {
  try {
    const feeData = await provider.getFeeData();
    //console.log("Gas Price (in gwei):", ethers.formatUnits(feeData.gasPrice, "gwei"));

  return {
    gasLimit: 100000, // Estimate or keep default
    gasPrice: feeData.gasPrice // Dynamic gas price
  };
  } catch (err) {
    //console.warn("⚠️ Failed to fetch gas fee data, using default values.");
    return {
      gasLimit: 100000,
      gasPrice: ethers.parseUnits("5", "gwei") // Reasonable default
    };
  }
}



// Batch fetch balances function
async function batchFetchBalances(addresses) {
  // Validate addresses
  const validAddresses = addresses.filter(addr => ethers.isAddress(addr));

  // Get USDT decimals once
  const decimals = await usdtContractRead.decimals();

  // For each address, get BNB and USDT balances in parallel
  const bnbPrice = await fetchBNBPriceUSD(); // ✅ get BNB price once

  const promises = validAddresses.map(async (address) => {

    try {

      const [bnbWei, usdtRaw] = await Promise.all([
        provider.getBalance(address),
        usdtContractRead.balanceOf(address)
      ]);

      const bnbBalance = parseFloat(ethers.formatEther(bnbWei));
      const usdtBalance = parseFloat(ethers.formatUnits(usdtRaw, decimals));
      const bnbUsdValue = parseFloat((bnbBalance * bnbPrice).toFixed(2));

      return { address, bnbBalance, usdtBalance, bnbUsdValue };
    } catch (err) {
      return { address, bnbBalance: 0, usdtBalance: 0, bnbUsdValue: 0, error: err.message };
    }
  });

  const results = await Promise.all(promises);

  const balances = {};
  for (const { address, bnbBalance, usdtBalance, bnbUsdValue, error } of results) {
    balances[address] = {
      bnb: bnbBalance ?? 0,
      bnb_usd: bnbUsdValue ?? 0,
      usdt: usdtBalance ?? 0,
      ...(error ? { error } : {})
    };
  }

  addresses.forEach(addr => {
    if (!ethers.isAddress(addr)) {
      balances[addr] = { bnb: 0, bnb_usd: 0, usdt: 0, error: "Invalid address" };
    }
  });

  return balances;

}

/*(async () => {
  try {
    const bnbInWei = await batchFetchBalances(['0x142D6844246A431f3Dda1EB9fEA1D81c3eb5691B']); // Convert $0.07 to BNB
    console.dir(bnbInWei['0x142D6844246A431f3Dda1EB9fEA1D81c3eb5691B']);
  } catch (err) {
    console.error("❌ Error:", err.message);
  }
})();*/

async function getUSDTBalance(walletAddress) {
  try {
    const provider = new ethers.JsonRpcProvider(url);
    const contract = new ethers.Contract(process.env.USDT_CONTRACT, usdtAbi, provider);

    const [rawBalance, decimals] = await Promise.all([
      contract.balanceOf(walletAddress),
      contract.decimals()
    ]);

    const humanReadableBalance = ethers.formatUnits(rawBalance, decimals);

    //console.log(`USDT Balance for ${walletAddress}: ${humanReadableBalance}`);
    return humanReadableBalance;

  } catch (error) {
    //console.error("Error fetching USDT balance:", error.message);
    throw error;
  }
}

async function getWalletBalance(address) {
  try {
    const provider = new ethers.JsonRpcProvider(url);
    const balance = await provider.getBalance(address);
    return ethers.formatEther(balance); // Convert wei to ether
  } catch (error) {
    //console.error("Error fetching wallet balance:", error.message);
    throw error;
  }
}

//getUSDTBalance("0x142D6844246A431f3Dda1EB9fEA1D81c3eb5691B").then(balance => console.log("USDT Balance:", balance));

/**
 * Converts USD amount to equivalent BNB in wei
 * @param {number} usdAmount - The USD amount to convert
 * @returns {Promise<bigint>} - The equivalent BNB amount in wei
 */
async function convertUsdToBnb(usdAmount) {
  try {
    // Fetch current BNB price in USD
    const response = await fetch('https://api.coingecko.com/api/v3/simple/price?ids=binancecoin&vs_currencies=usd');
    const data = await response.json();
    const bnbPriceUsd = data?.binancecoin?.usd;
    if (!bnbPriceUsd) {
      throw new Error("Failed to fetch BNB price.");
    }

    // Convert USD to BNB
    const bnbAmount = usdAmount / bnbPriceUsd;
// Round to 18 decimals (as a string)
    const bnbAmountStr = bnbAmount.toFixed(18);
    // Convert to wei (BigInt)
    return ethers.parseEther(bnbAmountStr);
  } catch (err) {
    //console.error("Conversion failed:", err.message);
    throw err;
  }
}

// Example usage
/*(async () => {
  try {
    const bnbInWei = await convertUsdToBnb(0.07); // Convert $0.07 to BNB
    console.log(`Equivalent BNB in wei: ${bnbInWei.toString()}`);
  } catch (err) {
    console.error("❌ Error:", err.message);
  }
})();*/


async function getBnbBalanceInUsd(walletAddress) {

  try {

    const provider = new ethers.JsonRpcProvider(url);

    // 1. Get BNB balance in wei
    const balanceWei = await provider.getBalance(walletAddress);

    // 2. Convert to ether
    const balanceBNB = ethers.formatEther(balanceWei); // string

    // 3. Fetch BNB price in USD
    const bnbPriceUSD = fetchBNBPriceUSD();

    if (!bnbPriceUSD) {
      throw new Error("Failed to fetch BNB price from API");
    }

    // 4. Calculate USD equivalent
    const balanceUSD = parseFloat(balanceBNB) * bnbPriceUSD;

    return {
      address: walletAddress,
      balanceBNB,
      balanceUSD: balanceUSD.toFixed(2),
      bnbPriceUSD,
    };

  } catch (err) {
    //console.error("Error fetching BNB balance in USD:", err.message);
    throw err;
  }
}

async function fetchBNBPriceUSD() {
  const response = await fetch("https://api.coingecko.com/api/v3/simple/price?ids=binancecoin&vs_currencies=usd");
  const data = await response.json();
  return data?.binancecoin?.usd ?? 0;
}


/*(async () => {
  const result = await getBnbBalanceInUsd("0x142D6844246A431f3Dda1EB9fEA1D81c3eb5691B");
  console.log(result);
})();*/

async function sendBNB(toAddress, amountBNB, privateKey) {

  const result = {
    success: false,
    error: null,
    data: null,
  };

  try {

    const provider = new ethers.JsonRpcProvider(url);
    const wallet = new ethers.Wallet(privateKey, provider);
    
    // Get dynamic gas fees
    const { gasLimit, gasPrice } = await getGasFees();

    const amountInWei = await convertUsdToBnb(amountBNB);
    //console.log(`Transferring ${amountBNB} BNB (${amountInWei.toString()} in wei) to ${toAddress}`);

    // Check sender BNB balance
    const senderBalance = await provider.getBalance(wallet.address);
    //console.log(`Sender BNB Balance: ${ethers.formatEther(senderBalance)} BNB`);
    // Calculate total cost = amount + gas fee
    const estimatedFee = gasPrice * BigInt(21000); // 21,000 is a typical gas limit for simple transfers
    const totalCost = amountInWei + estimatedFee;

    if (senderBalance < totalCost) {
      throw new Error("Insufficient BNB balance (including gas fees)");
    }

    // Send the transaction
    const tx = await wallet.sendTransaction({
      to: toAddress,
      value: amountInWei,
      gasLimit,
      gasPrice
    });

    //console.log(`Transaction sent: https://bscscan.com/tx/${tx.hash}`);

    const receipt = await tx.wait();
    //console.log(`✅ Confirmed in block ${receipt.blockNumber}`);

    return {
      status: true,
      txHash: receipt.hash,
      blockNumber: receipt.blockNumber,
      amountBNB: amountBNB.toString()
    };

  } catch (err) {
    //console.error("❌ BNB Transfer failed:", err.message);
    throw err;
  }
}


async function transferUSDT(toAddress, amount, privateKey) {

  const result = {
    success: false,
    error: null,
    data: null,
  };

  try {
    // Connect to network
    const provider = new ethers.JsonRpcProvider(url);
    const wallet = new ethers.Wallet(privateKey, provider);
    const { gasLimit, gasPrice } = await getGasFees();
    
    // Connect to USDT contract
    const usdtContract = new ethers.Contract(process.env.USDT_CONTRACT, usdtAbi, wallet);

    // Convert amount to USDT decimals (18 for most BEP-20)
    const decimals = await usdtContract.decimals(); // returns a BigNumber
    const amountInWei = ethers.parseUnits(amount.toString(), Number(decimals));
    //console.log(`Transferring ${amount} USDT (${amountInWei.toString()} in wei) to ${toAddress}`);
    
    // Check sender balance first
    const senderBalance = await usdtContract.balanceOf(wallet.address);
    if (senderBalance < amountInWei) {
      throw new Error("Insufficient USDT balance");
    }

    // Send transaction
    const tx = await usdtContract.transfer(toAddress, amountInWei, {
      gasLimit,
      gasPrice
    });
    
    //console.log(`Transaction sent: https://bscscan.com/tx/${tx.hash}`);
    
    // Wait for confirmation
    const receipt = await tx.wait();
    result.success = receipt.status === 1;
    result.data = {
      token: "USDT",
      txHash: receipt.hash,
      to: toAddress,
      amount: amount.toString(),
      amountInWei: amountInWei.toString(),
      gasUsed: receipt.gasUsed.toString(),
      blockNumber: receipt.blockNumber,
      status: receipt.status === 1 ? true : false,
    };

    return result;

  } catch (error) {
    result.error = error.message;
    return result;
  }
}

/*(async () => {
  try {
    const result = await transferUSDT('0x142D6844246A431f3Dda1EB9fEA1D81c3eb5691B', 1, '6fdf4f71eeb71531aa6812e9faafbc18714a60ecf2c92f592ed');

    console.log("🚀 Result:", result);
  } catch (err) {
    console.error("❌ Error:", err.message);
  }
})();*/

/*(async () => {
    try {
    const result = await sendBNB('0x142D6844246A431f3Dda1EB9fEA1D81c3eb5691B', 0.20, '6fdf4f71eeb71531aa6812e9faafbc18714a60ecf2c92f592ed');

    console.log("🚀 Result:", result);
  } catch (err) {
    console.error("❌ Error:", err.message);
  }
})();*/

function getPrivateKeyFromMnemonic(mnemonic, derivationPath = "m/44'/60'/0'/0/0") {
    try {
        // Validate mnemonic (throws error if invalid)
        const validatedMnemonic = Mnemonic.fromPhrase(mnemonic);

        // Derive wallet from mnemonic and path
        const wallet = Wallet.fromPhrase(mnemonic, derivationPath);

        return {
            privateKey: wallet.privateKey,
            address: wallet.address,
            derivationPath
        };
    } catch (error) {
        //console.error("Error deriving private key:", error.message);
        throw error;
    }
}

/*const wall = ethers.HDNodeWallet.fromMnemonic(
    ethers.Mnemonic.fromPhrase("")
);*/


async function generateWallet() {
    try {
        const provider = new ethers.JsonRpcProvider(url);
          // Create a new random wallet
        const wallet = ethers.Wallet.createRandom();
        const walletWithProvider = wallet.connect(provider);

        return {
            address: walletWithProvider.address,
            privateKey: walletWithProvider.privateKey,
            mnemonic: walletWithProvider.mnemonic,
        };
    } catch (error) {
        //console.error("Error generating wallet:", error);
        throw error;
    }
}

app.post('/api/generate-wallet', async (req, res) => {
    try {
        const walletData = await generateWallet();
        res.json(walletData);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

app.post('/api/transfer-usdt', async (req, res) => {

    const { toAddress, amount, privatekey } = req.body;

    if (!ethers.isAddress(toAddress)) {
        return res.status(400).json({ error: "Invalid recipient address" });
    }

    if (isNaN(amount) || amount <= 0) {
        return res.status(400).json({ error: "Invalid amount" });
    }

    //check if private key is provided
    if (!privatekey || !ethers.isHexString(privatekey)) {
        return res.status(400).json({ error: "Invalid or missing private key" });
    }

    try {

        const result = await transferUSDT(toAddress, amount, privatekey);
        if (result.success) {
          res.json(result.data);
        } else {
          res.status(400).json({ error: result.error });
        }

    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

app.post('/api/check-address', async (req, res) => {

    const { toAddress } = req.body;

    if (!ethers.isAddress(toAddress)) {

        return res.status(200).json({ status: false, message: "Invalid recipient address" });

    } else {

       return res.status(200).json({ status: true, message: "Address is valid" });

    }

});

app.post('/api/transfer-bnb', async (req, res) => {

    const { toAddress, amount, privatekey } = req.body;

    if (!ethers.isAddress(toAddress)) {
        return res.status(400).json({ error: "Invalid recipient address" });
    }

    if (isNaN(amount) || amount <= 0) {
        return res.status(400).json({ error: "Invalid amount" });
    }

    //check if private key is provided
    if (!privatekey || !ethers.isHexString(privatekey)) {
        return res.status(400).json({ error: "Invalid or missing private key" });
    }

    try {
        const receipt = await sendBNB(toAddress, amount, privatekey);
        res.json({
            status: "success",
            transactionHash: receipt.transactionHash,
            blockNumber: receipt.blockNumber,
        });

    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

app.post('/api/batch-balances', async (req, res) => {

  const { addresses } = req.body;
  if (!Array.isArray(addresses) || addresses.length === 0) {
    return res.status(400).json({ error: "Please provide a non-empty addresses array" });
  }
  try {
    const balances = await batchFetchBalances(addresses);
    res.json({ success: true, balances });
  } catch (err) {
    //console.error("Batch balances error:", err);
    res.status(500).json({ error: "Failed to fetch batch balances" });
  }

});


const PORT = process.env.PORT || 3000;
const bindAddress = process.env.NODE_ENV === 'production' ? '127.0.0.1' : 'localhost';

app.listen(PORT, bindAddress, () => {
    //console.log(`Server running in ${process.env.NODE_ENV} mode`);
    //console.log(`Access: http://${bindAddress}:${PORT}`);
});