<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Random;

use App\ValueObject\Random\ImageUrl;
use App\ValueObject\Random\ListImageUrl;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ListImageUrlDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): ListImageUrl
    {
        $imageUrlDernormalizer = new ImageUrlDenormalizer();
        $listImageUrl = [];

        foreach ($data['content'] as $imageUrl) {
            $listImageUrl[] = $imageUrlDernormalizer->denormalize($imageUrl, ImageUrl::class, $format, $context);
        }

        $data['listImages'] = $listImageUrl;
        unset($data['content']);

        return (new ObjectNormalizer())->denormalize($data, ListImageUrl::class, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === ListImageUrl::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
