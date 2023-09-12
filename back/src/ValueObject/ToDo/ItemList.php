<?php
declare(strict_types=1);

namespace App\ValueObject\ToDo;

use App\ValueObject\AbstractBlock;
use App\ValueObject\NewsletterBlockManager\BlockType;

class ItemList extends AbstractBlock
{
    public function __construct(private readonly string $title, private readonly array $toDos) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): array
    {
        return $this->toDos;
    }

    public function getType(): BlockType
    {
        return BlockType::LIST_TODO_BLOCK;
    }
}
