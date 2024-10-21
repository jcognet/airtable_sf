<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Fooding;

use App\ValueObject\Fooding\Qi;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class QiDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Qi
    {
        $data['date'] = Carbon::parse($data['date']);

        return new Qi(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Qi::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
