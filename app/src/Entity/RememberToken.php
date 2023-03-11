<?php
declare(strict_types=1);

namespace Partitura\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Partitura\Repository\RememberTokenRepository;

/**
 * Remember-me-token entity.
 * @package Partitura\Entity
 * 
 * @ORM\Entity(repositoryClass=RememberTokenRepository::class)
 * @ORM\Table(name=RememberToken::TABLE_NAME)
 */
class RememberToken
{
    public const TABLE_NAME = "rememberme_token";

    /**
     * @ORM\Id
     * @ORM\Column(type="string", name="series", length=88)
     */
    protected string $series;

    /**
     * @ORM\Column(type="string", name="value", length=88)
     */
    protected string $value;

    /**
     * @ORM\Column(type="datetime", name="lastUsed")
     */
    protected ?DateTime $lastUsed;

    /**
     * @ORM\Column(type="string", name="class", length=100)
     */
    protected string $class;

    /**
     * @ORM\Column(type="string", name="username", length=200)
     */
    protected string $username;

    /**
     * @return string
     */
    public function getSeries() : string
    {
        return (string)$this->series;
    }

    /**
     * @param string $series
     *
     * @return $this
     */
    public function setSeries(string $series) : static
    {
        $this->series = $series;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue() : string
    {
        return (string)$this->value;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setValue(string $value) : static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return null|DateTime
     */
    public function getLastUsed() : ?DateTime
    {
        return $this->lastUsed;
    }

    /**
     * @param DateTime $lastUsed
     *
     * @return $this
     */
    public function setLastUsed(DateTime $lastUsed) : static
    {
        $this->lastUsed = $lastUsed;

        return $this;
    }

    /**
     * @return string
     */
    public function getClass() : string
    {
        return (string)$this->class;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function setClass(string $class) : static
    {
        $this->class = $class;

        return $this;
    }

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
}
