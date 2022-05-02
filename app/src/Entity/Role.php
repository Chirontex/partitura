<?php
declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Partitura\Entity\Trait\HasCodeTrait;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Repository\RoleRepository;

/**
 * Role entity.
 * @package Partitura\Entity
 * 
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 * @ORM\Table(name=Role::TABLE_NAME)
 */
class Role
{
    use HasIdTrait,
        HasCodeTrait;

    public const TABLE_NAME = "p_roles";

    /**
     * @var string
     * 
     * @ORM\Column(
     *     type="string",
     *     name="NAME",
     *     length=180
     * )
     */
    protected $name;

    /**
     * @var ArrayCollection<User>
     * 
     * @ORM\OneToMany(
     *     targetEntity="\Partitura\Entity\User",
     *     mappedBy="role"
     * )
     */
    protected $users;

    /**
     * @var ArrayCollection<RoleUnitReference>
     * 
     * @ORM\OneToMany(
     *     targetEntity="Partitura\Entity\RoleUnitReference",
     *     mappedBy="role"
     * )
     */
    protected $unitReferences;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->unitReferences = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return (string)$this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name) : static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return ArrayCollection<User>
     */
    public function getUsers() : ArrayCollection
    {
        return $this->users;
    }

    /**
     * Remove user from old role's list and add to this role.
     * @param User $user
     *
     * @return $this
     */
    public function addUser(User $user) : static
    {
        $user->getRole()->getUsers()->removeElement($user);
        $user->setRole($this);

        $this->users->add($user);

        return $this;
    }

    /**
     * @return ArrayCollection<RoleUnitReference>
     */
    public function getUnitReferences() : ArrayCollection
    {
        return $this->unitReferences;
    }
}
