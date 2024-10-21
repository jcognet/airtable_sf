<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Run;

use App\ValueObject\Run\NextRun;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class NextRunDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): NextRun
    {
        if (isset($data['date'])) {
            $data['date'] = Carbon::parse($data['date']);
        }

        return new NextRun(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === NextRun::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
