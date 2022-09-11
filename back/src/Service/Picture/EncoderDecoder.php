<?php
declare(strict_types=1);

namespace App\Service\Picture;

class EncoderDecoder
{
    public function encode(string $string): string
    {
        return base64_encode($string);
    }

    public function decode(string $string): string
    {
        return base64_decode($string, true);
    }
}
