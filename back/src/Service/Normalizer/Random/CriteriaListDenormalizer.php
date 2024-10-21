<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Random;

use App\ValueObject\Random\Criteria;
use App\ValueObject\Random\CriteriaList;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CriteriaListDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): CriteriaList
    {
        $criteriaDenormalizer = new CriteriaDenormalizer();
        $criterias = [];

        if (isset($data['content'])) {
            foreach ($data['content'] as $criteria) {
                $criterias[] = $criteriaDenormalizer->denormalize($criteria, Criteria::class, $format, $context);
            }
        }

        $data['criterias'] = $criterias;
        unset($data['content']);

        return (new ObjectNormalizer())->denormalize($data, CriteriaList::class, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === CriteriaList::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
