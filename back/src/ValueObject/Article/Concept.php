<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

class Concept
{
    private string $name;
    private string $text;

    public function __construct(
        string $name,
        string $text
    ) {
        $this->name = $name;
        $this->text = $text;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
