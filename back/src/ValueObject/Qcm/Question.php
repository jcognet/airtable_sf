<?php
declare(strict_types=1);

namespace App\ValueObject\Qcm;

use App\ValueObject\AbstractBlock;
use App\ValueObject\LastUsedTrait;
use App\ValueObject\NewsletterBlockManager\BlockType;
use Symfony\Component\Serializer\Annotation\Ignore;

class Question extends AbstractBlock
{
    use LastUsedTrait;

    public function __construct(
        private readonly string $id,
        private readonly string $question,
        private readonly string $answer,
        private readonly ?string $wrongAnswer1,
        private readonly ?string $wrongAnswer2,
        private readonly ?string $wrongAnswer3,
        private readonly ?string $explanation,
        private readonly ?string $url,
        private readonly string $airTableUrl
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

    public function getAnswer(): string
    {
        return $this->answer;
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

    #[Ignore]
    public function getRandomizedQuestions(): array
    {
        $list = [
            $this->answer,
            $this->getWrongAnswer1(),
            $this->getWrongAnswer2(),
            $this->getWrongAnswer3(),
        ];
        shuffle($list);

        return $list;
    }

    #[Ignore]
    public function getTitle(): string
    {
        return $this->question;
    }

    #[Ignore]
    public function getContent()
    {
        return $this->getRandomizedQuestions();
    }

    #[Ignore]
    public function getType(): BlockType
    {
        return BlockType::QUIZ;
    }

    public function getAirTableUrl(): string
    {
        return $this->airTableUrl;
    }
}
