<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\ValueObject\Newspaper;
use Twig\Environment;

class NewspaperRenderer
{
    private ?string $cache = null;

    public function __construct(
        private readonly Environment $twig
    ) {
    }

    public function renderHtml(
        Newspaper $newspaper,
        bool $showBlock = false
    ): string {
        if ($this->cache === null) {
            $this->cache = $this->twig->render(
                'email/newsletter.html.twig',
                [
                    'newspaper' => $newspaper,
                    'date' => $newspaper->getDate(),
                    'show_block' => $showBlock,
                ]
            );
        }

        return $this->cache;
    }

    public function resetHtml(): void
    {
        $this->cache = null;
    }
}
