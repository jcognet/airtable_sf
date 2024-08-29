<?php
declare(strict_types=1);

namespace App\Service\Security;

class FileEncoder
{
    public function __construct(
        private readonly string $secret,
    ) {}

    public function encode(string $content, string $nonce): string
    {
        return sodium_crypto_secretbox($content, $nonce, $this->secret);
    }

    public function decode(string $content, string $nonce): string
    {
        return sodium_crypto_secretbox_open($content, $nonce, $this->secret);
    }
}
