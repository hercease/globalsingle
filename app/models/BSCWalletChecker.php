<?php

require __DIR__ . '../../views/includes/vendor/autoload.php';

use Web3\Web3;
use Web3\Contract;
use Web3\Utils;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;

class BSCWalletChecker
{
    private Web3 $web3;
    private Contract $usdtContract;
    private string $usdtAddress;
    private int $usdtDecimals = 18; // default fallback if init() not called

    public function __construct(string $rpcUrl = 'https://rpc.ankr.com/bsc/6a514830e8a01b71197e804ee9d4b7dd1a6711b24f2274592082f949bc9141a2', string $usdtContractAddress = '0x55d398326f99059fF775485246999027B3197955') {
    $this->web3 = new Web3($rpcUrl);
    $this->usdtAddress = $usdtContractAddress;

    $abi = json_encode([
        [
            "constant" => true,
            "inputs" => [["name" => "_owner", "type" => "address"]],
            "name" => "balanceOf",
            "outputs" => [["name" => "balance", "type" => "uint256"]],
            "type" => "function",
        ],
        [
            "constant" => true,
            "inputs" => [],
            "name" => "decimals",
            "outputs" => [["name" => "", "type" => "uint8"]],
            "type" => "function",
        ],
    ]);

    $this->usdtContract = new Contract($this->web3->provider, $abi);
    $this->usdtContract->at($this->usdtAddress);
}


    public function init(): void
    {
        $this->usdtContract->call('decimals', function ($err, $result) {
            if ($err !== null) {
                throw new \Exception("Failed to fetch USDT decimals: " . $err->getMessage());
            }
            $this->usdtDecimals = $result[0];
        });
    }

    public function getUsdtBalance(string $walletAddress): string
    {
        $balance = '0';

        $this->usdtContract->call('balanceOf', $walletAddress, function ($err, $result) use (&$balance) {
            if ($err !== null) {
                throw new \Exception("Error fetching USDT balance: " . $err->getMessage());
            }

            $raw = $result[0]->toString();
            $balance = bcdiv($raw, bcpow('10', $this->usdtDecimals), 6);
        });

        return $balance;
    }

    public function getBnbBalance(string $walletAddress): string
    {
        $balance = '0';

        $this->web3->eth->getBalance($walletAddress, function ($err, $result) use (&$balance) {
            if ($err !== null) {
                throw new \Exception("Error fetching BNB balance: " . $err->getMessage());
            }

            $balance = Utils::fromWei($result, 'ether');
        });

        return $balance;
    }
}

