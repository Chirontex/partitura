<?php
declare(strict_types=1);

namespace Partitura\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait HasContentTrait
 * @package Partitura\Entity\Trait
 */
trait HasContentTrait
{
    /**
     * @ORM\Column(type="text", name="CONTENT")
     */
    protected string $content;

    /**
     * @return string
     */
    public function getContent() : string
    {
        return (string)$this->content;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content) : static
    {
        $this->content = $content;

        return $this;
    }
}
