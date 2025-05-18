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

export { sendTonDynamic };
