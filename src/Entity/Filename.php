<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Filename
{
    /** @ORM\Column(type="string") */
    public string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }
}
