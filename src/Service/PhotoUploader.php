<?php


namespace App\Service;


use App\Data\PhotoUpload;
use App\Entity\Gallery;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoUploader
{
    private FilesystemInterface $fs;

    public function __construct(FilesystemInterface $awsStorage)
    {
        $this->fs = $awsStorage;
    }

    public function upload(UploadedFile $photo, Gallery $gallery): PhotoUpload
    {
        $path = sprintf('%s/%s.%s', $gallery->id, uniqid('', true), $photo->getClientOriginalExtension());

        $stream = fopen($photo->getRealPath(), 'rb+');
        $this->fs->writeStream($path, $stream, [
            'visibility' => AdapterInterface::VISIBILITY_PUBLIC
        ]);
        fclose($stream);

        return PhotoUpload::success();
    }
}
