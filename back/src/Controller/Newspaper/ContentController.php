<?php
declare(strict_types=1);

namespace App\Controller\Newspaper;

use App\Exception\NewsletterBlockManager\UnknownBlockTypeException;
use App\Service\Block\BlockFinder;
use App\ValueObject\NewsletterBlockManager\BlockType;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ContentController extends AbstractController
{
    #[Route(path: '/newspaper/content/one/{type}', name: 'newspapper_content_one', methods: ['GET'])]
    public function one(
        Request $request,
        BlockFinder $blockFinder,
        SerializerInterface $serializer,
        string $type
    ): JsonResponse {
        try {
            $blockType = BlockType::make($type);
        } catch (UnknownBlockTypeException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        $blocks = $blockFinder->find(
            Carbon::parse($request->query->get('date', null)),
            $blockType
        );

        if ($blocks === null) {
            return new JsonResponse(status: Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(
            $serializer->serialize(
                $blocks,
                'json'
            )
        );
    }
}
