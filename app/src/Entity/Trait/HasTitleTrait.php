<?php
declare(strict_types=1);

namespace Partitura\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait HasTitleTrait
 * @package Partitura\Entity\Trait
 */
trait HasTitleTrait
{
    /**
     * @ORM\Column(
     *     type="string",
     *     name="TITLE",
     *     length=180
     * )
     */
    protected ?string $title = null;

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return (string)$this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title) : static
    {
        $this->title = $title;

        return $this;
    }
}
