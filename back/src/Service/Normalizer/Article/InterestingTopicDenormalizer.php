<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Article;

use App\ValueObject\Article\InterestingTopic;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class InterestingTopicDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        unset($data['content'], $data['class']);

        return new InterestingTopic(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === InterestingTopic::class;
    }
}
