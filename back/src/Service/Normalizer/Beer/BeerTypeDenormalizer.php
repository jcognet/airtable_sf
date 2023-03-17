<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Beer;

use App\ValueObject\Beer\BeerType;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BeerTypeDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        return new BeerType(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === BeerType::class;
    }
}
