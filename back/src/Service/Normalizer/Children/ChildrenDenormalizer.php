<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Children;

use App\ValueObject\Children\Child;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ChildrenDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Child
    {
        $data['birthDay'] = Carbon::parse($data['birthDay']);

        return new Child(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === Child::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
