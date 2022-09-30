<?php
declare(strict_types=1);

namespace Partitura\Dto\Form\Profile;

use JMS\Serializer\Annotation as Serializer;
use Partitura\Dto\Form\AbstractFormRequestDto;

/**
 * Class MainInfoRequestDto
 * @package Partitura\Dto\Form\Profile
 */
class MainInfoRequestDto extends AbstractFormRequestDto
{
    /**
     * @var string
     * 
     * @Serializer\Type("string")
     * @Serializer\SerializedName("_first_name")
     */
    protected $firstName;

    /**
     * @var string
     * 
     * @Serializer\Type("string")
     * @Serializer\SerializedName("_last_name")
     */
    protected $lastName;

    /**
     * @return string
     */
    public function getFirstName() : string
    {
        return (string)$this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName(string $firstName) : static
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName() : string
    {
        return (string)$this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName(string $lastName) : static
    {
        $this->lastName = $lastName;

        return $this;
    }
}
