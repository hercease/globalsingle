// ton-api.js
require('dotenv').config();
const express = require('express');
const { TonClient, WalletContractV4, internal, toNano, } = require('@ton/ton');
const { mnemonicToWalletKey, mnemonicNew  } = require('ton-crypto');
const TonWeb = require('tonweb');
const bip39 = require('bip39');
const { HDKey } = require('@scure/bip32');
const { mnemonicToSeedSync } = require('bip39');
const { Address } = require("@ton/ton");

const isTestnet = process.env.TON_NETWORK === 'testnet';
// TON uses ED25519 (same as Solana/Cardano) — compatible with tonweb
const TON_ENDPOINT = isTestnet ? 'https://testnet.toncenter.com/api/v2/jsonRPC' : 'https://toncenter.com/api/v2/jsonRPC';

const app = express();
app.use(express.json());

// Load .env variables
//const MNEMONIC = process.env.MNEMONIC.split(',');
//const TON_API_KEY = process.env.TON_API_KEY;
const WORKCHAIN_ID = 0; // Default for most wallets

// Initialize TON Client


// Async helper to initialize wallet
async function getWalletContract(menmonic,apiKey) {

    const client = new TonClient({
        endpoint: TON_ENDPOINT,
        apiKey: apiKey,
    });

    const keyPair = await mnemonicToWalletKey(menmonic.split(','));

    const wallet = WalletContractV4.create({
        workchain: 0,
        publicKey: keyPair.publicKey,
    });

    const walletContract = client.open(wallet);
    return { walletContract, keyPair };

}

async function waitForNewTransaction(walletContract, seqno, options = {}) {
    const {
        maxAttempts = 5,
        delayMs = 1000
    } = options;

    const lastSeqno = typeof seqno === 'string' ? BigInt(seqno) : seqno;

    for (let attempt = 1; attempt <= maxAttempts; attempt++) {
        try {
            const transactions = await client.getTransactions(walletContract.address, { limit: 1 });
            
            if (!Array.isArray(transactions)) {
                throw new Error('Invalid API response - expected array');
            }

            if (transactions.length > 0) {
                const tx = transactions[0];
                const txId = tx.transaction_id; // Destructure transaction_id
                
                if (!txId?.lt || !txId?.hash) {
                    throw new Error('Transaction missing lt or hash');
                }

                const currentLt = typeof txId.lt === 'string' ? BigInt(txId.lt) : txId.lt;
                
                if (currentLt > lastSeqno) {
                    return { // Return both critical fields
                        lt: txId.lt,
                        hash: txId.hash,
                        fullTx: tx // Optional: full transaction data
                    };
                }
            }

            await new Promise(resolve => setTimeout(resolve, delayMs));
        } catch (error) {
            console.error(`Attempt ${attempt} failed:`, error);
            if (attempt === maxAttempts) {
                throw new Error(`No new transaction found after ${maxAttempts} attempts`);
            }
            await new Promise(resolve => setTimeout(resolve, delayMs));
        }
    }
}

// Function to transfer TON
async function transferTon(mnemonic, toAddress, amountTon, apiKey) {
  try {

    const client = new TonClient({
        endpoint: TON_ENDPOINT,
        apiKey: apiKey,
    });

    //const cleaned = mnemonic.replace(/"/g, '');
    //console.log(mnemonic);

    // Step 2: Split by commas and trim each word
    //const mnemonicArray = cleaned.split(',').map(word => word.trim());
    //console.log(mnemonic.split(' '));
    const words = mnemonic.split(',');
    //console.log(words);
    // 1. Convert mnemonic to private key
    const keyPair = await mnemonicToWalletKey(words);
    //console.log(keyPair.secretKey.toString('hex'));
    // 2. Initialize wallet (v4 by default)
    const wallet = WalletContractV4.create({
      workchain: 0,
      publicKey: keyPair.publicKey,
    });
    
    // 3. Open wallet and get balance
    const walletContract = client.open(wallet);
    //console.log(walletContract);
    const walletAddress = walletContract.address.toString();
    const balance = await walletContract.getBalance();
    
    //console.log(`Wallet: ${walletAddress}`);
    //console.log(`Balance: ${balance.toString()} nanoTON`);

    if (balance < amountTon * 1e6) {
      throw new Error("Insufficient balance");
    }

    // 4. Prepare transfer
    const seqno = await walletContract.getSeqno(); // Get current seqno
    const transfer = walletContract.createTransfer({
      seqno,
      secretKey: keyPair.secretKey,
      messages: [
        internal({
          to: toAddress,
          value: amountTon * 1e6, // e.g., "1.5TON"
          body: "Automatic transfer", // Optional message
        }),
      ],
    });

    // 5. Send transaction
    await client.sendExternalMessage(walletContract, transfer);
    console.log(`Sent ${amountTon} TON to ${toAddress}`);

    return { status: true, message: "Transfer was successful" };

  } catch (error) {
    console.error("Transfer failed:", error.message);
    return { status: false, message: error.message };
  }
}

async function checkTestnetWallet(mnemonic) {
    const keyPair = await mnemonicToWalletKey(mnemonic);
    
    // Testnet wallet (workchain -1)
    const wallet = WalletContractV4.create({ 
      workchain: 0, 
      publicKey: keyPair.publicKey 
    });
  
    const client = new TonClient({ endpoint: "https://testnet.toncenter.com/api/v2/jsonRPC" });
    const walletContract = client.open(wallet);
  
    //console.log("Testnet Address:", walletContract.address.toString('hex'));
    //console.log("Workchain:", wallet.workchain);
    //console.log("Public Key:", Buffer.from(keyPair.publicKey).toString("hex"));

  }

  //checkTestnetWallet(["donate","divide","illegal","delay","impose","manage","spring","orphan","budget","chef","protect","barely","tape","category","muffin","chalk","stairs","gasp","rug","industry","bachelor","crash","text","add"]);
  //const address1 = Address.parse("EQCQ3D0QRRRSQ8T2et7dmGRnYO053wEtSCUrZfI9tf5icmdQ");
  //const address2 = Address.parse("0QCQ3D0QRRRSQ8T2et7dmGRnYO053wEtSCUrZfI9tf5icoEf");

    //console.log("Raw address 1 (hex):", Buffer.from(address1.hash).toString("hex"));
    //console.log("Raw address 2 (hex):", Buffer.from(address2.hash).toString("hex"));

app.post('/api/send-wallet-funds', async (req, res) => {

    const { mnemonic, toAddress, amountTon, apiKey } = req.body;

    if (!mnemonic || !toAddress || !amountTon || !apiKey) {
        return res.status(400).json({ error: "Missing parameters" });
    }

    const result = await transferTon(mnemonic, toAddress, parseFloat(amountTon), apiKey);
    res.json(result);

});


// API endpoint to send TON
app.post('/api/send-ton', async (req, res) => {
    try {
        const { recipient, mnemonic, amount, apiKey } = req.body;
        if (!recipient || !amount) {
            return res.status(400).json({ status: false, error: 'Missing recipient or amount' });
        }

        const { walletContract, keyPair } = await getWalletContract(mnemonic,apiKey);
        const seqno = await walletContract.getSeqno();
        const balance = await walletContract.getBalance();

        if (balance < amount * 1e6) {
            throw new Error("Withdrawal is not available right now, check back after sometimes");
        }

        //console.log('Current seqno:', seqno);

        const transfer = walletContract.createTransfer({
            seqno,
            secretKey: keyPair.secretKey,
            messages: [
                internal({
                    to: recipient,
                    value: amount * 1e6,
                    bounce: false,
                    body: "GlobalSingleLine Withdrawal"
                }),
            ],
        });

        await walletContract.send(transfer);

         // Usage example:
         let newTx = null;
        try {

            //const lastKnownSeqno = "34096153000000"; // Your last known lt value as string
             newTx = await waitForNewTransaction(walletContract, seqno, {
                maxAttempts: 10,
                delayMs: 2000
            });
            
            /*console.log('New transaction details:', {
                //lt: newTx.lt.toString(),
                //hash: newTx.hash.toString()
                newTx
            });*/

        } catch (error) {
            console.error('Transaction polling failed:', error);
            // Implement your fallback logic here
        }
 
      return res.json({
             status: true,
             message: 'Transaction sent and confirmed!',
             lt: newTx.lt.toString(),
             hash: newTx.hash?.toString() || 'N/A',
             explorer: `https://testnet.tonviewer.com/${walletContract.address.toString()}`,
         });
 
    } catch (e) {
        console.error('Error sending TON:', e);
        res.status(500).json({ status: false, error: e.message });
    }
});


app.post('/api/generate-wallet', async (req, res) => {

    try {

        const { apiKey } = req.body;

        const client = new TonClient({
            endpoint: TON_ENDPOINT,
            apiKey: apiKey,
        });
        // Generate a new mnemonic phrase
        const mnemonic = await mnemonicNew();
        // Derive key pair from mnemonic
        const keyPair = await mnemonicToWalletKey(mnemonic);

        // Create a TON wallet instance
        let workchain = 0; // Usually you need a workchain 0
        let wallet = WalletContractV4.create({ workchain : 0, publicKey: keyPair.publicKey });
        let walletContract = client.open(wallet);
        //console.log(walletContract);
        // Get wallet address
        const address = walletContract.address;
        //console.log(address);

        console.log("Testnet?", isTestnet);

        res.json({

            mnemonic: mnemonic.join(" "),
            address: address.toString({ urlSafe: true,    // Use URL-safe Base64
                bounceable: true, // Non-bounceable
                testOnly: isTestnet    // Testnet
            }),
            publicKey: keyPair.publicKey.toString('hex'),
            privateKey: keyPair.secretKey.toString('hex'),

            //address: addressString, // user-friendly base64
            //publicKey: TonWeb.utils.bytesToHex(publicKey),
            //privateKey: TonWeb.utils.bytesToHex(privateKey),
        });

    } catch (error) {

        console.log("User object:", error);
        res.status(500).json({ error: error.message });

    }
});

// Start server
const PORT = process.env.PORT || 6000;
const bindAddress = process.env.NODE_ENV === 'production' ? '127.0.0.1' : '0.0.0.0';

app.listen(PORT, bindAddress, () => {
  console.log(`Server running in ${process.env.NODE_ENV} mode`);
  console.log(`Access: http://${bindAddress}:${PORT}`);
});

// Compare this snippet from public/assets/js/send-ton.js:
// // send-ton.js
