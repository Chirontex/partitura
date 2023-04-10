<?php

declare(strict_types=1);

namespace Partitura\Dto;

/**
 * Class AuthenticationDto.
 */
class AuthenticationDto
{
    protected ?string $username = null;

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
