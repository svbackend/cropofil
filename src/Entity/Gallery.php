<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass=GalleryRepository::class)
 */
class Gallery
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    public UuidInterface $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    public string $shortcut;

    /** @ORM\Column(type="datetime") */
    public \DateTimeInterface $createdAt;

    public function __construct(string $shortcut)
    {
        $this->shortcut = $shortcut;
        $this->createdAt = new \DateTimeImmutable();
    }
}
