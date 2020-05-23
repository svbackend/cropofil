<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Metadata
{
    /**
     * @ORM\Embedded(class=Exif::class, columnPrefix=false)
     */
    public Exif $exif;

    /**
     * @ORM\Embedded(class=Resolution::class, columnPrefix=false)
     */
    public Resolution $resolution;

    public function __construct(Exif $exif, Resolution $resolution)
    {
        $this->exif = $exif;
        $this->resolution = $resolution;
    }
}
