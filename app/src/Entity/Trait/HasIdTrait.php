<?php
declare(strict_types=1);

namespace Partitura\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait HasIdTrait
 * @package Partitura\Entity\Trait
 */
trait HasIdTrait
{
    /**
     * @var int
     * 
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint", name="ID", options={"unsigned":true})
     */
    protected $id;

    /**
     * @return int
     */
    public function getId() : int
    {
        return (int)$this->id;
    }
}
