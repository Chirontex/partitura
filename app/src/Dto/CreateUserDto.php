<?php
declare(strict_types=1);

namespace Partitura\Dto;

use Partitura\Enum\RoleEnum;
use Partitura\Exception\CaseNotFoundException;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class CreateUserDto
 * @package Partitura\Dto
 */
class CreateUserDto
{
    public const USERNAME = "username";
    public const PASSWORD = "password";
    public const ROLE = "role";

    /**
     * @var string
     * 
     * @Assert\NotNull
     * 
     * @Serializer\Type("string")
     * @Serializer\SerializedName(CreateUserDto::USERNAME)
     */
    protected $username;

    /**
     * @var string
     * 
     * @Assert\NotNull
     * 
     * @Serializer\Type("string")
     * @Serializer\SerializedName(CreateUserDto::PASSWORD)
     */
    protected $password;

    /**
     * @var string
     * 
     * @Serializer\Type("string")
     * @Serializer\SerializedName(CreateUserDto::ROLE)
     */
    protected $role;

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

    /**
     * @return string
     */
    public function getRole() : string
    {
        return empty($this->role) ? RoleEnum::ROLE_USER->value : (string)$this->role;
    }

    /**
     * @param RoleEnum $role
     *
     * @return $this
     */
    public function setRole(RoleEnum $role) : static
    {
        $this->role = $role->value;

        return $this;
    }

    /**
     * @Assert\Callback
     *
     * @param ExecutionContextInterface $context
     * @param mixed $payload
     */
    public function validateRole(ExecutionContextInterface $context, $payload) : void
    {
        if (empty($this->role)) {
            return;
        }

        try {
            RoleEnum::getInstanceByValue($this->role);
        } catch (CaseNotFoundException) {
            $context
                ->buildViolation("Invalid role.")
                ->atPath(static::ROLE)
                ->addViolation();
        }
    }
}
