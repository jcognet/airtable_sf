<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Fooding;

use App\ValueObject\Alert\Alert;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AlertDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Alert
    {
        $data['lastDate'] = Carbon::parse($data['lastDate']);

        return new Alert(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Alert::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
