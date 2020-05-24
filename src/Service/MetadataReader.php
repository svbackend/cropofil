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
            json_encode($exif, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $exif = [
                '__exception' => $e->getMessage(),
                ...$this->fixEncoding($exif)
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

    private function fixEncoding(array $input): array
    {
        $result = [];

        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $result[$key] = $this->fixEncoding($value);
            } else {
                $result[$key] = utf8_encode($value);
            }
        }

        return $result;
    }
}
