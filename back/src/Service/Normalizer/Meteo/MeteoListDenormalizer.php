<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Meteo;

use App\ValueObject\Meteo\MeteoItem;
use App\ValueObject\Meteo\MeteoList;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class MeteoListDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $meteoItemLists = [];
        $denormalizer = new MeteoItemDenormalizer();

        foreach ($data['meteoItemLists'] as $meteoItem) {
            $meteoItemLists[] = $denormalizer->denormalize($meteoItem, MeteoItem::class, $format, $context);
        }

        $data['meteoItemLists'] = $meteoItemLists;

        return (new ObjectNormalizer())->denormalize($data, MeteoList::class, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === MeteoList::class;
    }
}
