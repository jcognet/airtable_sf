<?php
declare(strict_types=1);

namespace App\Controller\Page\Fooding;

use App\Service\Fooding\ConsumptionGetter;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HealthController extends AbstractController
{
    #[Route(path: '/fooding/health', name: 'fooding_health', methods: ['GET'])]
    public function health(
        Request $request,
        ConsumptionGetter $consumptionGetter
    ): Response {
        Carbon::setLocale('fr');
        $monthRequest = $request->query->get('month', Carbon::now()->format('Y-m'));

        try {
            $date = Carbon::parse(sprintf('%s-1', $monthRequest));
        } catch (InvalidFormatException) {
            $date = Carbon::now();
        }

        $readableMonth = sprintf(
            '%s %d',
            $date->getTranslatedMonthName(),
            $date->year
        );

        $nextMonth = $date->copy()->addMonth();
        $nextMonthFormat = ($date->format('Ym') >= Carbon::now()->format('Ym')) ? null : $nextMonth->format('Y-m');

        return $this->render(
            'fooding/health.html.twig',
            [
                'date' => $readableMonth,
                'now' => Carbon::now(),
                'next_item' => $nextMonthFormat,
                'prev_item' => $date->copy()->subMonth()->format('Y-m'),
                'head_title' => sprintf('Consommation de café du mois %s', $readableMonth),
                'consumptions' => $consumptionGetter->get($date),
            ]
        );
    }
}
