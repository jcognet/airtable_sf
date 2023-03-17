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
        private readonly Creator $creator
    ) {
    }

    public function get(Carbon $date): NewsLetter
    {
        if ($newsLetter = $this->dataInputOuputHandler->get($date)) {
            return $newsLetter;
        }

        $this->creator->createContent($date);
        $archiveNewsLetter = new NewsLetter(
            date: $date,
            newsletterHtml: $this->creator->getHtml(),
            wasSent: false,
            blocks: $this->creator->getBlocks()
        );

        $this->dataInputOuputHandler->write(
            $archiveNewsLetter
        );

        return $archiveNewsLetter;
    }
}
