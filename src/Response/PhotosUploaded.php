<?php


namespace App\Response;


use App\Data\PhotoUpload;

class PhotosUploaded
{
    public array $photos;

    public function __construct(PhotoUpload ...$uploads)
    {
        $this->photos = [];
        foreach ($uploads as $upload) {
            $this->photos[] = [
                'id'
            ];
        }
    }
}
