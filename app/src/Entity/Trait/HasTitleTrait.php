<?php

declare(strict_types=1);

namespace Partitura\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait HasTitleTrait
 */
trait HasTitleTrait
{
    #[ORM\Column(
        type: 'string',
        name: 'TITLE',
        length: 180
    )]
    protected ?string $title = null;

    public function getTitle(): string
    {
        return (string)$this->title;
    }

    /**
     *
     * @return $this
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }
}
