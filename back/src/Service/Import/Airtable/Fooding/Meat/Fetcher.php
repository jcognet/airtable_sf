<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Meat;

use App\ValueObject\Fooding\Meat;
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

        foreach ($list as $meat) {
            /** @var Meat $meat */
            if ($meat->getDate()->format('mY') === $date->format('mY')) {
                $listByMonth[] = $meat;
            }
        }

        return $listByMonth;
    }
}
