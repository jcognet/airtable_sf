<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Inr;

use App\ValueObject\Inr\Inr491Item;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Inr491ItemDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Inr491Item
    {
        return new Inr491Item(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Inr491Item::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
