<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Exif
{
    /** @ORM\Column(type="json") */
    public array $exif;

    public function __construct(array $exif)
    {
        $this->exif = $exif;
    }
}
