<?php

declare(strict_types=1);

namespace Partitura\Dto;

use Closure;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class RouteDataDto
 * @package Partitura\Dto
 */
class RouteDataDto
{
    #[Serializer\Type('string')]
    #[Serializer\SerializedName('name')]   
    protected ?string $name = null;

    #[Serializer\Type('string')]
    #[Serializer\SerializedName('view')]    
    protected ?string $view = null;

    #[Serializer\Type('string')]
    #[Serializer\SerializedName('csrf_token_id')]    
    protected ?string $csrfTokenId = null;

    protected ?Closure $fillerCallback = null;

    /**
     * @return string
     */
    public function getName() : string
    {
        return (string)$this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name) : static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getView() : string
    {
        return (string)$this->view;
    }

    /**
     * @param string $view
     *
     * @return $this
     */
    public function setView(string $view) : static
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @return string
     */
    public function getCsrfTokenId() : string
    {
        return (string)$this->csrfTokenId;
    }

    /**
     * @param string $csrfTokenId
     *
     * @return $this
     */
    public function setCsrfTokenId(string $csrfTokenId) : static
    {
        $this->csrfTokenId = $csrfTokenId;

        return $this;
    }

    /**
     * @return null|Closure
     */
    public function getFillerCallback() : ?Closure
    {
        return $this->fillerCallback;
    }

    /**
     * @param Closure $fillerCallback
     *
     * @return $this
     */
    public function setFillerCallback(Closure $fillerCallback) : static
    {
        $this->fillerCallback = $fillerCallback;

        return $this;
    }
}
