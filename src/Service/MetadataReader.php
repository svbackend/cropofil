<?php


namespace App\Service;


use App\Entity\Exif;
use App\Entity\Metadata;
use App\Entity\Resolution;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MetadataReader
{
    public function readFromUploadedFile(UploadedFile $file): Metadata
    {
        $path = $file->getRealPath();

        $exif = $this->getExif($path);
        $res = $this->getResolution($path);
        return new Metadata($exif, $res);
    }

    // todo
    public function getExif(string $path): Exif
    {
        try {
            $exif = exif_read_data($path);
        } catch (\ErrorException $fileNotSupported) {
            $exif = [];
        }

        try {
            // todo needed to catch error before doctrine. But in general should be fixed in more correct way
            json_encode($exif, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $exif = [
                'exception' => $e->getMessage(),
                'data' => var_export($exif, true)
            ];
        }

        return new Exif($exif);
    }

    // todo
    public function getResolution(string $path): Resolution
    {
        [$w, $h] = getimagesize($path);
        return new Resolution($w, $h);
    }
}
