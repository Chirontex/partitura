<?php
declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Partitura\Entity\Trait\HasCodeTrait;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Repository\UnitRepository;

/**
 * Unit entity.
 * @package Partitura\Entity
 * 
 * @ORM\Entity(repositoryClass=UnitRepository::class)
 * @ORM\Table(name=Unit::TABLE_NAME)
 */
class Unit
{
    use HasIdTrait,
        HasCodeTrait;

    public const TABLE_NAME = "pt_units";

    /**
     * @var ArrayCollection<RoleUnitReference>
     * 
     * @ORM\OneToMany(
     *     targetEntity="Partitura\Entity\RoleUnitReference",
     *     mappedBy="unit"
     * )
     */
    protected $roleReferences;

    public function __construct()
    {
        $this->roleReferences = new ArrayCollection();
    }

    /**
     * @return ArrayCollection<UnitRoleReferences>
     */
    public function getRoleReferences() : ArrayCollection
    {
        return $this->roleReferences;
    }
}
