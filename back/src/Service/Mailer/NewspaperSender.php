<?php
declare(strict_types=1);

namespace App\Service\Mailer;

use Carbon\Carbon;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class NewspaperSender
{
    private const SUBJECT = 'Fun Effect newsletter du %s';

    public function __construct(private readonly MailerInterface $mailer, private readonly string $mailerFrom, private readonly string $mailerTo)
    {
    }

    public function send(string $content): void
    {
        $email = (new TemplatedEmail())
            ->to($this->mailerTo)
            ->from($this->mailerFrom)
            ->subject(sprintf(self::SUBJECT, Carbon::now()->format('d/m/Y')))
            ->html($content)
        ;

        $this->mailer->send($email);
    }
}
