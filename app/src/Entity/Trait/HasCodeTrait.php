<?php
declare(strict_types=1);

namespace Partitura\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait HasCodeTrait
 * @package Partitura\Entity\Trait
 */
trait HasCodeTrait
{
    /**
     * @var string
     * 
     * @ORM\Column(
     *     type="string",
     *     name="CODE",
     *     length=180,
     *     unique=true
     * )
     */
    protected $code;

    /**
     * @return string
     */
    public function getCode() : string
    {
        return (string)$this->code;
    }

    /**
     * @param string $code
     *
     * @return $this
     */
    public function setCode(string $code) : static
    {
        $this->code = $code;

        return $this;
    }
}
