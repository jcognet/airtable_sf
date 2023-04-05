<?php
declare(strict_types=1);

namespace App\Service\Archive;

use App\ValueObject\Archive\NewsLetter;
use App\ValueObject\Newspaper;
use Carbon\Carbon;

class PreviousNewsletterFetcher
{
    private const NB_NEWSLETTER = 4;

    public function __construct(
        private readonly NewsletterWriterFetcher $newsletterWriterFetcher
    ) {
    }

    /**
     * @return NewsLetter[]
     */
    public function fetchNewsletters(Carbon $date): array
    {
        $newsletters = [];
        $tmpDate = $date->copy();

        for ($i = 0; $i < self::NB_NEWSLETTER; ++$i) {
            $newsletter = $this->newsletterWriterFetcher->get($tmpDate->subDay()->copy());

            if ($newsletter === null) {
                return $newsletters;
            }

            $newsletters[] = $newsletter;
        }

        return $newsletters;
    }

    /**
     * @return Newspaper[]
     */
    public function fetchNewspapers(Carbon $date): array
    {
        $newspapers = [];

        foreach ($this->fetchNewsletters($date) as $newsLetter) {
            $newspapers[] = $newsLetter->getNewspaper();
        }

        return $newspapers;
    }
}
