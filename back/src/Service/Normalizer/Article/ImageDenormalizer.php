<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Article;

use App\Service\Normalizer\Picture\CachedImageDenormalizer;
use App\ValueObject\Article\Image;
use App\ValueObject\Article\Sujet;
use App\ValueObject\Picture\CachedImage;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ImageDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $sujets = [];

        if (isset($data['sujets'])) {
            foreach ($data['sujets'] as $sujet) {
                $sujets[] = new Sujet(...$sujet);
            }
        }

        $data['sujets'] = $sujets;
        $data['url'] = (new CachedImageDenormalizer())->denormalize($data['url'], CachedImage::class, $format, $context);
        $data['name'] = $data['title'];
        unset($data['class'], $data['title'], $data['content']);

        return new Image(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === Image::class;
    }
}
