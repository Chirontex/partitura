<?php
declare(strict_types=1);

namespace Partitura\Dto;

use DateTime;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class PostResponseDto
 * @package Partitura\Dto
 */
class PostResponseDto
{
    /**
     * @var string
     * 
     * @Serializer\Type("string")
     * @Serializer\SerializedName("title")
     */
    protected $title;

    /**
     * @var string
     * 
     * @Serializer\Type("string")
     * @Serializer\SerializedName("author")
     */
    protected $author;

    /**
     * @var string
     * 
     * @Serializer\Type("string")
     * @Serializer\SerializedName("date_created")
     */
    protected $dateCreated;

    /**
     * @var string
     * 
     * @Serializer\Type("string")
     * @Serializer\SerializedName("content")
     */
    protected $content;

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return (string)$this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title) : static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor() : string
    {
        return (string)$this->author;
    }

    /**
     * @param string $author
     *
     * @return $this
     */
    public function setAuthor(string $author) : static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateCreated() : string
    {
        return (string)$this->dateCreated;
    }

    /**
     * @param null|DateTime $dateCreated
     *
     * @return $this
     */
    public function setDateCreated(?DateTime $dateCreated) : static
    {
        $this->dateCreated = $dateCreated?->format("Y-m-d H:i");

        return $this;
    }

    /**
     * @return string
     */
    public function getContent() : string
    {
        return (string)$this->content;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content) : static
    {
        $this->content = $content;

        return $this;
    }
}
