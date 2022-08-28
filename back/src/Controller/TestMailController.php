<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\NewsletterManager\Manager;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestMailController extends AbstractController
{
    /**
     * @Route("/test/mail/show", name="test_mail_show", methods={"GET"})
     */
    public function show(
        Manager $newsHandler,
        Request $request
    ): Response {
        $date = Carbon::parse($request->query->get('date', null));
        $newspaper = $newsHandler->createContent($date);

        return $this->render(
            'email/newsletter.html.twig',
            [
                'newspaper' => $newspaper,
                'date' => $newspaper->getDate(),
            ],
        );
    }

    /**
     * @Route("/test/mail/all", name="all_mail_show", methods={"GET"})
     */
    public function all(Manager $newsHandler): Response
    {
        $newspaper = $newsHandler->createAllContent();

        return $this->render(
            'email/newsletter.html.twig',
            [
                'newspaper' => $newspaper,
                'date' => $newspaper->getDate(),
                'show_block' => true,
            ],
        );
    }

    /**
     * @Route("/test/mail/one/{blockType}", name="test_mail_one", methods={"GET"})
     */
    public function one(
        Manager $newsHandler,
        string $blockType
    ): Response {
        $newspaper = $newsHandler->createOneContent($blockType);

        return $this->render(
            'email/newsletter.html.twig',
            [
                'newspaper' => $newspaper,
                'date' => $newspaper->getDate(),
            ],
        );
    }
}
