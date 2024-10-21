<?php
declare(strict_types=1);

namespace App\Controller;

use App\Enum\Picture\Format;
use App\Service\Picture\DownloadableInformationFactory;
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
    #[\Symfony\Component\Routing\Attribute\Route(path: '/img/list/', name: 'img_list', methods: ['GET'])]
    public function list(
        Request $request,
        ImageInPathLister $imageInPathLister,
        DownloadableInformationFactory $downloadableInformationFactory,
        EncoderDecoder $encoderDecoder
    ): Response {
        if (!$request->query->has('directory')) {
            throw $this->createNotFoundException();
        }

        $directoryPath = $encoderDecoder->decode(
            $request->query->get('directory')
        );

        try {
            $directory = $imageInPathLister->getPicturesFromDirectory($directoryPath);
        } catch (\App\Exception\Picture\DirectoryNotFoundException|DirectoryNotFoundException$e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->render(
            'img/list.html.twig',
            [
                'directory' => $directory,
                'downloadable_info' => $downloadableInformationFactory->get($directory),
                'head_title' => sprintf('Images de %s', $directoryPath),
            ],
        );
    }

    #[\Symfony\Component\Routing\Attribute\Route(path: '/img/random/', name: 'img_random', methods: ['GET'])]
    public function random(
        ImageInPathLister $imageInPathLister,
        RandomDirectorySelector $randomDirectorySelector,
        DownloadableInformationFactory $downloadableInformationFactory
    ): Response {
        $directoryPath = $randomDirectorySelector->getRandomDirectory();

        if ($directoryPath === null) {
            return $this->render(
                'img/list.html.twig'
            );
        }

        try {
            $directory = $imageInPathLister->getPicturesFromDirectory($directoryPath);
        } catch (DirectoryNotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->render(
            'img/list.html.twig',
            [
                'directory' => $directory,
                'downloadable_info' => $downloadableInformationFactory->get($directory),
                'head_title' => sprintf('Images de %s', $directory->getPath()),
            ],
        );
    }

    #[\Symfony\Component\Routing\Attribute\Route(path: '/img/thumbnail/{pathImage}.jpg', name: 'img_thumbnail', methods: ['GET'])]
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

    #[\Symfony\Component\Routing\Attribute\Route(path: '/img/normal/{pathImage}.jpg', name: 'img_normal', methods: ['GET'])]
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
