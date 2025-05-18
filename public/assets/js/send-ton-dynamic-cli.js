// send-ton-dynamic-cli.js
import { sendTonDynamic } from './send-ton-dynamic.js';

const [,, mnemonic, toAddress, amountTon, forceVersion] = process.argv;

(async () => {
    try {
        const txResult = await sendTonDynamic({
            mnemonic,
            toAddress,
            amountTon,
            forceVersion
        });

        // Always respond in JSON format
        console.log(JSON.stringify({
            status: true,
            message: 'Transaction Sent Successfully!',
            result: txResult,
            tranx_hash: txResult.transaction_hash
        }));
    } catch (e) {
        console.error(JSON.stringify({
            status: false,
            error: e.message || 'Unknown Error'
        }));
        process.exit(1); // mark as failed
    }
})();
