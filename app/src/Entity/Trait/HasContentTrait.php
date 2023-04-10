<?php

declare(strict_types=1);

namespace Partitura\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait HasContentTrait
 */
trait HasContentTrait
{
    #[ORM\Column(type: 'text', name: 'CONTENT')]
    protected ?string $content = null;

    public function getContent(): string
    {
        return (string)$this->content;
    }

    /**
     *
     * @return $this
     */
    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }
}
