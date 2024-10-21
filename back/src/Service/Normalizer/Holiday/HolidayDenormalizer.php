<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Holiday;

use App\ValueObject\Holiday\Holiday;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class HolidayDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Holiday
    {
        $data['startDate'] = Carbon::parse($data['startDate']);
        $data['endDate'] = Carbon::parse($data['endDate']);

        unset($data['class'], $data['managerType'], $data['managerTypeValue']);

        return new Holiday(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Holiday::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
