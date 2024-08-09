<?php
declare(strict_types=1);

namespace App\ValueObject\Alert;

enum LevelEnum: int
{
    case LOW = 0;
    case MEDIUM = 50;
    case HIGH = 100;
}
