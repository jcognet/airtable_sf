<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Lpo;

use App\ValueObject\Lpo\ImportedBird;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ImportedBirdDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        return (new ObjectNormalizer())->denormalize($data, ImportedBird::class, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === ImportedBird::class;
    }
}
