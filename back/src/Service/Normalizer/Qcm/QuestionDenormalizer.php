<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Qcm;

use App\Service\AirTable\LastUsedManager;
use App\ValueObject\Qcm\Question;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class QuestionDenormalizer implements DenormalizerInterface
{
    public function __construct(private readonly LastUsedManager $lastUsedManager) {}

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Question
    {
        if (isset($data['usedDate'])) {
            $data['usedDate'] = Carbon::parse($data['usedDate']);
        }

        unset($data['class'], $data['managerType'], $data['managerTypeValue']);

        return $this->lastUsedManager->onPostDenormalize(Question::class, $data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Question::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
