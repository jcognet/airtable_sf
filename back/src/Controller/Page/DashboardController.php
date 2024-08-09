<?php
declare(strict_types=1);

namespace App\Controller\Page;

use App\Service\Alert\Alerter;
use App\Service\Archive\NewsletterWriterFetcher;
use App\Service\Archive\PreviousNewsletterFetcher;
use App\Service\Export\Fetcher;
use App\Service\Holiday\IsHolidayDeterminator;
use App\Service\Import\Airtable\IsListable;
use App\Service\Picture\DirectoryLister;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route(path: '/dashboard/', name: 'dashboard_show', methods: ['GET'])]
    public function show(
        Request $request,
        NewsletterWriterFetcher $newsletterWriterFetcher,
        PreviousNewsletterFetcher $previousNewsletterFetcher,
        Fetcher $exporterFetcher,
        DirectoryLister $directoryLister,
        IsHolidayDeterminator $isHolidayDeterminator,
        IsListable $isListable,
        Alerter $alerter
    ): Response {
        $date = Carbon::parse($request->query->get('date', null));

        if ($isHolidayDeterminator->isHoliday($date)) {
            return $this->redirectToRoute('dashboard_holiday', $request->query->all());
        }

        $newsletter = $newsletterWriterFetcher->get($date);

        if ($newsletter === null) {
            throw $this->createNotFoundException(sprintf('No newsletter found for date %s', $date->format('d/m/Y')));
        }

        return $this->render(
            'dashboard/show.html.twig',
            [
                'newspaper_date' => $newsletter->getNewspaper()->getDate(),
                'newspaper' => $newsletter->getNewspaper(),
                'previous_newspapers' => $previousNewsletterFetcher->fetchNewspapers($date),
                'kpi' => $exporterFetcher->fetch($date),
                'directory_image_list' => $directoryLister->list(),
                'type_listable' => $isListable->fetchAll(),
                'list_alerts' => $alerter->getListAlert($date),
            ]
        );
    }

    #[Route(path: '/example/', name: 'dashboard_example', methods: ['GET'])]
    public function example(): Response
    {
        return $this->render(
            'dashboard/example.html.twig',
            [
                'head_title' => 'Page d\'exemple',
            ]
        );
    }

    #[Route(path: '/holiday', name: 'dashboard_holiday', methods: ['GET'])]
    public function holiday(
        Request $request,
        NewsletterWriterFetcher $newsletterWriterFetcher,
        DirectoryLister $directoryLister,
        IsListable $isListable,
        Alerter $alerter
    ): Response {
        $date = Carbon::parse($request->query->get('date', null));
        $newsletter = $newsletterWriterFetcher->get($date);

        if ($newsletter === null) {
            throw $this->createNotFoundException(sprintf('No newsletter found for date %s', $date->format('d/m/Y')));
        }

        return $this->render(
            'dashboard/holiday.html.twig',
            [
                'newspaper_date' => $newsletter->getNewspaper()->getDate(),
                'directory_image_list' => $directoryLister->list(),
                'newspaper' => $newsletter->getNewspaper(),
                'head_title' => 'Vacances !!',
                'type_listable' => $isListable->fetchAll(),
                'list_alerts' => $alerter->getListAlert($date),
            ]
        );
    }
}
