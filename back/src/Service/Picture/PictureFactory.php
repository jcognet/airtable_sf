<?php
declare(strict_types=1);

namespace App\Service\Picture;

use App\ValueObject\Picture\Picture;

class PictureFactory
{
    public function __construct(private readonly EncoderDecoder $encoderDecoder) {}

    public function get(string $absolutePath): Picture
    {
        return new Picture(
            $this->encoderDecoder->encode($absolutePath),
            $absolutePath,
        );
    }
}
