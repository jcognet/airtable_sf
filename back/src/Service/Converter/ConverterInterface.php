<?php
declare(strict_types=1);

namespace App\Service\Converter;

use App\ValueObject\BlockInterface;

interface ConverterInterface
{
    public function convert(BlockInterface $block): BlockInterface;
}
