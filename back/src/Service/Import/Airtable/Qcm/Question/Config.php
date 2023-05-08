<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Qcm\Question;

class Config
{
    public function __construct(
        private readonly string $questionPath
    ) {
    }

    public function getFileName(): string
    {
        return sprintf('%s%s', $this->questionPath, 'questions.json');
    }
}
