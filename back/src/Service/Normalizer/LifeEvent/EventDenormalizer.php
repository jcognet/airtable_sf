<?php
declare(strict_types=1);

namespace App\Service\Normalizer\LifeEvent;

use App\ValueObject\LifeEvent\Event;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class EventDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Event
    {
        $data['date'] = Carbon::parse($data['date']);

        return new Event(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Event::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
