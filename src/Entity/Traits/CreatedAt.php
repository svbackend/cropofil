<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait CreatedAt
{
    /** @ORM\Column(type="datetime") */
    public \DateTimeInterface $createdAt;
}
