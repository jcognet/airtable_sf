<?php
declare(strict_types=1);

namespace App\ValueObject\Children;

class ListChildren
{
    private readonly array $children;

    /**
     * @param Child[] $children
     */
    public function __construct(
        array $children
    ) {
        usort($children, static fn (Child $a, Child $b) => $a->getBirthDay() <=> $b->getBirthDay());
        $this->children = $children;
    }

    public function getChildren(): array
    {
        return $this->children;
    }
}
