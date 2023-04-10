<?php

declare(strict_types=1);

namespace Partitura\Event\Form;

use Partitura\Dto\Form\AbstractFormRequestDto;
use Partitura\Enum\CsrfTokenValidationResultEnum;
use Partitura\Exception\NotImplementedException;

/**
 * class CsrfTokenValidationEvent
 */
class CsrfTokenValidationEvent extends FormEvent
{
    protected ?CsrfTokenValidationResultEnum $csrfTokenValidationResult = null;

    public function __construct(AbstractFormRequestDto $requestDto)
    {
        $this->requestDto = $requestDto;
    }

    public function getCsrfTokenValidationResult(): ?CsrfTokenValidationResultEnum
    {
        return $this->csrfTokenValidationResult;
    }

    /**
     *
     * @return $this
     */
    public function setCsrfTokenValidationResult(CsrfTokenValidationResultEnum $csrfTokenValidationResult): static
    {
        $this->csrfTokenValidationResult = $csrfTokenValidationResult;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @throws NotImplementedException
     */
    public function setRequestDto(AbstractFormRequestDto $requestDto): static
    {
        throw new NotImplementedException("Cannot set request DTO in handling event object.");
    }
}
