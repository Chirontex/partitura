<?php

namespace Partitura\Entity;

use Doctrine\ORM\Mapping as ORM;
use Partitura\Repository\UserRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User main entity.
 * @package Partitura\Entity
 * 
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name=User::TABLE_NAME)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const TABLE_NAME = "p_users";

    /**
     * @var int
     * 
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="ID")
     */
    protected $id;

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
     * @var int
     * 
     * @ORM\Column(
     *     type="integer",
     *     name="ROLE",
     *     length=8,
     *     nullable=true
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
     * @return int
     */
    public function getId() : int
    {
        return (int)$this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier() : string
    {
        return (string)$this->getUsername();
    }

    /**
     * @see UserInterface
     */
    public function getRoles() : array
    {
        // TODO: доработать метод после создания сущности роли и связи между пользователем и ролью
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * TODO: доработать метод после создания сущности роли и связи между пользователем и ролью
     * @param int $role
     *
     * @return $this
     */
    public function setRole(int $role) : static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    public function setPassword(string $password) : static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
        // TODO: доработать метод после добавления функционала запоминания
    }
}
