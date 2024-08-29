<?php
declare(strict_types=1);

namespace App\ValueObject\Alert\ExtraData;

abstract class AbstractExtraData
{
    abstract public function getLabel(): string;
}
