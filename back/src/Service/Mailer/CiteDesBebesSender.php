<?php
declare(strict_types=1);

namespace App\Service\Mailer;

use Carbon\Carbon;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class CiteDesBebesSender
{
    private const SUBJECT = 'Cité des bébés - disponibilité %s';
    private const BODY = 'Des places sont en vente, go sur <a href="https://billetterie.cite-sciences.fr/activites.html?tx_site_offerbooking[offer]=396">le site officiel</a>.';

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string $mailerFrom,
        private readonly string $mailerTo
    ) {}

    public function send(): void
    {
        $email = (new TemplatedEmail())
            ->to($this->mailerTo)
            ->from($this->mailerFrom)
            ->subject(sprintf(self::SUBJECT, Carbon::now()->format('d/m/Y')))
            ->html(self::BODY)
        ;

        $this->mailer->send($email);
    }
}
