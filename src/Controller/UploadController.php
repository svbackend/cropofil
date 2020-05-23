<?php

namespace App\Controller;

use App\Entity\Gallery;
use App\Repository\PhotoRepository;
use App\Response\GalleryCreated;
use App\Response\PhotoUploaded;
use App\Service\GalleryFetcher;
use App\Service\PhotoUploader;
use App\Service\ShortcutGenerator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends BaseController
{
    /**
     * @Route("/", name="app_home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/g/{shortcut}", name="app_gallery_view", methods={"GET"})
     */
    public function viewGallery(string $shortcut, GalleryFetcher $galleryFetcher): Response
    {
        $photos = $galleryFetcher->fetchPhotosByShortcut($shortcut);

        return $this->render('gallery/view.html.twig', [
            'photos' => $photos,
        ]);
    }

    /**
     * @Route("/new", name="app_gallery_new", methods={"POST"})
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
     * @Route("/g/{id}", name="app_photo_new", methods={"POST"})
     */
    public function uploadPhoto(Request $request, Gallery $gallery, PhotoUploader $uploader): JsonResponse
    {
        /** @var UploadedFile[] $photos */
        $photos = $request->files->get('photos');

        $result = [
            'code' => 0,
            'photos' => [],
        ];

        foreach ($photos as $photo) {
            if ($photo->isValid()) {
                $photoUpload = $uploader->upload($photo, $gallery);
                $result['photos'][] = PhotoUploaded::createFromUpload($photoUpload);
            } else {
                $result['photos'][] = PhotoUploaded::invalid($photo);
            }
        }

        return $this->json($result);
    }

    /**
     *
     * @Route("/", name="app_gallery_upload", methods={"POST"})
     */
    public function uploadGallery(Request $request, PhotoUploader $uploader, ShortcutGenerator $shortcutGenerator): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();

        $gallery = new Gallery($shortcutGenerator->generateShortcut());
        $em->persist($gallery);
        $em->flush();

        /** @var UploadedFile[] $photos */
        $photos = $request->files->get('photos', []);

        $result = [
            'code' => 0,
            'photos' => [],
        ];

        foreach ($photos as $photo) {
            if ($photo->isValid()) {
                $photoUpload = $uploader->upload($photo, $gallery);
                $result['photos'][] = PhotoUploaded::createFromUpload($photoUpload);
            } else {
                $result['photos'][] = PhotoUploaded::invalid($photo);
            }
        }

        return $this->redirectToRoute('app_gallery_view', ['shortcut' => $gallery->shortcut]);
    }
}
