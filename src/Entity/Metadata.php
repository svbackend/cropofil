<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Metadata
{
    /**
     * @ORM\Embedded()
     */
    public Exif $exif;

    /**
     * @ORM\Embedded()
     */
    public Resolution $resolution;

    public function __construct(Exif $exif, Resolution $resolution)
    {
        $this->exif = $exif;
        $this->resolution = $resolution;
    }
}
