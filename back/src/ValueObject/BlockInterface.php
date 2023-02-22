<?php
declare(strict_types=1);

namespace App\ValueObject;

use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\NewsletterBlockManager\ManagerType;

interface BlockInterface
{
    public function getTitle(): string;

    public function getContent();

    public function getType(): BlockType;

    public function setManagerType(string $blockManager): void;

    public function getManagerType(): ?ManagerType;
}
