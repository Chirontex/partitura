<?php
declare(strict_types=1);

namespace Partitura\Dto;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserChangePasswordDto
 * @package Partitura\Dto
 */
class UserChangePasswordDto
{
    public const USERNAME = "username";
    public const PASSWORD = "password";

    /**
     * @var string
     * 
     * @Assert\NotNull
     * 
     * @Serializer\Type("string")
     * @Serializer\SerializedName(UserChangePasswordDto::USERNAME)
     */
    protected $username;

    /**
     * @var string
     * 
     * @Assert\NotNull
     * 
     * @Serializer\Type("string")
     * @Serializer\SerializedName(UserChangePasswordDto::PASSWORD)
     */
    protected $password;

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return (string)$this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username) : static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return (string)$this->password;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password) : static
    {
        $this->password = $password;

        return $this;
    }
}
