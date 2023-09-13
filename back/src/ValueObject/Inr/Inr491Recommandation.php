<?php
declare(strict_types=1);

namespace App\ValueObject\Inr;

class Inr491Recommandation
{
    /**
     * @var Inr491Item[]
     */
    private array $items;

    public function __construct(
        private readonly string $title,
    ) {
        $this->items = [];
    }

    public function addItem(Inr491Item $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
