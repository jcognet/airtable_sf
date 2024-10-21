<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Picture;

use App\ValueObject\Picture\Picture;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PictureDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Picture
    {
        return new Picture(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Picture::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
