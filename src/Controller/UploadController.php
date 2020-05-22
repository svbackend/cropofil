<?php

namespace App\Controller;

use App\Entity\Gallery;
use App\Response\GalleryCreated;
use App\Service\PhotoUploader;
use App\Service\ShortcutGenerator;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends BaseController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/new", name="app_gallery_new", methods={POST})
     */
    public function createGallery(ShortcutGenerator $shortcutGenerator): JsonResponse
    {
        $gallery = new Gallery($shortcutGenerator->generateShortcut());

        $em = $this->getDoctrine()->getManager();
        $em->persist($gallery);
        $em->flush();

        return $this->json(new GalleryCreated($gallery));
    }

    /**
     * @Route("/g/{id}", name="app_photo_new")
     */
    public function uploadPhoto(Request $request, Gallery $gallery, PhotoUploader $uploader): JsonResponse
    {


        /** @var UploadedFile[] $file */
        $photos = $request->files->get('photos');

        foreach ($photos as $photo) {
            if ($photo->isValid()) {
                $uploader->upload($photo, $gallery);
            }
        }

    }
}
