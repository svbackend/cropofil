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
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    public ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Gallery::class)
     */
    public Gallery $gallery;

    /**
     * @ORM\Embedded(class=Filename::class, columnPrefix="client_")
     */
    public Filename $clientFilename;

    /**
     * @ORM\Embedded(class=Filename::class, columnPrefix=false)
     */
    public Filename $filename;

    /**
     * @ORM\Embedded(class=Metadata::class, columnPrefix=false)
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
