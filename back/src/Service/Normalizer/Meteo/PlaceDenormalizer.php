<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Meteo;

use App\ValueObject\Meteo\Place;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PlaceDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Place
    {
        return (new ObjectNormalizer())->denormalize($data, Place::class, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Place::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
