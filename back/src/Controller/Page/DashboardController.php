<?php
declare(strict_types=1);

namespace App\Controller\Page;

use App\Service\Archive\DataInputOuputHandler;
use App\Service\Page\MainImageFetcher;
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
        DataInputOuputHandler $dataInputOuputHandler,
        MainImageFetcher $mainImageFetcher,
        PassportRepository $passportRepository
    ): Response {
        $date = Carbon::parse($request->query->get('date', null));
        $newsletter = $dataInputOuputHandler->get($date);

        if ($newsletter === null) {
            throw $this->createNotFoundException(sprintf('No newsletter found for date %s', $date->format('m/d/Y')));
        }

        return $this->render(
            'dashboard/show.html.twig',
            [
                'main_image' => $mainImageFetcher->fetch($newsletter->getNewspaper()),
                'newspaper_date' => $newsletter->getNewspaper()->getDate(),
                'passport_url' => $passportRepository->getUrl(),
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
}
