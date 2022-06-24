<?php
declare(strict_types=1);

namespace Partitura\Dto\Api;

use DateTime;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class BlogPostDto
 * @package Partitura\Dto\Api
 */
class BlogPostDto
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
     * @Serializer\SerializedName("preview")
     */
    protected $preview;

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
     * @Serializer\SerializedName("uri")
     */
    protected $uri;

    /**
     * @var string
     * 
     * @Serializer\Type("string")
     * @Serializer\SerializedName("date_created")
     */
    protected $dateCreated;

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
    public function getPreview() : string
    {
        return (string)$this->preview;
    }

    /**
     * @param string $preview
     *
     * @return $this
     */
    public function setPreview(string $preview) : static
    {
        $this->preview = $preview;

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
    public function getUri() : string
    {
        return (string)$this->uri;
    }

    /**
     * @param string $uri
     *
     * @return $this
     */
    public function setUri(string $uri) : static
    {
        $this->uri = $uri;

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
}
