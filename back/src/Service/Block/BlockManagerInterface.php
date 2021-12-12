<?php
declare(strict_types=1);

namespace App\Service\Block;

use App\ValueObject\BlockInterface;

interface BlockManagerInterface
{
    public function getContent(): BlockInterface;
}
