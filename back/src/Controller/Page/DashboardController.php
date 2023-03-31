<?php
declare(strict_types=1);

namespace App\Controller\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route(path: '/dashboard/', name: 'dashboard_show', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render(
            'dashboard/show.html.twig'
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
