<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Archive\DataInputOuputHandler;
use App\ValueObject\Archive\NewsLetter;
use Carbon\Carbon;

class Manager
{
    public function __construct(
        private readonly DataInputOuputHandler $dataInputOuputHandler,
        private readonly NewspaperCreator $creator,
        private readonly NewspaperRenderer $newspaperRenderer
    ) {
    }

    public function get(
        Carbon $date,
        bool $forceTwig = false
    ): NewsLetter {
        if ($newsLetter = $this->dataInputOuputHandler->get($date)) {
            if ($forceTwig) {
                $newsLetter->setNewsletterHtml(
                    $this->newspaperRenderer->renderHtml($newsLetter->getNewspaper())
                );
            }

            return $newsLetter;
        }

        $newspaper = $this->creator->createContent($date);
        $newsLetter = new NewsLetter(
            date: $date,
            newsletterHtml: $this->newspaperRenderer->renderHtml($newspaper),
            wasSent: false,
            newspaper: $newspaper
        );

        $this->dataInputOuputHandler->write(
            $newsLetter
        );

        return $newsLetter;
    }
}
