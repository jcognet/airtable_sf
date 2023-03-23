<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Beer;

use App\ValueObject\Beer\Beer;
use App\ValueObject\Beer\BeerList;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BeerListDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): BeerList
    {
        $beerDenormalizer = new BeerDenormalizer();
        $beers = [];

        foreach ($data['content'] as $beer) {
            $beers[] = $beerDenormalizer->denormalize($beer, Beer::class, $format, $context);
        }

        $data['beers'] = $beers;
        unset($data['content'], $data['class']);

        return new BeerList(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === BeerList::class;
    }
}
