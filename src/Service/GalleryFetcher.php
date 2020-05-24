<?php


namespace App\Service;

use App\Entity\Photo;
use App\Exception\GalleryNotFound;
use App\Utils\PhotoUrl;
use Doctrine\DBAL\Connection;

class GalleryFetcher
{
    private Connection $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function fetchPhotosByShortcut(string $shortcut): array
    {
        $galleryId = $this->conn->fetchColumn('SELECT id FROM gallery WHERE shortcut = :shortcut', [
            ':shortcut' => $shortcut
        ]);

        if ($galleryId === false) {
            throw new GalleryNotFound();
        }

        $photos = $this->conn->fetchAll('
            SELECT id, client_filename, filename, exif, w, h 
            FROM photo 
            WHERE gallery_id = :gallery_id
        ', [
            ':gallery_id' => $galleryId
        ]);

        return array_map(fn (array $photo) => $this->mapPhoto($shortcut, $photo), $photos);
    }

    private function mapPhoto(string $shortcut, array $photo): array
    {
        $photo['url'] = PhotoUrl::getUrl($shortcut, $photo['filename']);
        try {
            $photo['exif'] = json_decode($photo['exif'], true, 512, JSON_THROW_ON_ERROR);

            /** @see Photo::isHorizontal() */
            $orientation = $photo['exif']['Orientation'] ?? '1';
            if (in_array($orientation, ['6', '8'], true)) {
                [$photo['h'], $photo['w']] = [$photo['w'], $photo['h']];
            }

        } catch (\JsonException $e) {
            // todo log
            $photo['exif'] = [];
        }

        return $photo;
    }
}
