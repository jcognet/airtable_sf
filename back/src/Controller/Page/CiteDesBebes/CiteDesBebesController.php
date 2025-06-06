<?php
declare(strict_types=1);

namespace App\Controller\Page\CiteDesBebes;

use App\Service\CiteDesBebes\Alerter;
use App\Service\CiteDesBebes\Fetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CiteDesBebesController extends AbstractController
{
    #[Route(path: '/cite_bebe/ping', name: 'cite_bebe_ping', methods: ['GET'])]
    public function ping(
        Alerter $alerter,
    ): JsonResponse {
        return new JsonResponse($alerter->alert());
    }

    #[Route(path: '/cite_bebe/show', name: 'cite_bebe_show', methods: ['GET'])]
    public function show(
        Fetcher $fetcher,
    ): Response {
        $list = $fetcher->list();

        return $this->render(
            'cite_bebe/show.html.twig',
            [
                'updated_at' => $list['metadata']['updated'] ?? null,
                'sales' => $list['data']['sales'] ?? null,
                'head_title' => 'Cite des bébés',
            ]
        );
    }
}
