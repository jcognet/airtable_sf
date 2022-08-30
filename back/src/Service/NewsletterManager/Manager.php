<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Archive\DataInputOuputHandler;
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

    public function getHtml(Carbon $date): string
    {
        if ($content = $this->dataInputOuputHandler->getHtml($date)) {
            return $content;
        }

        $this->creater->createContent($date);
        $this->dataInputOuputHandler->write(
            $this->creater->getHtml(),
            $date
        );

        return $this->creater->getHtml();
    }
}
