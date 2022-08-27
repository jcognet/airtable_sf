<?php
declare(strict_types=1);

namespace App\Service\Mailer;

use Carbon\Carbon;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ErrorSender
{
    private const SUBJECT = 'Fun Effect erreur du %s';

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

    public function send(\Throwable $e): void
    {
        $email = (new TemplatedEmail())
            ->to($this->mailerTo)
            ->from($this->mailerFrom)
            ->subject(sprintf(self::SUBJECT, Carbon::now()->format('d/m/Y')))
            ->htmlTemplate('email/error.html.twig')
            ->context([
                'text' => $e->getMessage(),
                'date' => Carbon::now(),
            ])
        ;

        $this->mailer->send($email);
    }
}
