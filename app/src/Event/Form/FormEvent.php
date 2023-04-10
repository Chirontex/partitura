<?php

declare(strict_types=1);

namespace Partitura\Event\Form;

use Partitura\Dto\Form\AbstractFormRequestDto;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class FormEvent
 */
abstract class FormEvent extends Event
{
    protected ?AbstractFormRequestDto $requestDto = null;

    public function getRequestDto(): ?AbstractFormRequestDto
    {
        return $this->requestDto;
    }

    /**
     *
     * @return $this
     */
    public function setRequestDto(AbstractFormRequestDto $requestDto): static
    {
        $this->requestDto = $requestDto;

        return $this;
    }
}
