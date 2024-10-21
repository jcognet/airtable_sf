<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Fooding;

use App\ValueObject\Fooding\Cut;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CutDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Cut
    {
        $data['date'] = Carbon::parse($data['date']);

        return new Cut(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Cut::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
