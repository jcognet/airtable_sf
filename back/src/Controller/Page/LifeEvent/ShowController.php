<?php
declare(strict_types=1);

namespace App\Controller\Page\LifeEvent;

use App\Service\Repository\LifeEvent\LifeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[Route(path: '/life_event/', name: 'life_event_show', methods: ['GET'])]
    public function show(LifeRepository $repository): Response
    {
        return $this->render(
            'life_event/show.html.twig',
            [
                'head_title' => 'Evénements importants',
                'list_event' => $repository->get(),
            ]
        );
    }
}
