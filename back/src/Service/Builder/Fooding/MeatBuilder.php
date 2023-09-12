<?php
declare(strict_types=1);

namespace App\Service\Builder\Fooding;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Fooding\Meat;
use Carbon\Carbon;

class MeatBuilder implements BuilderInterface
{
    public function build(array $data): Meat
    {
        return new Meat(
            date: Carbon::parse($data['fields']['Jour']),
            lunch: $data['fields']['Midi ?'] ?? false,
            lunchComment: $data['fields']['Repas midi'] ?? null,
            dinner: $data['fields']['Soir ?'] ?? false,
            dinnerComment: $data['fields']['Repas soir'] ?? null
        );
    }
}
