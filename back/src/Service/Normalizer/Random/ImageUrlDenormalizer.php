<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Random;

use App\ValueObject\Random\ImageUrl;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ImageUrlDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $data['url'] = $data['content'];

        return (new ObjectNormalizer())->denormalize($data, ImageUrl::class, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === ImageUrl::class;
    }
}
