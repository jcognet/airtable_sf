<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Archive\DataInputOuputHandler;
use App\ValueObject\Archive\NewsLetter;
use Carbon\Carbon;

class Manager
{
    private DataInputOuputHandler $dataInputOuputHandler;
    private Creater $creater;

    public function __construct(
        DataInputOuputHandler $dataInputOuputHandler,
        Creater $creater
    ) {
        $this->dataInputOuputHandler = $dataInputOuputHandler;
        $this->creater = $creater;
    }

    public function get(Carbon $date): NewsLetter
    {
        if ($newsLetter = $this->dataInputOuputHandler->get($date)) {
            return $newsLetter;
        }

        $this->creater->createContent($date);
        $archiveNewsLetter = new NewsLetter(
            $date,
            $this->creater->getHtml(),
            false
        );

        $this->dataInputOuputHandler->write(
            $archiveNewsLetter
        );

        return $archiveNewsLetter;
    }
}
