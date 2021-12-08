<?php
declare(strict_types=1);

namespace App\ValueObject;

use Carbon\Carbon;

interface BlockInterface
{
    public function getTitle(): string;

    public function getBody(): string;

    public function getAddedAt(): Carbon;

    public function getType(): string;
}
