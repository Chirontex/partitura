<?php
declare(strict_types=1);

namespace Partitura\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Interfaces\PasswordUpgradableUserInterface;
use Partitura\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User main entity.
 * @package Partitura\Entity
 * 
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name=User::TABLE_NAME)
 */
class User implements UserInterface, PasswordUpgradableUserInterface
{
    use HasIdTrait;

    public const TABLE_NAME = "p_users";

    /**
     * @var string
     * 
     * @ORM\Column(
     *     type="string",
     *     name="USERNAME",
     *     length=180,
     *     unique=true
     * )
     */
    protected $username;

    /**
     * @var Role
     * 
     * @ORM\ManyToOne(
     *     targetEntity="\Partitura\Entity\Role",
     *     fetch="EAGER",
     *     inversedBy="users"
     * )
     */
    protected $role;

    /**
     * @var string
     * 
     * @ORM\Column(
     *     type="string",
     *     name="PASSWORD_HASH",
     *     length=180
     * )
     */
    protected $password;

    /**
     * @var int
     * 
     * @ORM\Column(
     *     type="smallint",
     *     name="ACTIVE",
     *     options={"default":1}
     * )
     */
    protected $active;

    /**
     * @var DateTime
     * 
     * @ORM\Column(type="datetime", name="DATETIME_CREATED")
     */
    protected $datetimeCreated;

    /**
     * @var null|DateTime
     * 
     * @ORM\Column(type="datetime", name="DATETIME_UPDATED", nullable=true)
     */
    protected $datetimeUpdated;

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
     * A visual identifier that represents this user.
     * {@inheritDoc}
     * @see UserInterface
     */
    public function getUserIdentifier() : string
    {
        return $this->getUsername();
    }

    /**
     * {@inheritDoc}
     * @see UserInterface
     */
    public function getRoles() : array
    {
        if ($this->role !== null) {
            return [$this->role->getCode()];
        }

        return ["ROLE_USER"];
    }

    /**
     * @return Role
     */
    public function getRole() : Role
    {
        return $this->role;
    }

    /**
     * @param Role $role
     *
     * @return $this
     */
    public function setRole(Role $role) : static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * {@inheritDoc}
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * {@inheritDoc}
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
    public function getActive() : bool
    {
        return $this->active === 1;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive(bool $active) : static
    {
        $this->active = $active ? 1 : 0;

        return $this;
    }

    /**
     * @return null|DateTime
     */
    public function getDatetimeCreated() : ?DateTime
    {
        return $this->datetimeCreated;
    }

    /**
     * @param DateTime $datetimeCreated
     *
     * @return $this
     */
    public function setDateTimeCreated(DateTime $datetimeCreated) : static
    {
        $this->datetimeCreated = $datetimeCreated;

        return $this;
    }

    /**
     * @return null|DateTime
     */
    public function getDatetimeUpdated() : ?DateTime
    {
        return $this->datetimeUpdated;
    }

    /**
     * @param DateTime $datetimeUpdated
     *
     * @return $this
     */
    public function setDatetimeUpdated(DateTime $datetimeUpdated) : static
    {
        $this->datetimeUpdated = $datetimeUpdated;

        return $this;
    }

    /**
     * {@inheritDoc}
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
        // TODO: доработать метод после добавления функционала запоминания
    }
}
