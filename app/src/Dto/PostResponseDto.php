<?php

declare(strict_types=1);

namespace Partitura\Dto;

use DateTime;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class PostResponseDto.
 */
class PostResponseDto
{
    #[Serializer\Type('string')]
    #[Serializer\SerializedName('title')]
    protected ?string $title = null;

    #[Serializer\Type('string')]
    #[Serializer\SerializedName('author')]
    protected ?string $author = null;

    #[Serializer\Type('string')]
    #[Serializer\SerializedName('date_created')]
    protected ?string $dateCreated = null;

    #[Serializer\Type('string')]
    #[Serializer\SerializedName('content')]
    protected ?string $content = null;

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

    public function getContent(): string
    {
        return (string)$this->content;
    }

    /**
     *
     * @return $this
     */
    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }
}
