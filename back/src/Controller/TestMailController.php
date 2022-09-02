<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\NewsletterManager\Creater;
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
        Request $request,
        Manager $manager
    ): Response {
        return new Response(
            $manager->get(
                Carbon::parse($request->query->get('date', null))
            )
        );
    }

    /**
     * @Route("/test/mail/all", name="all_mail_show", methods={"GET"})
     */
    public function all(Creater $creater): Response
    {
        $creater->createAllContent();

        return new Response($creater->getHtml(true));
    }

    /**
     * @Route("/test/mail/one/{blockType}", name="test_mail_one", methods={"GET"})
     */
    public function one(
        Creater $creater,
        string $blockType
    ): Response {
        $creater->createOneContent($blockType);

        return new Response($creater->getHtml());
    }
}
