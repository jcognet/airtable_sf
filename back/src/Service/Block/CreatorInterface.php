<?php
declare(strict_types=1);

namespace App\Service\Block;

use App\ValueObject\BlockInterface;

interface CreatorInterface
{
    public function getContent(): BlockInterface;
}
