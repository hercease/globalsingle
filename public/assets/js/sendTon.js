require('dotenv').config();
const express = require('express');
const { TonClient, WalletContractV5R1, internal, toNano, Address, beginCell, WalletContractV4 } = require('@ton/ton');
const { mnemonicToWalletKey, mnemonicNew } = require('@ton/crypto');
const axios = require('axios');
const app = express();
app.use(express.json());

async function getUserJettonWalletAddress(client, userAddress, jettonMasterAddress) {
  const userAddressCell = beginCell().storeAddress(userAddress).endCell();
  const response = await client.runMethod(jettonMasterAddress, 'get_wallet_address', [
    { type: 'slice', cell: userAddressCell },
  ]);
  return response.stack.readAddress();
}

async function waitForSeqnoUpdateAndGetJettonTx({
  client,
  contract,
  wallet,
  currentSeqno,
  maxAttempts = 15,
  delay = 2000,
}) {
  const start = Date.now();

  for (let i = 0; i < maxAttempts; i++) {
    const newSeqno = await contract.getSeqno();
    if (newSeqno > currentSeqno) {
      // Wait a bit before fetching Jetton transfer (just in case)
      await new Promise(resolve => setTimeout(resolve, 1000));

      // Fetch latest Jetton transfers to the wallet (direction=in)
      const url = `https://toncenter.com/api/v3/jetton/transfers?owner_address=${wallet.toString()}&direction=in&limit=5&offset=0&sort=desc`;

      try {
        const response = await axios.get(url);
        const txs = response.data?.jetton_transfers || [];

        const now = Math.floor(Date.now() / 1000); // current UNIX timestamp in seconds

        // Find the most recent tx within last 10 seconds
        const recentTx = txs.find(tx => now - tx.utime <= 10);

        if (recentTx) {
          return {
            status: true,
            lt: recentTx.transaction_lt?.toString(),
            hash: recentTx.transaction_hash,
            utime: recentTx.transaction_now,
            amount: recentTx.amount,
            from: recentTx.source?.address,
            to: recentTx.destination?.address,
          };
        } else {
          return {
            status: false,
            message: 'No recent Jetton transaction found within last 10 seconds.',
          };
        }
      } catch (error) {
        console.error('Error fetching Jetton transfers:', error.message);
        return {
          status: false,
          message: 'Failed to fetch jetton transactions.',
        };
      }
    }

    await new Promise(resolve => setTimeout(resolve, delay));
  }

  return {
    status: false,
    message: 'Seqno did not update within the given attempts.',
  };
}

async function sendUSDTJetton({ apiKey, recipient, mnemonic, amount }) {

  if (!apiKey || !recipient || !mnemonic || !amount) {
    throw new Error('Missing required parameter(s)');
  }

  const client = new TonClient({
    endpoint: 'https://toncenter.com/api/v2/jsonRPC',
    apiKey,
  });

  try {
    // Load wallet from mnemonic
    const keyPair = await mnemonicToWalletKey(mnemonic.split(' '));
    const wallet = WalletContractV4.create({ publicKey: keyPair.publicKey, workchain: 0 });
    const walletContract = client.open(wallet);
    const walletAddress = wallet.address;

    console.log('📤 Sender Wallet Address:', walletAddress.toString());

    // Jetton Master Address for USDT on testnet
    const JETTON_MASTER = Address.parse('EQCxE6mUtQJKFnGfaROTKOt1lZbDiiX1kCixRv7Nw2Id_sDs');

    // Fetch sender's Jetton wallet
     const jettonWalletAddress = await getUserJettonWalletAddress(client, walletAddress, JETTON_MASTER);
    console.log('💰 Sender Jetton Wallet:', jettonWalletAddress.toString());

    const jettonAmount = BigInt(Math.floor(amount * 1e6)); // Assuming 6 decimals
    const balance = await walletContract.getBalance();
    console.log('💵 Wallet Balance:', balance.toString());
    /*if (balance < toNano("0.1")) {
        throw new Error("Insufficient gas balance");
    }*/
    // Create Jetton Transfer Body
    const transferBody = beginCell()
      .storeUint(0x0f8a7ea5, 32) // op: transfer
      .storeUint(0, 64) // query_id
      .storeCoins(jettonAmount)
      .storeAddress(Address.parse(recipient)) // recipient address
      .storeAddress(walletAddress) // sender's address
      .storeBit(0) // no custom payload
      .storeCoins(toNano('0.05')) // forward TON
      .storeBit(1) // has payload
      .storeRef(beginCell().storeUint(0, 32).storeStringTail("USDT payout").endCell())
      .endCell();

    const seqno = await walletContract.getSeqno();
    console.log('🔄 Current seqno:', seqno);

    /*const estimatedGas = await client.estimateFee({
        address: walletContract.address,
        body: transferBody
    });*/

    // Prepare transfer
    const transfer = walletContract.createTransfer({
      seqno,
      secretKey: keyPair.secretKey,
      messages: [
        internal({
          to: jettonWalletAddress,
          value: toNano('0.15'), // enough to cover fees
          bounce: true,
          body: transferBody,
        }),
      ],
      sendMode: 3,
    });

    // Send transfer
    await walletContract.send(transfer);
    console.log(`✅ Sent ${amount} USDT Jetton to ${recipient}`);

    // Wait for confirmation
    //console.log('⏳ Waiting for transaction confirmation...');
    //const result = await waitForSeqnoUpdateAndGetTx(client, walletContract, seqno);
    const result = await waitForSeqnoUpdateAndGetJettonTx({
    client,
    contract: walletContract,
    wallet: walletContract.address, // This is the user's jetton wallet, not main wallet
    currentSeqno: seqno,
});
    console.log('✅ Transaction confirmed on-chain!');

    return {
      status: true,
      message: 'Transfer confirmed',
      from: walletAddress.toString(),
      to: recipient,
      amount,
      lt: result.lt,
      utime: result.utime,
      explorer: `https://testnet.tonviewer.com/${walletAddress.toString()}`,
    };

  } catch (error) {
    console.error('❌ Transfer failed:', error);
    return {
      status: false,
      error: error.message,
    };
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

            const result = await sendUSDTJetton(apiKey, toAddress, mnemonic, amountUSDT);
            res.json(result);

        } catch (error) {

            console.error('Transfer error:', error);
            res.status(500).json({ status: false, message: `Transfer failed: ${error.message}` });

        }
    });

/*sendUSDTJetton({
  apiKey: process.env.TON_API_KEY, // Ensure you set this environment variable
  recipient: 'EQBE8dSZuymb3R48z_FR7iQLtDNUVqc-gEhR59yBX20gkO_N',
  mnemonic: 'small silver usual short ghost grace power zone mosquito helmet feed grow fortune unfair cancel lecture lumber around flavor file deposit mobile riot ginger',
  amount: 2
  ginger rack runway biology cook crater ahead resemble barrel pipe issue crater knife orange problem desk idea energy language ladder clerk toward blouse million
}).catch(console.error);*/

(async () => {
  try {
    const result = await sendUSDTJetton({
        apiKey: process.env.TON_API_KEY, // Ensure you set this environment variable
        recipient: 'UQBfmzQKWQKR9MD26gIqnnIBcSRAmTTqUHRI84WmQnfLi3T6',
        mnemonic: 'ginger rack runway biology cook crater ahead resemble barrel pipe issue crater knife orange problem desk idea energy language ladder clerk toward blouse million',
        amount: 1.5
    });

    console.log("🚀 Result:", result);
  } catch (err) {
    console.error("❌ Error:", err.message);
  }
})();
