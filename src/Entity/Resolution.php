<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Resolution
{
    /** @ORM\Column(type="integer") */
    public int $w;

    /** @ORM\Column(type="integer") */
    public int $h;

    public function __construct(int $w, int $h)
    {
        $this->w = $w;
        $this->h = $h;
    }
}
