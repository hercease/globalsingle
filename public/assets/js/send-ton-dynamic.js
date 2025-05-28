// send-ton-dynamic.js
import { TonClient, WalletContractV4, WalletV5R2Contract, internal, fromNano } from 'ton';
import { mnemonicToPrivateKey } from 'ton-crypto';
import { getHttpEndpoint } from '@orbs-network/ton-access';
import { mnemonicNew } from 'ton-crypto';
import dotenv from 'dotenv';
dotenv.config();

async function sendTonDynamic({ mnemonic, toAddress, amountTon, forceVersion = null }) {
    if (!mnemonic || !toAddress || !amountTon) {
        throw new Error('Missing required fields');
    }

    const endpoint = await getHttpEndpoint({ network: 'testnet' }); // or 'mainnet'
    const client = new TonClient({ endpoint });

    // Derive keypair
    const keypair = await mnemonicToPrivateKey(mnemonic.split(' '));

    // Optionally let user FORCE a wallet version
    let wallet;
    if (forceVersion === 'v5') {
        console.log("⏩ Forcing Wallet V5R2...");
        wallet = WalletV5R2Contract.create({ publicKey: keypair.publicKey, workchain: 0 });
    } else {
        console.log("⏩ Defaulting to Wallet V4...");
        wallet = WalletContractV4.create({ publicKey: keypair.publicKey, workchain: 0 });
    }

    const walletAddress = wallet.address.toString();
    console.log('Your Wallet Address:', walletAddress);

    // Fetch wallet info
    const walletContract = client.open(wallet);
    const seqno = await walletContract.getSeqno();
    console.log('Current Seqno:', seqno);

    // Create the transfer
    const transfer = walletContract.sendTransfer({
        secretKey: keypair.secretKey,
        seqno,
        messages: [
            internal({
                to: toAddress,
                value: BigInt(Math.floor(parseFloat(amountTon) * 1e9)), // TON to nanoTON
                bounce: false,
            }),
        ],
    });

    await transfer;

    console.log(`✅ Sent ${amountTon} TON to ${toAddress} successfully!`);
}

async function transferUSDT(mnemonic, toAddress, amountUSDT, apiKey) {
  try {
    
    const client = new TonClient({
      endpoint: TON_ENDPOINT,
      apiKey: apiKey,
    });

    // 1. Get keys from mnemonic
    const keyPair = await mnemonicToWalletKey(mnemonic.split(','));

    // 2. Initialize sender's TON wallet (needed for gas)
    const wallet = WalletContractV4.create({ 
      workchain: 0, 
      publicKey: keyPair.publicKey 
    });
    const walletContract = client.open(wallet);
    const USDT_JETTON = isTestnet 
      ? "EQBl3gg6AAdjgjO2ZoNU5Q5EzUIl8XMNZrix8Z5dJmkHUfxI" 
      : "EQDQoc5M3Bh8eWFephi9bClhevelbZZvWhkqdo80XuY_0qXv";
    // 3. Initialize sender's USDT Jetton wallet
    //const USDT_JETTON = "EQDQoc5M3Bh8eWFephi9bClhevelbZZvWhkqdo80XuY_0qXv"; // Mainnet
    const senderJettonWallet = client.open(
      JettonWallet.createFromAddress(USDT_JETTON)
    );

    const tonBalance = await walletContract.getBalance();
    const minTonRequired = toNano("0.05"); // 0.05 TON
    if (tonBalance < minTonRequired) {
        throw new Error(`Add ${fromNano(minTonRequired)} TON for gas fees.`);
    }

    // 4. Check USDT balance
    const usdtBalance = await senderJettonWallet.getBalance();
    if (usdtBalance < amountUSDT * 1e6) {
      throw new Error("Insufficient USDT balance");
    }

    // 5. Send USDT
    await senderJettonWallet.sendTransfer({
      secretKey: keyPair.secretKey,
      to: toAddress,
      amount: amountUSDT * 1e6, // USDT units (6 decimals)
      forwardTonAmount: toNano("0.05"), // 0.05 TON for gas
      forwardPayload: null // Optional message
    });

    return { status: true, message: `${amountUSDT} USDT sent to ${toAddress}` };

  } catch (error) {
    return { status: false, message: `USDT transfer failed: ${error.message}` };
  }
}


// Async helper to initialize wallet
async function getWalletContract(mnemonic, apiKey) {

    const client = new TonClient({
        endpoint: TON_ENDPOINT,
        apiKey: apiKey,
    });

    const keyPair = await mnemonicToWalletKey(mnemonic.split(','));

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
    //const walletAddress = walletContract.address.toString();
    //const balance = await walletContract.getBalance();
    
    //console.log(`Wallet: ${walletAddress}`);
    //console.log(`Balance: ${balance.toString()} nanoTON`);

    if (balance < amountTon * 1e6) {
      throw new Error("Insufficient balance");
    }

    // 4. Prepare transfer
    const seqno = await walletContract.getSeqno(); // Get current seqno

     // 3. Initialize sender's USDT Jetton wallet
    const USDT_JETTON = "EQDQoc5M3Bh8eWFephi9bClhevelbZZvWhkqdo80XuY_0qXv"; // Mainnet
    const senderJettonWallet = client.open(
      JettonWallet.createFromAddress(USDT_JETTON)
    );
    // Check USDT balance
    const usdtBalance = await senderJettonWallet.getBalance();
    if (usdtBalance < amountUSDT * 1e6) {
      throw new Error("Insufficient USDT balance");
    }

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

/*app.post('/api/generate-wallet', async (req, res) => {
  try {
    const { apiKey } = req.body;
    const isTestnet = process.env.TON_NETWORK === 'testnet';
    const USDT_JETTON = isTestnet 
      ? "EQBl3gg6AAdjgjO2ZoNU5Q5EzUIl8XMNZrix8Z5dJmkHUfxI" 
      : "EQDQoc5M3Bh8eWFephi9bClhevelbZZvWhkqdo80XuY_0qXv";

    const client = new TonClient({
      endpoint: isTestnet 
        ? "https://testnet.toncenter.com/api/v2/jsonRPC" 
        : "https://toncenter.com/api/v2/jsonRPC",
      apiKey: apiKey,
    });

    // Generate base TON wallet
    const mnemonic = await mnemonicNew();
    const keyPair = await mnemonicToWalletKey(mnemonic);
    const wallet = WalletContractV4.create({ 
      workchain: 0, 
      publicKey: keyPair.publicKey 
    });
    const walletContract = client.open(wallet);
    const tonAddress = walletContract.address.toString({
      urlSafe: true,
      bounceable: false,
      testOnly: isTestnet
    });

    // Generate USDT Jetton wallet address
    const usdtJettonWallet = client.open(
      JettonWallet.createFromAddress(USDT_JETTON)
    );
    const usdtAddress = usdtJettonWallet.address.toString({
      bounceable: false,
      testOnly: isTestnet
    });

    res.json({
      mnemonic: mnemonic.join(" "),
      ton_address: tonAddress,
      usdt_jetton_address: usdtAddress,
      publicKey: keyPair.publicKey.toString('hex'),
      privateKey: keyPair.secretKey.toString('hex'),
      network: isTestnet ? "testnet" : "mainnet"
    });

  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});*/


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

app.post('/api/send-jetton', async (req, res) => {

    try {
        const { recipient, mnemonic, amount, jettonAddress } = req.body;

        // 1. Validate inputs
        if (!recipient || !amount || !jettonAddress) {
            return res.status(400).json({ error: 'Missing recipient, amount, or jettonAddress' });
        }

        // 2. Initialize TON client and wallet
        const { walletContract, keyPair } = await getWalletContract(mnemonic);
        const client = new TonClient({ endpoint: 'https://testnet.toncenter.com/api/v2/jsonRPC' });

        // 3. Get the sender's Jetton wallet address
        const senderJettonWallet = await getJettonWalletAddress(client, walletContract.address, jettonAddress);
        
        // 4. Create the Jetton transfer payload
        const transferPayload = new Cell();
        transferPayload.bits.writeUint(0xf8a7ea5, 32); // OP code for jetton transfer
        transferPayload.bits.writeUint(0, 64); // query_id (optional)
        transferPayload.bits.writeCoins(amount * 1e6); // USDT amount (in minimal units)
        transferPayload.bits.writeAddress(Address.parse(recipient)); // Recipient
        transferPayload.bits.writeAddress(Address.parse(walletContract.address)); // Response address (for excesses)
        transferPayload.bits.writeBit(0); // No custom payload
        transferPayload.bits.writeCoins(0.05); // Forward TON amount (gas)
        transferPayload.bits.writeBit(0); // No forward payload

        // 5. Send the transaction
        const seqno = await walletContract.getSeqno();
        const transfer = walletContract.createTransfer({
            seqno,
            secretKey: keyPair.secretKey,
            messages: [
                internal({
                    to: senderJettonWallet.toString(),
                    value: 0.1 * 1e9, // 0.1 TON for gas
                    bounce: true,
                    body: transferPayload
                }),
            ],
        });

        await walletContract.send(transfer);

        res.json({ 
            status: true, 
            message: 'USDT transfer initiated',
            jettonWallet: senderJettonWallet.toString()
        });

    } catch (e) {
        res.status(500).json({ status: false, error: e.message });
    }
});

// Helper: Get Jetton wallet address for a user
async function getJettonWalletAddress(client, ownerAddress, jettonMasterAddress) {
    const response = await client.runMethod(
        Address.parse(jettonMasterAddress),
        'get_wallet_address',
        [{ type: 'slice', cell: new Cell().bits.writeAddress(ownerAddress) }]
    );
    return response.stack.readAddress();
}


export { sendTonDynamic };
