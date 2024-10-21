<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Run;

use App\ValueObject\Run\ListBlockNextRun;
use App\ValueObject\Run\NextRun;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ListBlockNextRunDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): ListBlockNextRun
    {
        $nextRunDenormalizer = new NextRunDenormalizer();
        $listRuns = [];

        foreach ($data['content'] as $run) {
            $listRuns[] = $nextRunDenormalizer->denormalize($run, NextRun::class, $format, $context);
        }

        $data['runs'] = $listRuns;
        unset($data['content']);

        return (new ObjectNormalizer())->denormalize($data, ListBlockNextRun::class, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === ListBlockNextRun::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
