<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Qcm\Question;

use App\Service\Import\Airtable\AbstractConfig;

class Config extends AbstractConfig
{
    public function getFileName(): string
    {
        return 'questions.json';
    }

    public function getSubPath(): string
    {
        return 'question/';
    }
}
