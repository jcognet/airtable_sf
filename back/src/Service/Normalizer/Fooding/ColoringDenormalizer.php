<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Fooding;

use App\ValueObject\Fooding\Coloring;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ColoringDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Coloring
    {
        $data['date'] = Carbon::parse($data['date']);

        return new Coloring(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === Coloring::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
