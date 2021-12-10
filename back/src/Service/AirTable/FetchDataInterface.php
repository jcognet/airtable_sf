<?php
declare(strict_types=1);

namespace App\Service\AirTable;

use App\ValueObject\BlockInterface;

interface FetchDataInterface
{
    public function fetchData(array $param = []): BlockInterface;
}
