<?php
declare(strict_types=1);

namespace App\Controller\Page;

use App\Service\Archive\NewsletterWriterFetcher;
use App\Service\Archive\PreviousNewsletterFetcher;
use App\Service\Export\Fetcher;
use App\Service\Holiday\IsHolidayDeterminator;
use App\Service\Picture\DirectoryLister;
use App\Service\Repository\Official\PassportRepository;
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
        PassportRepository $passportRepository,
        PreviousNewsletterFetcher $previousNewsletterFetcher,
        Fetcher $exporterFetcher,
        DirectoryLister $directoryLister,
        IsHolidayDeterminator $isHolidayDeterminator
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
                'passport_url' => $passportRepository->getUrl(),
                'newspaper' => $newsletter->getNewspaper(),
                'previous_newspapers' => $previousNewsletterFetcher->fetchNewspapers($date),
                'kpi' => $exporterFetcher->fetch($date),
                'directory_image_list' => $directoryLister->list(),
            ]
        );
    }

    #[Route(path: '/example/', name: 'dashboard_example', methods: ['GET'])]
    public function example(): Response
    {
        return $this->render(
            'dashboard/example.html.twig'
        );
    }

    #[Route(path: '/holiday', name: 'dashboard_holiday', methods: ['GET'])]
    public function holiday(
        Request $request,
        NewsletterWriterFetcher $newsletterWriterFetcher,
        DirectoryLister $directoryLister,
    ): Response {
        $date = Carbon::parse($request->query->get('date', null));
        $newsletter = $newsletterWriterFetcher->get($date);

        return $this->render(
            'dashboard/holiday.html.twig',
            [
                'newspaper_date' => $newsletter->getNewspaper()->getDate(),
                'directory_image_list' => $directoryLister->list(),
                'newspaper' => $newsletter->getNewspaper(),
            ]
        );
    }
}
