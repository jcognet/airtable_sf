<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\ValueObject\Newspaper;
use Carbon\Carbon;

interface NewsletterManagerInterface
{
    public function createNewsletter(Carbon $date): Newspaper;
}
