<?php
declare(strict_types=1);

namespace App\Enum\Alert;

enum TypeEnum: string
{
    case CUT = 'cut';
    case COLORING = 'coloring';
    case ABS = 'abs';
    case QI = 'qi';

    public function getLabel(): string
    {
        return match ($this) {
            self::ABS => 'abdo',
            self::QI => 'qi',
            self::CUT => 'coupe',
            self::COLORING => 'teinte'
        };
    }
}
