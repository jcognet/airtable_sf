<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Random;

use App\ValueObject\Random\ImageUrl;
use App\ValueObject\Random\ListImageUrl;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ListImageUrlDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $imageUrlDernormalizer = new ImageUrlDenormalizer();
        $listImageURl = [];

        foreach ($data['content'] as $imageUrl) {
            $listImageURl[] = $imageUrlDernormalizer->denormalize($imageUrl, ImageUrl::class);
        }

        $data['listImages'] = $listImageURl;
        unset($data['content']);

        return (new ObjectNormalizer())->denormalize($data, ListImageUrl::class);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === ListImageUrl::class;
    }
}
