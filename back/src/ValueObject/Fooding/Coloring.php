<?php
declare(strict_types=1);

namespace App\ValueObject\Fooding;

use App\Service\Contract\OccurenceInterface;
use Carbon\Carbon;

class Coloring implements OccurenceInterface
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
