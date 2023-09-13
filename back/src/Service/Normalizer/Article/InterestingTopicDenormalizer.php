<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Article;

use App\ValueObject\Article\InterestingTopic;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class InterestingTopicDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): InterestingTopic
    {
        unset($data['content'], $data['class'], $data['managerType'], $data['managerTypeValue']);

        return new InterestingTopic(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === InterestingTopic::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
