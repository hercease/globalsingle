// Install tonweb before running:
// npm install tonweb
// Install tonweb first: npm install tonweb
const TonWeb = require('tonweb');
const { mnemonicToPrivateKey } = require('ton-crypto');
// Paste your 12-word mnemonic here:
const mnemonic = [
    "area", "what", "skirt", "lake", "million", "powder", "ball", "tomato", "always", "test", "glad", "control", "fringe", "drama", "immune", "stock", "bubble", "alcohol", "century", "enough", "stone", "evidence", "control", "eternal"
];

(async () => {
    try {
        const keyPair = await mnemonicToPrivateKey(mnemonic);

        console.log("===================================");
        console.log("🔑 Your PUBLIC KEY:");
        console.log(TonWeb.utils.bytesToHex(keyPair.publicKey));
        console.log("-----------------------------------");
        console.log("🔒 Your PRIVATE KEY:");
        console.log(TonWeb.utils.bytesToHex(keyPair.secretKey));
        console.log("===================================");
    } catch (err) {
        console.error("❌ Error deriving key:", err.message);
    }
})();