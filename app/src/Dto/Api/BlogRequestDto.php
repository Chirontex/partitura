<?php
declare(strict_types=1);

namespace Partitura\Dto\Api;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class BlogRequestDto
 * @package Partitura\Dto\Api
 */
class BlogRequestDto
{
    /**
     * @Assert\NotBlank(message="Page cannot be empty.")
     * @Assert\Positive(message="Invalid page value.")
     * 
     * @Serializer\Type("int")
     * @Serializer\SerializedName("page")
     */
    protected int $page = 1;

    /**
     * @Assert\PositiveOrZero(message="Invalid limit value.")
     * 
     * @Serializer\Type("int")
     * @Serializer\SerializedName("limit")
     */
    protected int $limit = 0;

    /**
     * @return int
     */
    public function getPage() : int
    {
        return (int)$this->page;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function setPage(int $page) : static
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit() : int
    {
        return (int)$this->limit;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function setLimit(int $limit) : static
    {
        $this->limit = $limit;

        return $this;
    }
}
