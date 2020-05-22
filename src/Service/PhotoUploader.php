<?php


namespace App\Service;


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

    public function upload(UploadedFile $photo, Gallery $gallery)
    {
        $result = $this->fs->write('hello.txt', 'Hello World!');

        $stream = fopen($photo->getRealPath(), 'rb+');
        $this->fs->writeStream('uploads/'.$file->getClientOriginalName(), $stream, [
            'visibility' => AdapterInterface::VISIBILITY_PUBLIC
        ]);
        fclose($stream);
    }
}
