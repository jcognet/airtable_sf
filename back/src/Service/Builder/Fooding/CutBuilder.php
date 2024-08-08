<?php
declare(strict_types=1);

namespace App\Service\Builder\Fooding;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Fooding\Cut;
use Carbon\Carbon;

class CutBuilder implements BuilderInterface
{
    public function build(array $data): ?Cut
    {
        if (!isset($data['fields']['Jour'])) {
            return null;
        }

        return new Cut(
            date: Carbon::parse($data['fields']['Jour']),
            comment: $data['fields']['Commentaire'] ?? null
        );
    }
}
