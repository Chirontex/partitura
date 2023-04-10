<?php

declare(strict_types=1);

namespace Partitura\Dto\Form;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class AbstractFormRequestDto
 */
abstract class AbstractFormRequestDto
{
    public const CSRF_TOKEN_KEY = "_csrf_token";

    #[Serializer\Type('string')]
    #[Serializer\SerializedName(\Partitura\Dto\Form\AbstractFormRequestDto::CSRF_TOKEN_KEY)]
    protected ?string $csrfToken = null;

    public function getCsrfToken(): string
    {
        return (string)$this->csrfToken;
    }

    /**
     *
     * @return $this
     */
    public function setCsrfToken(string $csrfToken): static
    {
        $this->csrfToken = $csrfToken;

        return $this;
    }

    abstract public function getRouteName(): string;
}
