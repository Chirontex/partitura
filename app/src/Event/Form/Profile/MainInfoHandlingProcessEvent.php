<?php
declare(strict_types=1);

namespace Partitura\Event\Form\Profile;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Dto\Form\AbstractFormRequestDto;
use Partitura\Event\Form\FormEvent;
use Partitura\Exception\NotImplementedException;

/**
 * Class MainInfoHandlingProcessEvent
 * @package Partitura\Event\Form\Profile
 */
class MainInfoHandlingProcessEvent extends FormEvent
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
     * @param array<string, string> $fields
     *
     * @return $this
     */
    public function setFieldsToResponseParameters(array $fields) : static
    {
        $this->responseParameters->set("fields", $fields);

        return $this;
    }

    /**
     * {@inheritDoc}
     * 
     * @throws NotImplementedException
     */
    public function setRequestDto(AbstractFormRequestDto $requestDto) : static
    {
        throw new NotImplementedException("Cannot set request DTO in process event object.");
    }
}
