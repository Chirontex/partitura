<?php
declare(strict_types=1);

namespace Partitura\Dto;

/**
 * Class AuthenticationDto
 * @package Partitura\Dto
 */
class AuthenticationDto
{
    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    /** @var bool */
    protected $needToRemember;

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
     * @return bool
     */
    public function isNeedToRemember() : bool
    {
        return (bool)$this->needToRemember;
    }

    /**
     * @param bool $needToRemember
     *
     * @return $this
     */
    public function setNeedToRemember(bool $needToRemember) : static
    {
        $this->needToRemember = $needToRemember;

        return $this;
    }
}
