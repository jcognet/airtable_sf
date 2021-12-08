<?php
declare(strict_types=1);

namespace App\Service\Builder;

use App\ValueObject\BlockInterface;

interface BuilderInterface
{
    public function build(array $data): BlockInterface;
}
