<?php

declare(strict_types=1);

namespace Partitura\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait HasIdTrait.
 */
trait HasIdTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: 'bigint', name: 'ID', options: ["unsigned" => true])]
    protected int $id = 0;

    public function getId(): int
    {
        return (int)$this->id;
    }
}
