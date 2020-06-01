<?php

namespace App\Controller;

use App\Service\GalleryFetcher;
use App\Utils\PhotoUrl;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThumbnailController extends BaseController
{
    /**
     * @Route("/g/{shortcut}/{id}", name="app_gallery_photo_thumbnail", methods={"GET"})
     */
    public function thumbnail(string $shortcut, int $id, GalleryFetcher $galleryFetcher): Response
    {
        $photo = $galleryFetcher->fetchPhoto($shortcut, $id);

        $image = new ImageResize('image.jpg');
        $image->scale(50);
        $image->save('image2.jpg');
    }
}
