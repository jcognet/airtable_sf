<?php
declare(strict_types=1);

namespace App\Service\Builder\Run;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Run\NextRun;
use Carbon\Carbon;

class NextRunBuilder implements BuilderInterface
{
    public function build(array $data): NextRun
    {
        return new NextRun(
            title: $data['fields']['Name'] ?? null,
            date: isset($data['fields']['Date']) ? Carbon::parse($data['fields']['Date']) : null,
            distance: $data['fields']['Distance'] ?? null,
            url: $data['fields']['URL'] ?? null,
            duration: $data['fields']['Durée (min)'] ?? null,
            comment: $data['fields']['Commentaire'] ?? null,
        );
    }
}
