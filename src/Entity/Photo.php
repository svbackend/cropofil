<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Gallery::class)
     */
    public Gallery $gallery;

    /**
     * @ORM\Embedded()
     */
    public Filename $clientFilename;

    /**
     * @ORM\Embedded()
     */
    public Filename $filename;

    /**
     * @ORM\Embedded()
     */
    public Metadata $metadata;

    public function __construct(Gallery  $gallery, Filename $clientFilename, Filename $filename, Metadata $metadata)
    {
        $this->gallery = $gallery;
        $this->clientFilename = $clientFilename;
        $this->filename = $filename;
        $this->metadata = $metadata;
    }
}
