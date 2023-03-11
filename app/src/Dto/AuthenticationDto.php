<?php
declare(strict_types=1);

namespace Partitura\Dto;

/**
 * Class AuthenticationDto
 * @package Partitura\Dto
 */
class AuthenticationDto
{
    protected ?string $username = null;

    protected ?string $password = null;

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
