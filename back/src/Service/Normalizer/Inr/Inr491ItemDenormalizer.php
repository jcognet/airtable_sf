<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Inr;

use App\ValueObject\Inr\Inr491Item;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Inr491ItemDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        return new Inr491Item(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === Inr491Item::class;
    }
}