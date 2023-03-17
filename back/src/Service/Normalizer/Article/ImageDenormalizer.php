<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Article;

use App\Service\Normalizer\Picture\CachedImageDenormalizer;
use App\ValueObject\Article\Image;
use App\ValueObject\Article\Sujet;
use App\ValueObject\Picture\CachedImage;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ImageDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $sujets = [];
        foreach ($data['sujets'] as $sujet) {
            $sujets[] = new Sujet(
                id: $sujet['id'],
                label: $sujet['label']
            );
        }

        $denormalizer = new ObjectNormalizer();
        $data['sujets'] = $sujets;
        $data['url'] = (new CachedImageDenormalizer())->denormalize($data['url'], CachedImage::class);
        unset($data['url']);

        return $denormalizer->denormalize($data, Image::class);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === Image::class;
    }
}
