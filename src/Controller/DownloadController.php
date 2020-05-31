<?php

namespace App\Controller;

use App\Service\GalleryFetcher;
use App\Utils\PhotoUrl;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadController extends BaseController
{
    /**
     * @Route("/g/{shortcut}/download", name="app_gallery_download_all", methods={"GET"})
     */
    public function downloadAll(string $shortcut, GalleryFetcher $galleryFetcher, FilesystemInterface $awsStorage): Response
    {
        $archiveFilename = 'cropofil_photos.zip';
        $archivePath = sprintf('%s/%s', $shortcut, $archiveFilename);

        if ($awsStorage->has($archivePath)) {
            return $this->redirect(PhotoUrl::getUrl($shortcut, $archiveFilename));
        }

        $photos = $galleryFetcher->fetchPhotosByShortcut($shortcut);

        $file = tempnam(sys_get_temp_dir(), "{$shortcut}.zip");

        $zip = new \ZipArchive();
        $zip->open($file, \ZipArchive::CREATE);

        foreach ($photos as $photo) {
            $zip->addFromString(
                $photo['client_filename'],
                $awsStorage->read(sprintf('%s/%s', $shortcut, $photo['filename']))
            );
        }

        $zip->close();

        $stream = fopen($file, 'rb+');
        $awsStorage->writeStream($archivePath, $stream, [
            'visibility' => AdapterInterface::VISIBILITY_PUBLIC
        ]);
        fclose($stream);

        return $this->redirect(PhotoUrl::getUrl($shortcut, $archiveFilename));
    }
}
