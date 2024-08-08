<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Coloring;

use App\ValueObject\Fooding\Coloring;
use Carbon\Carbon;

class Fetcher
{
    public function __construct(private readonly Lister $lister) {}

    public function fetch(): ?array
    {
        return $this->lister->list();
    }

    public function getByMonth(Carbon $date): ?array
    {
        $list = $this->fetch();
        $listByMonth = [];

        if (!$list) {
            return null;
        }

        foreach ($list as $coloring) {
            /** @var Coloring $coloring */
            if ($coloring->getDate()->format('mY') === $date->format('mY')) {
                $listByMonth[] = $coloring;
            }
        }

        return $listByMonth;
    }
}
