<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Meteo;

use App\ValueObject\Meteo\Weather;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class WeatherDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Weather
    {
        return new Weather(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === Weather::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
