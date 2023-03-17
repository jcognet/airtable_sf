<?php
declare(strict_types=1);

namespace App\ValueObject\Article;

class Status
{
    final public const IN_PROGRESS = 'in_progress';
    final public const TO_DO = 'to_do';
    final public const SUMMARY_TO_WRITE = 'summary_to_write';

    final public const AT_IN_PROGRESS = 'In progress';
    final public const AT_TO_DO = 'Todo';
    final public const AT_SUMMARY_TO_WRITE = 'Summary to write';

    private const CONVERT_FROM_AIRTABLE = [
        self::AT_IN_PROGRESS => self::IN_PROGRESS,
        self::AT_TO_DO => self::TO_DO,
        self::AT_SUMMARY_TO_WRITE => self::SUMMARY_TO_WRITE,
    ];

    public string $value;

    public function __construct(string $status)
    {
        if (in_array($status, array_values(self::CONVERT_FROM_AIRTABLE), true)) {
            $this->value = $status;

            return;
        }

        if (!isset(self::CONVERT_FROM_AIRTABLE[$status])) {
            throw new \InvalidArgumentException(sprintf('Wrong status, got: %s, expected: %s.', $status, implode(',', array_keys(self::CONVERT_FROM_AIRTABLE))));
        }

        $this->value = self::CONVERT_FROM_AIRTABLE[$status];
    }
}
