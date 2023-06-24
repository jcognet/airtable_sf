<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Qcm\Question;

use App\Service\Import\Airtable\AbstractConfig;
use App\ValueObject\Qcm\Question;

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

    public function getDataEntryName(): string
    {
        return 'questions';
    }

    public function getClass(): string
    {
        return Question::class;
    }

    public function getPublicKey(): string
    {
        return 'questions';
    }

    public function getPublicLabel(): string
    {
        return 'questions';
    }
}
