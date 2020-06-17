<?php

namespace App\Controller\Api;

use App\Controller\BaseController;
use App\Service\GalleryFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_", methods={"GET"})
 */
class GalleryController extends BaseController
{
    /**
     * @Route("/g/{shortcut}", name="gallery_view", methods={"GET"})
     */
    public function viewGallery(string $shortcut, GalleryFetcher $galleryFetcher): Response
    {
        $photos = $galleryFetcher->fetchPhotosByShortcut($shortcut);

        return $this->json([
            'photos' => $photos,
        ]);
    }
}
