<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Meteo;

use App\ValueObject\Meteo\MeteoItem;
use App\ValueObject\Meteo\Weather;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class MeteoItemDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): MeteoItem
    {
        $data['day'] = Carbon::parse($data['day']);
        $data['weather'] = (new WeatherDenormalizer())->denormalize($data['weather'], Weather::class, $format, $context);

        return new MeteoItem(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === MeteoItem::class;
    }
}
