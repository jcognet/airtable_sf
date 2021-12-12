<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

class Status
{
    public const IN_PROGRESS = 'in_progress';
    public const TO_DO = 'to_do';

    public const AT_IN_PROGRESS = 'In progress';
    public const AT_TO_DO = 'Todo';

    private const CONVERT_FROM_AIRTABLE = [
        self::AT_IN_PROGRESS => self::IN_PROGRESS,
        self::AT_TO_DO => self::TO_DO,
    ];

    public string $value;

    public function __construct(string $status)
    {
        if (!isset(self::CONVERT_FROM_AIRTABLE[$status])) {
            throw new \InvalidArgumentException(sprintf('Wrong status, got: %s, expected: %s', $status, implode(',', self::CONVERT_FROM_AIRTABLE)));
        }

        $this->value = self::CONVERT_FROM_AIRTABLE[$status];
    }
}
