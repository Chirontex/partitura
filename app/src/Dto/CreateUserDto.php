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
 */
class CreateUserDto
{
    public const USERNAME = "username";

    public const PASSWORD = "password";

    public const ROLE = "role";

    #[Assert\NotNull]
    #[Serializer\Type('string')]
    #[Serializer\SerializedName(CreateUserDto::USERNAME)]
    protected ?string $username = null;

    #[Assert\NotNull]
    #[Serializer\Type('string')]
    #[Serializer\SerializedName(CreateUserDto::PASSWORD)]
    protected ?string $password = null;

    #[Serializer\Type('string')]
    #[Serializer\SerializedName(CreateUserDto::ROLE)]
    protected ?string $role = null;

    public function getUsername(): string
    {
        return (string)$this->username;
    }

    /**
     *
     * @return $this
     */
    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return (string)$this->password;
    }

    /**
     *
     * @return $this
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): string
    {
        return empty($this->role) ? RoleEnum::ROLE_USER->value : (string)$this->role;
    }

    /**
     *
     * @return $this
     */
    public function setRole(RoleEnum $role): static
    {
        $this->role = $role->value;

        return $this;
    }

    /**
     * @Assert\Callback
     *
     */
    public function validateRole(ExecutionContextInterface $context, $payload): void
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
