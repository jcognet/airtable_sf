<?php
declare(strict_types=1);

namespace App\Service\Builder\Fooding;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Fooding\Abs;
use Carbon\Carbon;

class AbsBuilder implements BuilderInterface
{
    public function build(array $data): ?Abs
    {
        if (!isset($data['fields']['Jour'])) {
            return null;
        }

        return new Abs(
            date: Carbon::parse($data['fields']['Jour']),
            comment: $data['fields']['Commentaire'] ?? null,
            quantity: $data['fields']['Quantité'],
            isExempt: $data['fields']['Exempté'] ?? false,
        );
    }
}
