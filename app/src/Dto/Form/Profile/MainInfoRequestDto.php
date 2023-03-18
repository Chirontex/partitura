<?php
declare(strict_types=1);

namespace Partitura\Dto\Form\Profile;

use JMS\Serializer\Annotation as Serializer;
use Partitura\Controller\Profile\ProfileController;
use Partitura\Dto\Form\AbstractFormRequestDto;

/**
 * Class MainInfoRequestDto
 * @package Partitura\Dto\Form\Profile
 */
class MainInfoRequestDto extends AbstractFormRequestDto
{
    #[Serializer\Type('string')]
    #[Serializer\SerializedName('first_name')]   
    protected ?string $firstName = null;

    #[Serializer\Type('string')]
    #[Serializer\SerializedName('last_name')]    
    protected ?string $lastName = null;

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

    /** {@inheritDoc} */
    public function getRouteName() : string
    {
        return ProfileController::ROUTE_MAIN_INFO;
    }
}
