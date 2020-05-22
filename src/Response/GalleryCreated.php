<?php


namespace App\Response;


use App\Entity\Gallery;
use Ramsey\Uuid\UuidInterface;

class GalleryCreated
{
    public UuidInterface $id;
    public string $shortcut;

    public function __construct(Gallery $gallery)
    {
        $this->id = $gallery->id;
        $this->shortcut = $gallery->shortcut;
    }
}
