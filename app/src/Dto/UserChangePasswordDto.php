<?php

declare(strict_types=1);

namespace Partitura\Dto;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserChangePasswordDto
 */
class UserChangePasswordDto
{
    public const USERNAME = "username";

    public const PASSWORD = "password";

    #[Assert\NotNull]
    #[Serializer\Type('string')]
    #[Serializer\SerializedName(UserChangePasswordDto::USERNAME)]
    protected ?string $username = null;

    #[Assert\NotNull]
    #[Serializer\Type('string')]
    #[Serializer\SerializedName(UserChangePasswordDto::PASSWORD)]
    protected ?string $password = null;

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
}
