<?php
declare(strict_types=1);

namespace App\ValueObject\ToDo;

use App\ValueObject\BlockInterface;

class ItemList implements BlockInterface
{
    private const BLOCK_INTERFACE_TYPE = 'list_todo';

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

    public function getType(): string
    {
        return self::BLOCK_INTERFACE_TYPE;
    }
}
