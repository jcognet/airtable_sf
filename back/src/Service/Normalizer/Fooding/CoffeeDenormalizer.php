<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Fooding;

use App\ValueObject\Fooding\Coffee;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CoffeeDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Coffee
    {
        $data['date'] = Carbon::parse($data['date']);

        return new Coffee(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === Coffee::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
