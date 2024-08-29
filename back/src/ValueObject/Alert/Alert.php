<?php
declare(strict_types=1);

namespace App\ValueObject\Alert;

use App\Enum\Alert\LevelEnum;
use App\Enum\Alert\TypeEnum;
use Carbon\Carbon;

class Alert
{
    public function __construct(
        private readonly string $message,
        private readonly Carbon $lastDate,
        private readonly int $nbDays,
        private readonly LevelEnum $level,
        private readonly TypeEnum $type,
        private readonly ?array $extraData = null
    ) {}

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getLastDate(): Carbon
    {
        return $this->lastDate;
    }

    public function getNbDays(): int
    {
        return $this->nbDays;
    }

    public function getLevel(): LevelEnum
    {
        return $this->level;
    }

    public function getType(): TypeEnum
    {
        return $this->type;
    }

    public function getExtraData(): ?array
    {
        return $this->extraData;
    }
}
