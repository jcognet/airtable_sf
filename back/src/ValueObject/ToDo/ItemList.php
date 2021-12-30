<?php
declare(strict_types=1);

namespace App\ValueObject\ToDo;

use App\ValueObject\BlockInterface;
use App\ValueObject\NewsletterBlockManager\BlockType;

class ItemList implements BlockInterface
{
    private string $title;
    private array $toDos;

    public function __construct(
        string $title,
        array $toDos
    ) {
        $this->title = $title;
        $this->toDos = $toDos;
    }

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
        return new BlockType(BlockType::LIST_TODO_BLOCK);
    }
}
