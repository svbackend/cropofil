<?php


namespace App\Data;


use App\Entity\Photo;

class PhotoUpload
{
    public bool $isSuccess;

    public ?Photo $photo;

    public static function success(Photo $photo): self
    {
        $photoUpload = new self();
        $photoUpload->isSuccess = true;
        $photoUpload->photo = $photo;
        return $photoUpload;
    }

    public ?\Throwable $throwable;

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
