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
        return new Exif([]);
    }

    // todo
    public function getResolution(string $path): Resolution
    {
        return new Resolution(0,0);
    }
}
