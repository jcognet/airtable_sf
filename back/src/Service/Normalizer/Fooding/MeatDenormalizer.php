<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Fooding;

use App\ValueObject\Fooding\Meat;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class MeatDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Meat
    {
        $data['date'] = Carbon::parse($data['date']);

        return new Meat(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Meat::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
