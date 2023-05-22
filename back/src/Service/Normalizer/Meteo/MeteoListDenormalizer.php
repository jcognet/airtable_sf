<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Meteo;

use App\ValueObject\Meteo\MeteoItem;
use App\ValueObject\Meteo\MeteoList;
use App\ValueObject\Meteo\Place;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class MeteoListDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): MeteoList
    {
        $meteoItemLists = [];
        $denormalizer = new MeteoItemDenormalizer();
        $denormalizerPlace = new PlaceDenormalizer();

        foreach ($data['meteoItemLists'] as $meteoItem) {
            $meteoItemLists[] = $denormalizer->denormalize($meteoItem, MeteoItem::class, $format, $context);
        }

        $data['meteoItemLists'] = $meteoItemLists;
        $normalizedPlace = $data['place'];
        unset($data['place']);

        $list = (new ObjectNormalizer())->denormalize($data, MeteoList::class, $format, $context);
        $list->setPlace(
            $denormalizerPlace->denormalize($normalizedPlace, Place::class, $format, $context)
        );

        return $list;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === MeteoList::class;
    }
}
