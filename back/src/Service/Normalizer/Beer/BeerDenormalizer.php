<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Beer;

use App\Service\Normalizer\Picture\CachedImageDenormalizer;
use App\ValueObject\Beer\Beer;
use App\ValueObject\Beer\BeerType;
use App\ValueObject\Beer\Brewery;
use App\ValueObject\Picture\CachedImage;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BeerDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Beer
    {
        if (isset($data['beerType'])) {
            $data['beerType'] = (new BeerTypeDenormalizer())->denormalize($data['beerType'], BeerType::class, $format, $context);
        }

        if (isset($data['brasserie'])) {
            $data['brasserie'] = (new BreweryDenormalizer())->denormalize($data['brasserie'], Brewery::class, $format, $context);
        }

        if (isset($data['photo'])) {
            $data['photo'] = (new CachedImageDenormalizer())->denormalize($data['photo'], CachedImage::class, $format, $context);
        }

        if (isset($data['dateTest'])) {
            $data['dateTest'] = Carbon::parse($data['dateTest']);
        }

        unset($data['content'], $data['class']);

        return new Beer(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === Beer::class;
    }
}
