<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAt;
use App\Entity\Traits\Id;
use App\Repository\GalleryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GalleryRepository::class)
 */
class Gallery
{
    use Id, CreatedAt;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    public string $shortcut;

    public function __construct(string $shortcut)
    {
        $this->shortcut = $shortcut;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getPathPrefix(): string
    {
        return $this->id;
    }
}
