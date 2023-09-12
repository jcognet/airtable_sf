<?php
declare(strict_types=1);

namespace App\Service\Mailer;

use Carbon\Carbon;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ErrorSender
{
    private const SUBJECT = 'Fun Effect erreur du %s';

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string $mailerFrom,
        private readonly string $mailerTo
    ) {}

    public function send(\Throwable $e): void
    {
        $email = (new TemplatedEmail())
            ->to($this->mailerTo)
            ->from($this->mailerFrom)
            ->subject(sprintf(self::SUBJECT, Carbon::now()->format('d/m/Y')))
            ->htmlTemplate('newsletter/error.html.twig')
            ->context([
                'text' => $e->getMessage(),
                'date' => Carbon::now(),
            ])
        ;

        $this->mailer->send($email);
    }
}
