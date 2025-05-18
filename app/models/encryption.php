<?php

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;

class EncryptionHelper
{
    private Key $key;

    public function __construct(string $keyString)
    {
        $this->key = Key::loadFromAsciiSafeString($keyString);
    }

    public function encrypt(string $plaintext): string
    {
        return Crypto::encrypt($plaintext, $this->key);
    }

    public function encryptToBase64(string $plaintext): string
    {
        return base64_encode($this->encrypt($plaintext));
    }

    public function decrypt(string $ciphertext): string
    {
        return Crypto::decrypt($ciphertext, $this->key);
    }

    public function decryptFromBase64(string $base64Ciphertext): string
    {
        return $this->decrypt(base64_decode($base64Ciphertext));
    }
}