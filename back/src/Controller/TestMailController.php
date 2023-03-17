<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\NewsletterManager\Creator;
use App\Service\NewsletterManager\Manager;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestMailController extends AbstractController
{
    #[Route(path: '/test/mail/show', name: 'test_mail_show', methods: ['GET'])]
    public function show(
        Request $request,
        Manager $manager
    ): Response {
        $newsletter = $manager->get(
            Carbon::parse($request->query->get('date', null))
        );

        return new Response(
            $newsletter->getNewsletterHtml()
        );
    }

    #[Route(path: '/test/mail/all', name: 'all_mail_show', methods: ['GET'])]
    public function all(Creator $creator): Response
    {
        $creator->createAllContent();

        return new Response($creator->getHtml(true));
    }

    #[Route(path: '/test/mail/one/{blockType}', name: 'test_mail_one', methods: ['GET'])]
    public function one(
        Creator $creator,
        string $blockType
    ): Response {
        $creator->createOneContent($blockType);

        return new Response($creator->getHtml());
    }
}
