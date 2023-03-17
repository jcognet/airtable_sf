<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Run;

use App\ValueObject\Run\ListBlockNextRun;
use App\ValueObject\Run\NextRun;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ListBlockNextRunDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $nextRunDenormalizer = new NextRunDenormalizer();
        $listRuns = [];

        foreach ($data['content'] as $imageUrl) {
            $listRuns[] = $nextRunDenormalizer->denormalize($imageUrl, NextRun::class);
        }

        $data['runs'] = $listRuns;
        unset($data['content']);

        return (new ObjectNormalizer())->denormalize($data, ListBlockNextRun::class);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === ListBlockNextRun::class;
    }
}
