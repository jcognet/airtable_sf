<?php
declare(strict_types=1);

namespace App\ValueObject;

class Theme
{
    public function __construct(private readonly string $mainColor, private readonly string $secondaryColor)
    {
    }

    public function getMainColor(): string
    {
        return $this->mainColor;
    }

    public function getSecondaryColor(): string
    {
        return $this->secondaryColor;
    }
}
