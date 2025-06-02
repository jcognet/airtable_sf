<?php
declare(strict_types=1);

namespace App\Controller\Page\CiteDesBebes;

use App\Service\CiteDesBebes\Alerter;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PingController extends AbstractController
{
    #[Route(path: '/cite_bebe/ping', name: 'cite_bebe_ping', methods: ['GET'])]
    public function ping(
        Alerter $alerter,
    ): JsonResponse {
        return new JsonResponse($alerter->alert());
    }
}
