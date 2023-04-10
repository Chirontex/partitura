<?php

declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\ORM\Mapping as ORM;
use Partitura\Repository\RoleUnitReferenceRepository;

/**
 * Role unit reference entity.
 */
#[ORM\Entity(repositoryClass: RoleUnitReferenceRepository::class)]
#[ORM\Table(name: RoleUnitReference::TABLE_NAME)]
class RoleUnitReference
{
    public const TABLE_NAME = "pt_role_unit_references";

    #[ORM\Id]
    #[ORM\JoinColumn(
        name: 'ROLE_ID',
        referencedColumnName: 'ID',
        nullable: false
    )]
    #[ORM\ManyToOne(
        targetEntity: '\Partitura\Entity\Role',
        inversedBy: 'unitReferences'
    )]
    protected ?Role $role = null;

    #[ORM\Id]
    #[ORM\JoinColumn(
        name: 'UNIT_ID',
        referencedColumnName: 'ID',
        nullable: false
    )]
    #[ORM\ManyToOne(
        targetEntity: '\Partitura\Entity\Unit',
        inversedBy: 'roleReferences'
    )]
    protected ?Unit $unit = null;

    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     *
     * @return $this
     */
    public function setRole(Role $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getUnit(): Unit
    {
        return $this->unit;
    }

    /**
     *
     * @return $this
     */
    public function setUnit(Unit $unit): static
    {
        $this->unit = $unit;

        return $this;
    }
}
