<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\NewsletterManager\Manager;
use App\Service\NewsletterManager\NewspaperCreator;
use App\Service\NewsletterManager\NewspaperRenderer;
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
            Carbon::parse($request->query->get('date', null)),
            filter_var(
                $request->query->get('force_twig', false),
                FILTER_VALIDATE_BOOLEAN
            )
        );

        return new Response(
            $newsletter->getNewsletterHtml()
        );
    }

    #[Route(path: '/test/mail/all', name: 'all_mail_show', methods: ['GET'])]
    public function all(
        NewspaperCreator $creator,
        NewspaperRenderer $renderer
    ): Response {
        return new Response(
            $renderer->renderHtml(
                $creator->createAllContent()
            )
        );
    }

    #[Route(path: '/test/mail/one/{blockType}', name: 'test_mail_one', methods: ['GET'])]
    public function one(
        NewspaperCreator $creator,
        NewspaperRenderer $renderer,
        string $blockType,
    ): Response {
        return new Response(
            $renderer->renderHtml(
                $creator->createOneContent($blockType)
            )
        );
    }
}
