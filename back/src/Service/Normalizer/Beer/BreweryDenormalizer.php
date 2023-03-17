<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Beer;

use App\ValueObject\Beer\Brewery;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BreweryDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        return new Brewery(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === Brewery::class;
    }
}
