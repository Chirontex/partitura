<?php
declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role unit reference entity.
 * @package Partitura\Entity
 */
class RoleUnitReference
{
    public const TABLE_NAME = "p_role_unit_references";

    /**
     * @var Role
     * 
     * @ORM\Id
     * @ORM\ManyToOne(
     *     targetEntity="\Partitura\Entity\Role",
     *     inversedBy="unitReferences"
     * )
     */
    protected $role;

    /**
     * @var Unit
     * 
     * @ORM\Id
     * @ORM\ManyToOne(
     *     targetEntity="\Partitura\Entity\Unit",
     *     inversedBy="roleReferences"
     * )
     */
    protected $unit;

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
     * @return Unit
     */
    public function getUnit() : Unit
    {
        return $this->unit;
    }

    /**
     * @param Unit $unit
     *
     * @return $this
     */
    public function setUnit(Unit $unit) : static
    {
        $this->unit = $unit;

        return $this;
    }
}
