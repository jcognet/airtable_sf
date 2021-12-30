<?php
declare(strict_types=1);

namespace App\ValueObject;

use App\ValueObject\NewsletterBlockManager\BlockType;

interface BlockInterface
{
    public function getTitle(): string;

    public function getContent();

    public function getType(): BlockType;
}
