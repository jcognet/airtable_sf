<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

class Sujet
{
    private string $id;
    private string $label;

    public function __construct(
        string $id,
        string $label
    ) {
        $this->id = $id;
        $this->label = $label;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
