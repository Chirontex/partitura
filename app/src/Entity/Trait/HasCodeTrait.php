<?php

declare(strict_types=1);

namespace Partitura\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait HasCodeTrait
 */
trait HasCodeTrait
{
    #[ORM\Column(
        type: 'string',
        name: 'CODE',
        length: 180,
        unique: true
    )]
    protected ?string $code = null;

    public function getCode(): string
    {
        return (string)$this->code;
    }

    /**
     *
     * @return $this
     */
    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }
}
