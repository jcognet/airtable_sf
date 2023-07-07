<?php
declare(strict_types=1);

namespace App\Controller;

use App\Enum\Picture\Format;
use App\Service\Picture\EncoderDecoder;
use App\Service\Picture\ImageInPathLister;
use App\Service\Picture\PictureFactory;
use App\Service\Picture\RandomDirectorySelector;
use App\Service\Picture\ThumbnailerGetter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route(path: '/img/list/', name: 'img_list', methods: ['GET'])]
    public function list(
        Request $request,
        ImageInPathLister $imageInPathLister
    ): Response {
        if (!$request->query->has('directory')) {
            throw $this->createNotFoundException();
        }

        $directoryPath = $request->query->get('directory');

        try {
            $directory = $imageInPathLister->getPicturesFromDirectory($directoryPath);
        } catch (DirectoryNotFoundException) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'img/list.html.twig',
            [
                'directory' => $directory,
                'directory_current' => $directoryPath,
            ],
        );
    }

    #[Route(path: '/img/random/', name: 'img_random', methods: ['GET'])]
    public function random(
        ImageInPathLister $imageInPathLister,
        RandomDirectorySelector $randomDirectorySelector
    ): Response {
        $directoryPath = $randomDirectorySelector->getRandomDirectory();

        if ($directoryPath === null) {
            return $this->render(
                'img/list.html.twig'
            );
        }

        try {
            $directory = $imageInPathLister->getPicturesFromDirectory($directoryPath);
        } catch (DirectoryNotFoundException) {
            throw $this->createNotFoundException(sprintf('Unknown directory: %s', $directoryPath));
        }

        return $this->render(
            'img/list.html.twig',
            [
                'directory' => $directory,
            ],
        );
    }

    #[Route(path: '/img/thumbnail/{pathImage}', name: 'img_thumbnail', methods: ['GET'])]
    public function thumbnail(
        string $pathImage,
        EncoderDecoder $encoderDecoder,
        ThumbnailerGetter $thumbnailerGetter,
        Request $request
    ): Response {
        $format = Format::make($request->query->get('format', null));

        return new BinaryFileResponse(
            $thumbnailerGetter->get(
                $encoderDecoder->decode($pathImage),
                $format
            ),
            headers: ['Content-Type' => 'image/jpeg']
        );
    }

    #[Route(path: '/img/normal/{pathImage}', name: 'img_normal', methods: ['GET'])]
    public function normal(
        string $pathImage,
        EncoderDecoder $encoderDecoder,
        PictureFactory $imageFactory
    ): Response {
        return new BinaryFileResponse(
            $imageFactory->get($encoderDecoder->decode($pathImage))->getPath(),
            headers: ['Content-Type' => 'image/jpeg']
        );
    }
}
