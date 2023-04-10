<?php

declare(strict_types=1);

namespace Partitura\Event\Form;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Dto\Form\AbstractFormRequestDto;

/**
 * Class RequestDtoHandleEvent
 */
abstract class RequestDtoHandleEvent extends CsrfTokenValidationEvent
{
    protected ArrayCollection $responseParameters;

    public function __construct(AbstractFormRequestDto $requestDto)
    {
        parent::__construct($requestDto);

        $this->responseParameters = new ArrayCollection();
    }

    /**
     * @return ArrayCollection<string, mixed>
     */
    public function getResponseParameters(): ArrayCollection
    {
        return $this->responseParameters;
    }

    /**
     * @param ArrayCollection<string, mixed> $responseParameters
     *
     * @return $this
     */
    public function setResponseParameters(ArrayCollection $responseParameters): static
    {
        $this->responseParameters = $responseParameters;

        return $this;
    }

    /**
     *
     * @return $this
     */
    public function setResponseParameter(string $key, string $value): static
    {
        $this->responseParameters->set($key, $value);

        return $this;
    }
}
