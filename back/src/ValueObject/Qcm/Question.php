<?php
declare(strict_types=1);

namespace App\ValueObject\Qcm;

use Carbon\Carbon;

class Question
{
    public function __construct(
        private readonly string $id,
        private readonly string $question,
        private readonly string $goodAnwser,
        private readonly ?string $wrongAnswer1,
        private readonly ?string $wrongAnswer2,
        private readonly ?string $wrongAnswer3,
        private readonly ?string $explanation,
        private readonly ?string $url,
        private readonly ?Carbon $usedDate
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getGoodAnwser(): string
    {
        return $this->goodAnwser;
    }

    public function getWrongAnswer1(): ?string
    {
        return $this->wrongAnswer1;
    }

    public function getWrongAnswer2(): ?string
    {
        return $this->wrongAnswer2;
    }

    public function getWrongAnswer3(): ?string
    {
        return $this->wrongAnswer3;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getUsedDate(): ?Carbon
    {
        return $this->usedDate;
    }
}
