<?php
declare(strict_types=1);

namespace App\Service\Mailer;

use App\ValueObject\CiteDesBebes\AvailibilitySales;
use Carbon\Carbon;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class CiteDesBebesSender
{
    private const SUBJECT_OPEN = 'Cité des bébés - disponibilité %s';
    private const SUBJECT_END = 'Cité des bébés - FIN DES disponibilité %s';
    private const BODY_OPEN = 'Des places sont en vente, go sur <a href="https://billetterie.cite-sciences.fr/activites.html?tx_site_offerbooking[offer]=396">le site officiel</a>.';
    private const BODY_END = 'Plus de places en ventes.';

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string $mailerFrom,
        private readonly string $mailerTo
    ) {}

    public function send(AvailibilitySales $sales): void
    {
        if (!$sales->hasStateChanged()) {
            return;
        }

        $email = (new TemplatedEmail())
            ->to($this->mailerTo)
            ->from($this->mailerFrom)
        ;

        if ($sales->isSalesOpen()) {
            $email->subject(
                sprintf(self::SUBJECT_OPEN, Carbon::now()->format('d/m/Y'))
            )
                ->html(self::BODY_OPEN)
            ;
        } else {
            $email->subject(
                sprintf(self::SUBJECT_END, Carbon::now()->format('d/m/Y'))
            )
                ->html(self::BODY_END)
            ;
        }

        $this->mailer->send($email);
    }
}
