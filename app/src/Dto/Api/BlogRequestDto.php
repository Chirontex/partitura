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
     * @var int
     * 
     * @Assert\NotBlank(message="Limit cannot be empty.")
     * @Assert\Positive(message="Invalid limit value.")
     * 
     * @Serializer\Type("int")
     * @Serializer\SerializedName("limit")
     */
    protected $limit;

    /**
     * @var int
     * 
     * @Assert\PositiveOrZero(message="Invalid offset value.")
     * 
     * @Serializer\Type("int")
     * @Serializer\SerializedName("offset")
     */
    protected $offset;

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

    /**
     * @return int
     */
    public function getOffset() : int
    {
        return (int)$this->offset;
    }

    /**
     * @param int $offset
     *
     * @return $this
     */
    public function setOffset(int $offset) : static
    {
        $this->offset = $offset;

        return $this;
    }
}
