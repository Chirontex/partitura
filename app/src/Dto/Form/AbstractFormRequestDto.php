<?php
declare(strict_types=1);

namespace Partitura\Dto\Form;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class AbstractFormRequestDto
 * @package Partitura\Dto\Form
 */
abstract class AbstractFormRequestDto
{
    public const CSRF_TOKEN_KEY = "_csrf_token";

    /**
     * @var string
     * 
     * @Serializer\Type("string")
     * @Serializer\SerializedName(\Partitura\Dto\Form\AbstractFormRequestDto::CSRF_TOKEN_KEY)
     */
    protected $csrfToken;

    /**
     * @return string
     */
    public function getCsrfToken() : string
    {
        return (string)$this->csrfToken;
    }

    /**
     * @param string $csrfToken
     *
     * @return $this
     */
    public function setCsrfToken(string $csrfToken) : static
    {
        $this->csrfToken = $csrfToken;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function getRouteName() : string;
}
