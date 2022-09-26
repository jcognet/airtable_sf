<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\ValueObject\Picture\Picture;

class PictureFactory
{
    private EncoderDecoder $encoderDecoder;

    public function __construct(EncoderDecoder $encoderDecoder)
    {
        $this->encoderDecoder = $encoderDecoder;
    }

    public function get(string $absolutePath): Picture
    {
        return new Picture(
            $this->encoderDecoder->encode($absolutePath),
            $absolutePath,
        );
    }
}
