<?php
declare(strict_types=1);

namespace Partitura\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait HasNameTrait
 * @package Partitura\Entity\Trait
 */
trait HasNameTrait
{
    /**
     * @ORM\Column(
     *     type="string",
     *     name="NAME",
     *     length=180
     * )
     */
    protected ?string $name = null;

    /**
     * @return string
     */
    public function getName() : string
    {
        return (string)$this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name) : static
    {
        $this->name = $name;

        return $this;
    }
}
