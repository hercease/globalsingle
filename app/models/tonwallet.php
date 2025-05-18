<?php

require __DIR__ . '../../views/includes/vendor/autoload.php';

use Elliptic\EC;
use BN\BN;

class TONWallet
{
    private $apiKey;
    private $walletAddress;
    private $privateKey;
    private $toncenterApiUrl = 'https://testnet.toncenter.com/api/v2/';
    private $ec;
    private $logger;
    private $lastError = '';

    public function __construct(
        string $apiKey,
        string $walletAddress,
        string $privateKey,
        string $logFile = 'ton_transfers.log'
    ) {
        // Initialize cryptography
        $this->ec = new EC('secp256k1');

        $this->privateKey = $this->cleanPrivateKey($privateKey);
        
        // Validate private key format (64 hex chars)
        if (!preg_match('/^[0-9a-f]{64}$/i', $privateKey)) {
            throw new InvalidArgumentException('Invalid private key format - must be 64-character hex string');
        }

         // Double verification
        if (!preg_match('/^[a-f0-9]{64}$/', $this->privateKey)) {
            throw new RuntimeException("Key validation failed after cleaning");
        }
        
        // Test key can be used
        try {
            $testKey = $this->ec->keyFromPrivate($this->privateKey, 'hex');
        } catch (Exception $e) {
            throw new RuntimeException("Key usage test failed: " . $e->getMessage());
        }
        
        $this->apiKey = $apiKey;
        $this->walletAddress = $this->normalizeAddress($walletAddress);
        
        // Initialize logger
        $this->logger = new class($logFile) {
            private $logFile;
            
            public function __construct(string $logFile) {
                $this->logFile = $logFile;
            }
            
            public function log(array $data): bool {
                $entry = array_merge([
                    'timestamp' => date('Y-m-d H:i:s'),
                    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'CLI'
                ], $data);
                
                return file_put_contents(
                    $this->logFile,
                    json_encode($entry) . PHP_EOL,
                    FILE_APPEND | LOCK_EX
                ) !== false;
            }
            
            public function getLogs(int $limit = 10): array {
                if (!file_exists($this->logFile)) return [];
                
                $lines = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $lines = array_slice(array_reverse($lines), 0, $limit);
                return array_map('json_decode', $lines, array_fill(0, count($lines), true));
            }
        };
    }

    private function cleanPrivateKey(string $privateKey): string
    {
        // Remove all non-hex characters (more strict than before)
        $cleaned = preg_replace('/[^a-f0-9]/i', '', $privateKey);
        
        // Convert to lowercase for consistency
        $cleaned = strtolower($cleaned);
        
        // Check for exactly 64 hex chars
        if (strlen($cleaned) !== 64 || !ctype_xdigit($cleaned)) {
            throw new InvalidArgumentException(
                'Invalid private key format. Must be exactly 64 hex characters.'
            );
        }
        
        // Verify the hex is valid by converting to binary and back
        $bin = hex2bin($cleaned);
        if ($bin === false) {
            throw new InvalidArgumentException(
                'Private key contains invalid hex characters'
            );
        }
        
        return $cleaned;
    }

    /* Public Interface Methods */

    public function getLastError(): string {
        return $this->lastError;
    }

    public function getPublicKey(): string {
        $key = $this->ec->keyFromPrivate($this->privateKey, 'hex');
        return $key->getPublic(true, 'hex');
    }

    public function send(
        string $recipientAddress,
        float $amountInTon,
        string $message = '',
        bool $validateBalance = true
    ): array {
        $this->lastError = '';
        
        try {
            // Validate and normalize
            $recipientAddress = $this->normalizeAddress($recipientAddress);
            
            $this->validateAddress($recipientAddress);

            /*if(!$this->validateAddress($recipientAddress)){
                return ['status' => false, 'message' => 'Invalid wallet address'];
            }*/

            // Convert amount to nanoTON
            $amountInNano = $this->tonToNano($amountInTon);

            // Check balance if requested
            if ($validateBalance) {
                $balance = $this->getBalance();
                if ($balance < $amountInTon) {
                    return ['status' => false, 'message' => 'Insufficient balance'];
                    throw new Exception("Insufficient balance. Available: {$balance} TON");

                }
            }

            // Get current seqno
            $seqno = $this->getSeqno();

            // Build transfer message
            $transferMessage = [
                'address' => $recipientAddress,
                'amount' => $amountInNano,
                'seqno' => $seqno,
                'timeout' => 300,
                'created_lt' => time() * 1000,
                'created_at' => time(),
            ];

            if (!empty($message)) {
                $transferMessage['message'] = $message;
            }

            // Securely sign and send
            $result = $this->sendTransaction($transferMessage);

            // Log success
            $this->logger->log([
                'type' => 'send',
                'status' => 'success',
                'from' => $this->walletAddress,
                'to' => $recipientAddress,
                'amount' => $amountInTon,
                'tx_hash' => $result['transaction_hash'],
                'message' => $message
            ]);

            return $result;
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            
            $this->logger->log([
                'type' => 'send',
                'status' => 'failed',
                'from' => $this->walletAddress,
                'to' => $recipientAddress,
                'amount' => $amountInTon,
                'error' => $this->lastError,
                'message' => $message
            ]);

            return ['status' => false, 'message' => $this->lastError];
        }
    }

    public function getBalance(): float {
        $url = $this->buildUrl('getAddressBalance', [
            'address' => $this->walletAddress
        ]);

        try {
            $response = $this->curlRequest($url);
            
            if (!isset($response['result'])) {
                throw new Exception("Invalid balance response");
            }

            return $response['result'] / 1000000000; // nanoTON to TON
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            return 0;
        }
    }

    public function getTransactionStatus(string $txHash): array {
        $url = $this->buildUrl('getTransaction', [
            'hash' => $txHash
        ]);

        try {
            $response = $this->curlRequest($url);
            
            if (!isset($response['result'])) {
                throw new Exception("Invalid transaction status response");
            }

            return $response['result'];
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            return ['success' => false, 'error' => $this->lastError];
        }
    }

    public function getTransactionHistory(int $limit = 10): array {
        return $this->logger->getLogs($limit);
    }

    /* Protected Cryptography Methods */

    /*protected function signMessage(array $message): string {
        $messageJson = json_encode($message);
        $messageHash = hash('sha256', $messageJson, true);
        
        $key = $this->ec->keyFromPrivate($this->privateKey, 'hex');
        $signature = $key->sign($messageHash, ['canonical' => true]);
        
        return $signature->toDER('hex');
    }*/

    private function normalizePrivateKey(string $privateKey): string
    {
        // Remove all non-hex characters (including invisible unicode)
        $clean = preg_replace('/[^0-9a-f]/i', '', $privateKey);
        
        // Convert to lowercase for consistency
        $clean = strtolower($clean);
        
        // Handle 128-character keys (some libraries include public key)
        if (strlen($clean) === 128) {
            $clean = substr($clean, 0, 64);
        }
        
        return $clean;
    }

    private function signMessage(array $message): string
    {
        // 1. Ensure proper key format
        $privateKey = $this->normalizePrivateKey($this->privateKey);
        
        // 2. Prepare message with strict JSON encoding
        $messageJson = json_encode($message, JSON_UNESCAPED_SLASHES);
        if ($messageJson === false) {
            throw new Exception("Message encoding failed: " . json_last_error_msg());
        }
        
        // 3. Create hash with proper binary handling
        $messageHash = hash('sha256', $messageJson, true);
        $hashHex = bin2hex($messageHash); // Convert to hex for safety
        
        // 4. Initialize fresh EC instance
        $ec = new EC('secp256k1');
        
        try {
            // 5. Create key pair with explicit BN conversion
            $keyBN = new BN($privateKey, 16, 'be'); // Big-endian
            $keyPair = $ec->keyFromPrivate($keyBN);
            
            // 6. Sign using hex representation of hash
            $signature = $keyPair->sign($hashHex, [
                'canonical' => true,
                'k' => function($iter) use ($privateKey, $hashHex) {
                    // Deterministic k generation (RFC 6979)
                    return $this->deterministicK($privateKey, $hashHex, $iter);
                }
            ]);
            
            // 7. Return DER-formatted signature
            return $signature->toDER('hex');
            
        } catch (Exception $e) {
            throw new Exception("Signing failed: " . $e->getMessage());
        }
    }

    private function deterministicK($privateKey, $hashHex, $iter = 0)
    {
        // RFC 6979 implementation for deterministic k
        $v = str_repeat("\x01", 32);
        $k = str_repeat("\x00", 32);
        
        $privKeyBin = hex2bin($privateKey);
        $hashBin = hex2bin($hashHex);
        
        if ($iter > 0) {
            $k = hash_hmac('sha256', $v . "\x00" . $privKeyBin . $hashBin . pack('N', $iter), $k, true);
        } else {
            $k = hash_hmac('sha256', $v . "\x00" . $privKeyBin . $hashBin, $k, true);
        }
        
        $v = hash_hmac('sha256', $v, $k, true);
        
        $bn = new BN(bin2hex($v), 16);
        $n = (new EC('secp256k1'))->n;
        
        if ($bn->cmp($n) >= 0 || $bn->isZero()) {
            return $this->deterministicK($privateKey, $hashHex, $iter + 1);
        }
        
        return $bn;
    }

    /* Private Helper Methods */

    private function sendTransaction(array $transferMessage): array {
        $url = $this->buildUrl('sendQuery');
        $signature = $this->signMessage($transferMessage);

        error_log($url);
        
        $payload = [
            'address' => $this->walletAddress,
            'message' => $transferMessage,
            'signature' => $signature,
        ];

        error_log(json_encode($payload));
        
        $response = $this->curlRequest($url, 'POST', $payload);
        
        if (!isset($response['ok']) || !$response['ok']) {
            $error = $response['error'] ?? 'Unknown error';
            throw new Exception("TON API error: $error");
        }
        
        return [
            'status' => true,
            'transaction_hash' => $response['result']['hash'],
            'details' => $response['result'],
        ];
    }

    private function normalizeAddress(string $address): string
    {
        // Standardize formatting
        $address = str_replace(['ton://', ' '], '', trim($address));
        
        // Convert hex to raw if needed
        /*if (preg_match('/^(-?\d):([0-9a-f]{64})$/i', $address, $matches)) {
            $workchain = $matches[1];
            $hash = $matches[2];
            // Here you'd convert to raw format using TON libraries
            // This is just a placeholder - actual conversion requires TON SDK
            return $this->hexToRawAddress($workchain, $hash);
        }*/
        
        return $address;
    }

    private function validateAddress(string $address): bool
    {
        // Remove URI prefix if present
        $address = str_replace('ton://', '', trim($address));
        
        // Check for raw format (48 chars)
        if (preg_match('/^[A-Za-z0-9_-]{48}$/', $address)) {
            return true;
        }
        
        // Check for hex format (with workchain)
        if (preg_match('/^-?\d:[0-9a-fA-F]{64}$/', $address)) {
            return true;
        }
        
        // Check for user-friendly format
        if (preg_match('/^[A-Za-z0-9_]{24,60}$/', $address)) {
            return true;
        }
        
        return false;
        // If none of the formats match, throw an exception
        throw new InvalidArgumentException(
            "Invalid TON address format. Valid formats:\n" .
            "- Raw: EQCD... (48 chars)\n" .
            "- Hex: -1:fcb91a... (with workchain)\n" .
            "- User-friendly: EQBvG1... (24-60 chars)"
        );
    }

    private function tonToNano(float $ton): int {
        return (int)($ton * 1000000000);
    }

    private function getSeqno(): int {
        $url = $this->buildUrl('getAddressInformation', [
            'address' => $this->walletAddress
        ]);

        $response = $this->curlRequest($url);
        
        if (!isset($response['result']['block_id']['seqno'])) {
            throw new Exception("Seqno not found in response");
        }

        return $response['result']['block_id']['seqno'];
    }

    private function buildUrl(string $endpoint, array $params = []): string {
        $params['api_key'] = $this->apiKey;
        return $this->toncenterApiUrl . $endpoint . '?' . http_build_query($params);
    }

    private function curlRequest(string $url, string $method = 'GET', array $data = []): array {
        $ch = curl_init();
        
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2TLS,
        ];
        
        if ($method === 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
            $options[CURLOPT_HTTPHEADER] = ['Content-Type: application/json'];
        }
        
        curl_setopt_array($ch, $options);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($error) throw new Exception("cURL error: $error");
        if ($httpCode !== 200) throw new Exception("API request failed with HTTP code $httpCode");
        
        $result = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) throw new Exception("Invalid JSON response");
        
        return $result;
    }
}

/* Example Usage */
