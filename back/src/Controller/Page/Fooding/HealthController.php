<?php
declare(strict_types=1);

namespace App\Controller\Page\Fooding;

use Symfony\Component\Routing\Attribute\Route;
use App\Service\Fooding\ConsumptionGetter;
use App\Service\Fooding\ConsumptionLister;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $template = filter_var($request->query->get('fetch', null), FILTER_VALIDATE_BOOLEAN)
            ? 'fooding/include/data.html.twig' :
            'fooding/health.html.twig';

        return $this->render(
            $template,
            [
                'first_day_month' => $date->copy()->firstOfMonth(),
                'date' => $readableMonth,
                'now' => Carbon::now(),
                'next_item' => $nextMonthFormat,
                'prev_item' => $date->copy()->subMonth()->format('Y-m'),
                'head_title' => sprintf('Consommation de café et de viande du mois %s', $readableMonth),
                'consumptions' => $consumptionGetter->get($date),
            ]
        );
    }

    #[Route(path: '/fooding/health/list', name: 'fooding_health_list', methods: ['GET'])]
    public function list(
        ConsumptionLister $lister
    ): Response {
        return $this->render(
            'fooding/list.html.twig',
            [
                'data' => $lister->list(),
                'head_title' => 'Consommation regroupée par viante & café',
            ]
        );
    }
}
