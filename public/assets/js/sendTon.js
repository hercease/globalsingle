// ton-api.js
require('dotenv').config();
const express = require('express');
const { TonClient, WalletContractV4, internal, JettonWallet,  WalletContractV5R1, beginCell, Cell, JettonMaster, external, storeMessage  } = require('@ton/ton');
 //const { TonClient, WalletContractV4, internal, Address, Cell } = require('ton');
const { mnemonicToWalletKey, mnemonicNew, sign  } = require('ton-crypto');
const TonWeb = require('tonweb');
const { Mnemonic } = require('tonweb-mnemonic');
const bip39 = require('bip39');
const { HDKey } = require('@scure/bip32');
const { mnemonicToSeedSync } = require('bip39');
const axios = require('axios');
const { Address, toNano } = require('@ton/core');
const { AssetsSDK, createApi, createSender, importKey } = require('@ton-community/sandbox');

const isTestnet = process.env.TON_NETWORK === 'testnet';
// TON uses ED25519 (same as Solana/Cardano) — compatible with tonweb
const TON_ENDPOINT = isTestnet ? 'https://testnet.toncenter.com/api/v2/jsonRPC' : 'https://toncenter.com/api/v2/jsonRPC';
//const JettonMaster = isTestnet ? 'EQC_PyAE-oAvcROg1ITZKhLg3g9xX1QhNACzj-7KOYFVeEjY' : 'EQDQoc5M3Bh8eWFephi9bClhevelbZZvWhkqdo80XuY_0qXv'; // Use testnet or mainnet JettonMaster

const app = express();
app.use(express.json());

// Load .env variables
//const MNEMONIC = process.env.MNEMONIC.split(',');
//const TON_API_KEY = process.env.TON_API_KEY;
const WORKCHAIN_ID = 0; // Default for most wallets
// Initialize TON Client

// Usage example for USDT transfer
/*transferJetton(
    'small,silver,usual,short,ghost,grace,power,zone,mosquito,helmet,feed,grow,fortune,unfair,cancel,lecture,lumber,around,flavor,file,deposit,mobile,riot,ginger', 
    'UQBfmzQKWQKR9MD26gIqnnIBcSRAmTTqUHRI84WmQnfLi3T6', // Sender's USDT jetton wallet address
    'UQBE8dSZuymb3R48z_FR7iQLtDNUVqc-gEhR59yBX20gkLII', 
    0.05 // Amount of USDT to send
).then(console.log);*/


// Known Jetton Master Addresses
const JETTON_MASTERS = {
    USDT: {
        testnet: 'kQCKt2WPGX-fh0cIAz38Ljd_OKQjoZE_cqk7QrYGsNP6wfP0',
        mainnet: 'EQDcBkGHmC4pTf34x3Gm05XvepO5w60DNxZ-XT4I6-UGG5L5'
    }
};



async function getJettonWalletAddress(client, ownerAddress, jettonMasterAddress) {
    const jettonMaster = client.open(JettonMaster.create(Address.parse(jettonMasterAddress)));
    return await jettonMaster.getWalletAddress(ownerAddress);
}

function createJettonPayload(recipientAddress, amount) {
  
    const body = beginCell();
    body.storeUint(0x10, 6); // `ext_in_msg_info$10` prefix
    body.storeUint(0xf8a7ea5, 32); // Jetton transfer opcode
    body.storeUint(0, 64); // query-id
    body.storeCoins(amount);
    body.storeAddress(parseAddress(recipientAddress));
    body.storeAddress(parseAddress(recipientAddress || recipientAddress));
    body.storeBit(0); // no custom payload
    body.storeCoins(BigInt(0));

    return body.endCell();
}

//const payloadCell = createJettonPayload("EQBfmzQKWQKR9MD26gIqnnIBcSRAmTTqUHRI84WmQnfLiyk_", 1000000000); // 1 Jetton
//const boc = payloadCell.toBoc().toString("base64"); // Convert to Base64 for API submission
//console.log("BOC Payload:", boc);

const fetch = require("node-fetch");

async function sendTransaction(boc) {
    const response = await fetch("https://toncenter.com/api/v2/sendBoc", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ boc }),
    });

    const result = await response.json();
    console.log("Transaction Result:", result);
}

//sendTransaction("te6cckEBAQEAVwAAqUA+KfqUAAAAAAAAAAEO5rKAIAL82aBSyBSPpge3UBFU85ALiSIEyadSg6JHnC0yE75cXABfmzQKWQKR9MD26gIqnnIBcSRAmTTqUHRI84WmQnfLiwQg2ilt");


function createJettonTransferBody(params) {
    const body = beginCell();
    
    body.storeUint(0xf8a7ea5, 32); // Jetton transfer opcode
    body.storeUint(0, 64); // query-id
    body.storeCoins(params.jettonAmount);
    body.storeAddress(params.toAddress);
    body.storeAddress(params.responseAddress || params.toAddress);
    body.storeBit(0); // no custom payload
    body.storeCoins(params.forwardAmount || BigInt(0));
    
    if (params.forwardPayload) {
        body.storeBit(1);
        body.storeRef(params.forwardPayload);
    } else {
        body.storeBit(0);
    }
    
    return body.endCell();
}

async function getUserJettonWalletAddress(userAddress, jettonMasterAddress) {
  const userAddressCell = beginCell().storeAddress(Address.parse(userAddress)).endCell();

  const response = await client.runMethod(Address.parse(jettonMasterAddress), 'get_wallet_address', [
    { type: 'slice', cell: userAddressCell },
  ]);

  return response.stack.readAddress();
}

async function generateJettonTransferBOC(params) {
    try {
        // Validate parameters
        if (!params.mnemonic || !params.recipient || !params.amount) {
            throw new Error('Missing required parameters');
        }


        const client = new TonClient({
            endpoint: 'https://toncenter.com/api/v2/jsonRPC',
            apiKey: process.env.TON_API_KEY,
        });

        // 1. Init wallet
        const keyPair = await mnemonicToWalletKey(params.mnemonic.split(' '));
        const wallet = WalletContractV5R1.create({ workchain: 0, publicKey: keyPair.publicKey });
        const walletContract = client.open(wallet);
        const walletAddress = wallet.address;
console.log('Wallet Address:', walletAddress.toString());
        // 2. Get Jetton Wallet Address
        const jettonWalletAddress = await getJettonWalletAddress(client, walletAddress,  "EQDcBkGHmC4pTf34x3Gm05XvepO5w60DNxZ-XT4I6-UGG5L5"); // USDT Testne
        const amountNumber = parseFloat(params.amount);
        const jettonAmount = BigInt(Math.round(amountNumber * 1e6));
        console.log('Jetton Wallet Address:', jettonAmount);
        // 3. Build transfer payload
        const transferBody = beginCell()
            .storeUint(0x0f8a7ea5, 32) // Jetton transfer op code
            .storeUint(0, 64) // query_id
            .storeCoins(jettonAmount) // USDT uses 6 decimals
            .storeAddress(Address.parse(params.recipient)) // to
            .storeAddress(walletAddress) // response address
            .storeBit(0) // no custom payload
            .storeCoins(toNano(params.forwardAmount || '0.05')) // forward TON
            .storeBit(0) // no forward payload
            .endCell();

        // 4. Get seqno
        const seqno = await walletContract.getSeqno();

       // await client.isContractDeployed(Address.parse(address))
        const USDT_MASTER_ADDRESS = 'EQDcBkGHmC4pTf34x3Gm05XvepO5w60DNxZ-XT4I6-UGG5L5'; // USDT Testnet Master Address
        const isDeployed = await client.isContractDeployed(Address.parse(USDT_MASTER_ADDRESS));
        if (!isDeployed) {
            throw new Error('Jetton Master contract is not deployed. Please check the address.');
        }
        // 5. Build internal message to Jetton Wallet
        const transfer = walletContract.createTransfer({
            seqno,
            secretKey: keyPair.secretKey,
            messages: [
                internal({
                    to: jettonWalletAddress,
                    value: toNano('0.15'), // Enough gas
                    body: transferBody,
                    bounce: true,
                }),
            ]
        });

       
       const balance = await client.getBalance(wallet.address);
        console.log('Wallet Balance:', balance.toString());

     let neededInit = null;
    const { init } = walletContract;
    if (init && !isDeployed) {
        neededInit = init;
    }

    const externalMessage = external({
        to: walletAddress,
        init: neededInit,
        transfer,
    });

    const externalMessageCell = beginCell().store(storeMessage(externalMessage)).endCell();

    const signedTransaction = externalMessageCell.toBoc();
    const hash = externalMessageCell.hash().toString('hex');

    console.log('hash:', hash);
        //const boc = transfer.toBoc({ mode: 'external' });
        //return boc.toString('base64');
        //await walletContract.send(transfer);
        await client.sendFile(signedTransaction);

    } catch (err) {
        console.error('BOC generation failed:', err);
        throw err;
    }

}


// Example Usage
(async () => {
    try {
        const boc = await generateJettonTransferBOC({
            mnemonic: 'small silver usual short ghost grace power zone mosquito helmet feed grow fortune unfair cancel lecture lumber around flavor file deposit mobile riot ginger',
            recipient: 'EQBE8dSZuymb3R48z_FR7iQLtDNUVqc-gEhR59yBX20gkO_N', // Testnet address
            amount: '1.1', // USDT amount
            forwardAmount: '0.05' // Optional
        });

        console.log('Generated BOC (base64):');
        console.log(boc);

        // Now you can send this BOC using toncenter API
        // Example with axios:
       /* const response = await axios.post('https://toncenter.com/api/v2/sendBoc', {
            boc: boc
        }, {
            headers: { 'X-API-Key': process.env.TON_API_KEY }
        });
        console.log('Transaction response:', response);*/
    } catch (error) {
        console.error('Error:', error.message);
    }
})();
// Example usage
/*(async () => {
    const boc = await createJettonTransferBOC({
        mnemonic: "small silver usual short ghost grace power zone mosquito helmet feed grow fortune unfair cancel lecture lumber around flavor file deposit mobile riot ginger",
        toAddress: "UQBE8dSZuymb3R48z_FR7iQLtDNUVqc-gEhR59yBX20gkLII",
        jettonWalletAddress: "EQBfmzQKWQKR9MD26gIqnnIBcSRAmTTqUHRI84WmQnfLiyk_",
        amount: "2.5" // 2.5 USDT (Jetton with 6 decimals)
    });
    console.log("Jetton transfer BOC (base64):", boc);
})();*/

function parseAddress(input) {
    try {
        // Handle undefined/null
        if (!input) throw new Error('Empty address');
        
        // Remove URI prefix if exists
        const cleanInput = input.toString().replace(/^ton:\/\//i, '');
        
        // Parse friendly address (EQ...)
        if (cleanInput.startsWith('EQ') || cleanInput.startsWith('UQ')) {
            const parsed = Address.parseFriendly(cleanInput);
            return parsed.address;
        }
        
        // Parse raw address (0:... or -1:...)
        if (cleanInput.match(/^(-1|0):[0-9a-fA-F]{64}$/)) {
            return Address.parse(cleanInput);
        }
        
        throw new Error('Unrecognized address format');
    } catch (e) {
        throw new Error(`Invalid address (${input}): ${e.message}`);
    }
}



async function sendJetton(
    senderMnemonic,
    recipientAddress,
    amt,
    options = {}
) {
    // Set default options
    options = {
        jettonSymbol: 'USDT',
        isTestnet: true,
        forwardAmount: '0',
        ...options
    };

    const client = new TonClient({
        endpoint:  'https://toncenter.com/api/v2/jsonRPC',
        apiKey: process.env.TON_API_KEY,
    });

    try {
        // 1. Prepare sender wallet
        const key = await mnemonicToWalletKey(senderMnemonic.split(' '));
        const wallet = WalletContractV5R1.create({ workchain: 0, publicKey: key.publicKey });
        const walletContract = client.open(wallet);
        console.log('Sender Wallet Address:', wallet.address.toString());
        // 2. Get sender's jetton wallet address
        const jettonMasterAddress = options.jettonMasterAddress 
            || JETTON_MASTERS[options.jettonSymbol][options.isTestnet ? 'testnet' : 'mainnet'];
        
        const senderJettonWalletAddress = await getJettonWalletAddress(
            client,
            wallet.address,
            jettonMasterAddress
        );

        console.log('Sender Jetton Wallet Address:',  senderJettonWalletAddress.toString());

        // 3. Create transfer body (USDT uses 6 decimals)
        const jettonAmount = toNano(amt) / BigInt(1000); // Convert from 9 to 6 decimals
        const cell = beginCell()
        .storeUint(0x0f8a7ea5, 32)
        .storeUint(0, 64)
        .storeCoins(jettonAmount)
        .storeAddress(parseAddress(recipientAddress))
        .storeAddress(parseAddress(wallet.address))
        .storeMaybeRef(null)
        .storeCoins(1)
        .storeMaybeRef(null)
        .endCell()

        // deserialization
        const slice = cell.beginParse();
        const op = slice.loadUint(32);
        const queryId = slice.loadUint(64);
        const amount = slice.loadCoins();
        const destination = slice.loadAddress();
        const responseDestination = slice.loadAddress();
        const customPayload = slice.loadMaybeRef();
        const fwdAmount = slice.loadCoins();
        const fwdPayload = slice.loadMaybeRef();

        console.log('destination:', destination.toString());

        const body = createJettonTransferBody({
            jettonAmount: jettonAmount,
            toAddress: Address.parse(recipientAddress),
            responseAddress: wallet.address,
            forwardAmount: toNano(options.forwardAmount),
            forwardPayload: options.forwardPayload
        });

        const transferMessage = { op, queryId, amount, destination, responseDestination, customPayload, fwdAmount, fwdPayload };
console.log('Transfer message:', transferMessage);
        // 4. Send transfer
        const seqno = await walletContract.getSeqno();
        await walletContract.createTransfer({
            secretKey: key.secretKey,
            seqno: seqno,
            messages: [{
                address: 'EQBfmzQKWQKR9MD26gIqnnIBcSRAmTTqUHRI84WmQnfLiyk_',
                value: toNano('0.15'), // Enough for transfer + potential deployment
                body: transferMessage,
            }],
            sendMode: 3, // Important for Jetton transfers
        });

        const result = await client.sendExternalMessage(walletContract, transfer);

        return {
            success: true,
            senderJettonWallet: senderJettonWalletAddress.toString(),
            jettonAmount: amount,
            fee: '0.15 TON',
            explorerLink: `${options.isTestnet ? 'https://testnet.tonviewer.com' : 'https://tonviewer.com'}/${senderJettonWalletAddress.toString()}`
        };

    } catch (error) {
        console.error('Transfer failed:', error);
        return {
            success: false,
            error: error.message,
            hint: error.message.includes('exit_code') 
                ? 'Recipient may not have a Jetton wallet' 
                : 'Check your balance and network settings'
        };
    }
}

// Example usage
/*(async () => {
    const result = await sendJetton(
        'small silver usual short ghost grace power zone mosquito helmet feed grow fortune unfair cancel lecture lumber around flavor file deposit mobile riot ginger', // Your 24-word seed phrase
        'UQBE8dSZuymb3R48z_FR7iQLtDNUVqc-gEhR59yBX20gkLII', // Recipient's TON address
        '0.2', // Amount of USDT to send
        {
            isTestnet: false, // Set false for mainnet
            forwardAmount: '0.05' // Optional: TON to forward with the transfer
        }
    );
    
    console.log(result.success 
        ? `✅ Transfer sent! View on explorer: ${result.explorerLink}`
        : `❌ Failed: ${result.error}`
    );
})();
*/
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
            let wallet = WalletContractV5R1.create({ workchain : 0, publicKey: keyPair.publicKey });
            let walletContract = client.open(wallet);
            //console.log(walletContract);
            // Get wallet address
            const address = walletContract.address;
            //console.log(address);
    
            //console.log("Testnet?", isTestnet);
    
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

    app.post('/api/transfer-fund', async (req, res) => {

        const { mnemonic, toAddress, amountUSDT, apiKey } = req.body;

        if (!mnemonic || !toAddress || !amountUSDT || !apiKey) {
            return res.status(400).json({ error: 'Missing required fields' });
        }

        try {

            const result = await transferUSDT(mnemonic, toAddress, amountUSDT, apiKey);
            res.json(result);

        } catch (error) {

            console.error('Transfer error:', error);
            res.status(500).json({ status: false, message: `Transfer failed: ${error.message}` });

        }
    });

    app.post('/api/send-jetton', async (req, res) => {
        try {
            const { recipient, mnemonic, amount, jettonAddress } = req.body;

            // Validate inputs
            if (!recipient || !amount || !jettonAddress || !mnemonic) {
                return res.status(400).json({ error: 'Missing required fields' });
            }

            // Init TON client
            const client = new TonClient({ 
                endpoint: TON_ENDPOINT
            });

            // Get wallet from mnemonic
            const keyPair = await mnemonicToWalletKey(mnemonic.split(','));
            const wallet = WalletContractV4.create({ workchain: 0, publicKey: keyPair.publicKey });
            const walletContract = client.open(wallet);

            // Get sender's Jetton Wallet address
            const jettonMaster = client.open(JettonMaster.create(Address.parse(jettonAddress)));
            const senderJettonWalletAddress = await jettonMaster.getWalletAddress(wallet.address);
            const senderJettonWallet = client.open(JettonWallet.create(senderJettonWalletAddress));

            // Verify recipient has a Jetton wallet (optional but recommended)
            try {
                const recipientJettonWalletAddress = await jettonMaster.getWalletAddress(Address.parse(recipient));
                await client.getBalance(recipientJettonWalletAddress);
            } catch {
                console.warn('Recipient might not have a Jetton wallet initialized');
            }

            // Prepare transfer (USDT uses 6 decimals, not 9)
            const transferBody = await senderJettonWallet.createTransferBody({
                to: Address.parse(recipient),
                jettonAmount: BigInt(Math.floor(amount * 1e6)), // USDT uses 6 decimals
                forwardTonAmount: toNano('0.05'), // Gas for forwarding
                responseAddress: wallet.address, // Where to send excess TON
            });

            // Send transaction
            const seqno = await walletContract.getSeqno();
            await walletContract.sendTransfer({
                seqno,
                secretKey: keyPair.secretKey,
                messages: [{
                    to: senderJettonWallet.address,
                    value: toNano('0.15'), // Enough for transfer + gas
                    body: transferBody
                }]
            });

            res.json({
                status: true,
                message: `Sent ${amount} USDT to ${recipient}`,
                txData: {
                    senderJettonWallet: senderJettonWallet.address.toString(),
                    estimatedFee: '0.15 TON'
                }
            });

        } catch (e) {
            console.error('Jetton transfer failed:', e);
            res.status(500).json({ 
                status: false, 
                error: e.message,
                hint: e.message.includes('exit_code') ? 'Recipient may not have a Jetton wallet' : ''
            });
        }
    });

    // Helper: Get Jetton wallet address for a use

    async function getMasterAddressFromWallet(jettonWalletAddress) {
        const client = new TonClient({ endpoint: 'https://toncenter.com/api/v2/jsonRPC' });
        const jettonWallet = client.open(JettonWallet.create(Address.parse(jettonWalletAddress)));
        return (await jettonWallet.getData()).masterAddress;
    }

    /*getMasterAddressFromWallet('UQBfmzQKWQKR9MD26gIqnnIBcSRAmTTqUHRI84WmQnfLi3T6').then(masterAddress => {
        console.log('Master Address:', masterAddress);
    }).catch(error => {
        console.error('Error fetching master address:', error);
    });*/

    // Start server
    const PORT = process.env.PORT || 3000;
    const bindAddress = process.env.NODE_ENV === 'production' ? '127.0.0.1' : 'localhost';

    app.listen(PORT, bindAddress, () => {
        console.log(`Server running in ${process.env.NODE_ENV} mode`);
        console.log(`Access: http://${bindAddress}:${PORT}`);
    });

// Compare this snippet from public/assets/js/send-ton.js:
// // send-ton.js
