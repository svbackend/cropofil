<?php


namespace App\Service;


use App\Data\PhotoUpload;
use App\Entity\Filename;
use App\Entity\Gallery;
use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoUploader
{
    private FilesystemInterface $fs;
    private EntityManagerInterface $em;
    private MetadataReader $metadataReader;

    public function __construct(FilesystemInterface $awsStorage, EntityManagerInterface $em, MetadataReader $metadataReader)
    {
        $this->fs = $awsStorage;
        $this->em = $em;
        $this->metadataReader = $metadataReader;
    }

    public function upload(UploadedFile $file, Gallery $gallery): PhotoUpload
    {
        $originalExtension = $file->getClientOriginalExtension();
        $clientFilename = $file->getClientOriginalName() ?: sprintf('%s.%s', 'photo', $originalExtension);
        $filename = sprintf('%s.%s', uniqid('', true), $originalExtension);
        $path = sprintf('%s/%s', $gallery->shortcut, $filename);

        $entity = new Photo(
            $gallery,
            new Filename($clientFilename),
            new Filename($filename),
            $this->metadataReader->readFromUploadedFile($file)
        );
        $this->em->persist($entity);

        // todo optimization, we can open stream only once for metadata + transfer to aws
        $stream = fopen($file->getRealPath(), 'rb+');
        $this->fs->writeStream($path, $stream, [
            'visibility' => AdapterInterface::VISIBILITY_PUBLIC
        ]);
        fclose($stream);
        $this->em->flush();

        return PhotoUpload::success($entity);
    }
}
