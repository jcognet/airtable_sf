<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Fooding;

use App\ValueObject\Fooding\Abs;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AbsDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Abs
    {
        $data['date'] = Carbon::parse($data['date']);
        $data['isExempt'] = $data['exempt'];
        unset($data['exempt']);

        return new Abs(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === Abs::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
