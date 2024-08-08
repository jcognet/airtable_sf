<?php
declare(strict_types=1);

namespace App\ValueObject\Fooding;

use Carbon\Carbon;

class Cut
{
    public function __construct(
        private readonly Carbon $date,
        private readonly ?string $comment
    ) {}

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}
