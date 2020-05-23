<?php


namespace App\Response;


use App\Data\PhotoUpload;
use App\Utils\StatusCode;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoUploaded
{
    public static function createFromUpload(PhotoUpload $photoUpload): array
    {
        if ($photoUpload->isSuccess) {
            return ['code' => StatusCode::PHOTO_UPLOAD_SUCCESS];
        }

        return [
            'code' => StatusCode::PHOTO_UPLOAD_ERROR,
            'message' => $photoUpload->throwable->getMessage()
        ];
    }

    public static function invalid(UploadedFile $file): array
    {
        return [
            'code' => StatusCode::PHOTO_UPLOAD_INVALID,
            'message' => $file->getErrorMessage()
        ];
    }
}
