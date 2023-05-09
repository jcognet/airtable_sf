<?php
declare(strict_types=1);

namespace App\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class QuizExtension extends AbstractExtension
{
    public function __construct()
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('code_question_key', $this->codeQuestionKey(...)),
        ];
    }

    private function codeQuestionKey(string $question): string
    {
        return base64_encode($question);
    }
}
