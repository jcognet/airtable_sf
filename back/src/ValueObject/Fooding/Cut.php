<?php
declare(strict_types=1);

namespace App\ValueObject\Fooding;

use App\Service\Contract\OccurrenceInterface;
use Carbon\Carbon;

class Cut implements OccurrenceInterface
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
