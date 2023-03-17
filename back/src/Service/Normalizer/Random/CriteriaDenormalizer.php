<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Random;

use App\ValueObject\Random\Criteria;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CriteriaDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        return new Criteria(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === Criteria::class;
    }
}
