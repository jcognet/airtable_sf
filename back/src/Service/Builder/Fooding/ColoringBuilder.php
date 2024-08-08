<?php
declare(strict_types=1);

namespace App\Service\Builder\Fooding;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Fooding\Coloring;
use Carbon\Carbon;

class ColoringBuilder implements BuilderInterface
{
    public function build(array $data): ?Coloring
    {
        if (!isset($data['fields']['Jour'])) {
            return null;
        }

        return new Coloring(
            date: Carbon::parse($data['fields']['Jour']),
            comment: $data['fields']['Commentaire'] ?? null
        );
    }
}
