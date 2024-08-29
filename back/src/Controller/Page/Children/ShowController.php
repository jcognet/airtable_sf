<?php
declare(strict_types=1);

namespace App\Controller\Page\Children;

use App\Service\Repository\Children\ChildrenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[Route(path: '/children/', name: 'children_show', methods: ['GET'])]
    public function show(ChildrenRepository $repository): Response
    {
        return $this->render(
            'children/show.html.twig',
            [
                'head_title' => 'Enfants',
                'list_child' => $repository->get(),
            ]
        );
    }
}
