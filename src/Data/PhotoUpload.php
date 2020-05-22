<?php


namespace App\Data;


use App\Entity\Photo;

class PhotoUpload
{
    public bool $isSuccess;
    public string $clientFilename;
    public string $path;
    public string $filename;

    public static function success(string $clientFilename, string $path, string $filename): self
    {
        $photoUpload = new self();
        $photoUpload->isSuccess = true;
        $photoUpload->clientFilename = $clientFilename;
        $photoUpload->path = $path;
        $photoUpload->filename = $filename;
    }

    public \Throwable $throwable;

    public static function error(\Throwable $throwable): self
    {
        $photoUpload = new self();
        $photoUpload->isSuccess = false;
        $photoUpload->throwable = $throwable;
        return $photoUpload;
    }

    private function __construct()
    {
    }
}
