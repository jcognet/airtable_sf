<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Picture;

use App\ValueObject\Picture\CachedImage;
use App\ValueObject\Picture\Picture;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CachedImageDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $data['picture'] = new Picture(...$data['picture']);

        return new CachedImage(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === CachedImage::class;
    }
}
