<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\NewsHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestMailController extends AbstractController
{
    /**
     * @Route("/test/mail/show", name="test_mail_show", methods={"GET"})
     */
    public function show(
        NewsHandler $newsHandler
    ): Response
    {
        return $this->render(
            'email/newsletter.html.twig', [
                'newspaper' => $newsHandler
            ],
        );
    }
}
