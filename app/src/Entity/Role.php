<?php
declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Partitura\Entity\Trait\HasCodeTrait;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Entity\Trait\HasNameTrait;
use Partitura\Enum\RoleEnum;
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
        HasCodeTrait,
        HasNameTrait;

    public const TABLE_NAME = "pt_roles";

    /**
     * @var null|PersistentCollection<User>
     * 
     * @ORM\OneToMany(
     *     targetEntity="\Partitura\Entity\User",
     *     mappedBy="role"
     * )
     */
    protected $users;

    /**
     * @var null|PersistentCollection<RoleUnitReference>
     * 
     * @ORM\OneToMany(
     *     targetEntity="Partitura\Entity\RoleUnitReference",
     *     mappedBy="role"
     * )
     */
    protected $unitReferences;

    /**
     * @return null|PersistentCollection<User>
     */
    public function getUsers() : ?PersistentCollection
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
     * @return null|PersistentCollection<RoleUnitReference>
     */
    public function getUnitReferences() : ?PersistentCollection
    {
        return $this->unitReferences;
    }

    /**
     * @return RoleEnum
     */
    public function getEnumInstance() : RoleEnum
    {
        return RoleEnum::getInstanceByValue($this->getCode());
    }
}
