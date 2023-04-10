<?php

declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Partitura\Entity\Trait\HasCodeTrait;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Entity\Trait\HasNameTrait;
use Partitura\Enum\RoleEnum;
use Partitura\Exception\CaseNotFoundException;
use Partitura\Repository\RoleRepository;

/**
 * Role entity.
 */
#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ORM\Table(name: Role::TABLE_NAME)]
class Role
{
    use HasIdTrait;
    use HasCodeTrait;
    use HasNameTrait;

    public const TABLE_NAME = "pt_roles";

    #[ORM\OneToMany(
        targetEntity: '\Partitura\Entity\User',
        mappedBy: 'role'
    )]
    protected ?PersistentCollection $users = null;

    #[ORM\OneToMany(
        targetEntity: 'Partitura\Entity\RoleUnitReference',
        mappedBy: 'role'
    )]
    protected ?PersistentCollection $unitReferences = null;

    /**
     * @return null|PersistentCollection<User>
     */
    public function getUsers(): ?PersistentCollection
    {
        return $this->users;
    }

    /**
     * Remove user from old role's list and add to this role.
     *
     * @return $this
     */
    public function addUser(User $user): static
    {
        $user->getRole()->getUsers()->removeElement($user);
        $user->setRole($this);

        $this->users->add($user);

        return $this;
    }

    /**
     * @return null|PersistentCollection<RoleUnitReference>
     */
    public function getUnitReferences(): ?PersistentCollection
    {
        return $this->unitReferences;
    }

    /**
     * @throws CaseNotFoundException
     */
    public function getEnumInstance(): RoleEnum
    {
        return RoleEnum::getInstanceByValue($this->getCode());
    }
}
