<?php
declare(strict_types=1);

namespace Partitura\Event\Form;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Dto\Form\AbstractFormRequestDto;
use Partitura\Exception\NotImplementedException;

/**
 * Class RequestDtoHandleEvent
 * @package Partitura\Event\Form
 */
abstract class RequestDtoHandleEvent extends FormEvent
{
    /** @var ArrayCollection<string, mixed> */
    protected $responseParameters;

    public function __construct(AbstractFormRequestDto $requestDto)
    {
        $this->requestDto = $requestDto;
        $this->responseParameters = new ArrayCollection();
    }

    /**
     * @return ArrayCollection<string, mixed>
     */
    public function getResponseParameters() : ArrayCollection
    {
        return $this->responseParameters;
    }

    /**
     * @param ArrayCollection<string, mixed> $responseParameters
     *
     * @return $this
     */
    public function setResponseParameters(ArrayCollection $responseParameters) : static
    {
        $this->responseParameters = $responseParameters;

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function setResponseParameter(string $key, string $value) : static
    {
        $this->responseParameters->set($key, $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     * 
     * @throws NotImplementedException
     */
    public function setRequestDto(AbstractFormRequestDto $requestDto) : static
    {
        throw new NotImplementedException("Cannot set request DTO in handling event object.");
    }
}
