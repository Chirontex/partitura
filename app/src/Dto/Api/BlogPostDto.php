<?php

declare(strict_types=1);

namespace Partitura\Dto\Api;

use DateTime;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class BlogPostDto.
 */
class BlogPostDto
{
    #[Serializer\Type('string')]
    #[Serializer\SerializedName('title')]
    protected ?string $title = null;

    #[Serializer\Type('string')]
    #[Serializer\SerializedName('preview')]
    protected ?string $preview = null;

    #[Serializer\Type('string')]
    #[Serializer\SerializedName('author')]
    protected ?string $author = null;

    #[Serializer\Type('string')]
    #[Serializer\SerializedName('uri')]
    protected ?string $uri = null;

    #[Serializer\Type('string')]
    #[Serializer\SerializedName('date_created')]
    protected ?string $dateCreated = null;

    public function getTitle(): string
    {
        return (string)$this->title;
    }

    /**
     *
     * @return $this
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPreview(): string
    {
        return (string)$this->preview;
    }

    /**
     *
     * @return $this
     */
    public function setPreview(string $preview): static
    {
        $this->preview = $preview;

        return $this;
    }

    public function getAuthor(): string
    {
        return (string)$this->author;
    }

    /**
     *
     * @return $this
     */
    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getUri(): string
    {
        return (string)$this->uri;
    }

    /**
     *
     * @return $this
     */
    public function setUri(string $uri): static
    {
        $this->uri = $uri;

        return $this;
    }

    public function getDateCreated(): string
    {
        return (string)$this->dateCreated;
    }

    /**
     *
     * @return $this
     */
    public function setDateCreated(?DateTime $dateCreated): static
    {
        $this->dateCreated = $dateCreated?->format("Y-m-d H:i");

        return $this;
    }
}
