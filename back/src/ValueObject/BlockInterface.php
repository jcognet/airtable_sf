<?php
declare(strict_types=1);

namespace App\ValueObject;

interface BlockInterface
{
    public function getTitle(): string;

    public function getContent();

    public function getType(): string;
}
