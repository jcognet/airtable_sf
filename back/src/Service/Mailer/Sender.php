<?php
declare(strict_types=1);

namespace App\Service\Mailer;

use App\ValueObject\Newspaper;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class Sender
{
    private const SUBJECT = 'Fun Effect newsletter';

    private MailerInterface $mailer;
    private string $mailerFrom;
    private string $mailerTo;

    public function __construct(
        MailerInterface $mailer,
        string $mailerFrom,
        string $mailerTo
    ) {
        $this->mailer = $mailer;
        $this->mailerFrom = $mailerFrom;
        $this->mailerTo = $mailerTo;
    }

    public function send(Newspaper $newspaper): void
    {
        $email = (new TemplatedEmail())
            ->to($this->mailerTo)
            ->from($this->mailerFrom)
            ->subject(self::SUBJECT)
            ->htmlTemplate('email/newsletter.html.twig')
            ->context([
                'newspaper' => $newspaper,
            ])
        ;

        $this->mailer->send($email);
    }
}
