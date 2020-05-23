<?php


namespace App\Service;

use App\Exception\GalleryNotFound;
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

        return array_map([$this, 'mapPhoto'], $photos);
    }

    private function mapPhoto(array $photo): array
    {
        $photo['filename'] = sprintf('%s/%s', '', $photo['filename']);
        try {
            $photo['exif'] = json_decode($photo['exif'], true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $photo['exif'] = [];
        }

        return $photo;
    }
}
