<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Fooding\Cut;

use App\ValueObject\Fooding\Cut;
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

        foreach ($list as $cut) {
            /** @var Cut $cut */
            if ($cut->getDate()->format('mY') === $cut->format('mY')) {
                $listByMonth[] = $cut;
            }
        }

        return $listByMonth;
    }
}
