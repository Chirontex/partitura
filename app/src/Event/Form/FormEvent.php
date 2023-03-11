<?php
declare(strict_types=1);

namespace Partitura\Event\Form;

use Partitura\Dto\Form\AbstractFormRequestDto;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class FormEvent
 * @package Partitura\Event\Form
 */
abstract class FormEvent extends Event
{
    protected AbstractFormRequestDto $requestDto;

    /**
     * @return null|AbstractFormRequestDto
     */
    public function getRequestDto() : ?AbstractFormRequestDto
    {
        return $this->requestDto;
    }

    /**
     * @param AbstractFormRequestDto $requestDto
     *
     * @return $this
     */
    public function setRequestDto(AbstractFormRequestDto $requestDto) : static
    {
        $this->requestDto = $requestDto;

        return $this;
    }
}
