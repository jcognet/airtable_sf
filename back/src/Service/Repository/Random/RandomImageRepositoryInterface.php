<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\ValueObject\BlockInterface;

interface RandomImageRepositoryInterface
{
    public function fetchRandomData(array $param = []): BlockInterface;
}
