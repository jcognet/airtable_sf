<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Mailer\Sender;
use App\ValueObject\Newspaper;
use Carbon\Carbon;

class Manager
{
    private Sender $sender;
    private SundayManager $sundayManager;
    private WeekManager $weekManager;

    public function __construct(
        SundayManager $sundayManager,
        WeekManager $weekManager,
        Sender $sender
    ) {
        $this->sender = $sender;
        $this->sundayManager = $sundayManager;
        $this->weekManager = $weekManager;
    }

    public function handle(Carbon $date): void
    {
        $this->sendContent($this->createContent($date));
    }

    public function createContent(Carbon $date): Newspaper
    {
        if ($date->isWeekend()) {
            $manager = $this->sundayManager;
        } else {
            $manager = $this->weekManager;
        }

        return $manager->createNewsletter($date);
    }

    private function sendContent(Newspaper $content): void
    {
        $this > $this->sender->send($content);
    }
}
