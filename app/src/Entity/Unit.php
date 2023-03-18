<?php
declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Partitura\Entity\Trait\HasCodeTrait;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Repository\UnitRepository;

/**
 * Unit entity.
 * @package Partitura\Entity
 */
#[ORM\Entity(repositoryClass: UnitRepository::class)]
#[ORM\Table(name: Unit::TABLE_NAME)]
class Unit
{
    use HasIdTrait,
        HasCodeTrait;

    public const TABLE_NAME = "pt_units";

    #[ORM\OneToMany(
        targetEntity: 'Partitura\Entity\RoleUnitReference',
        mappedBy: 'unit'
    )]    
    protected ?PersistentCollection $roleReferences = null;

    /**
     * @return null|PersistentCollection<UnitRoleReferences>
     */
    public function getRoleReferences() : ?PersistentCollection
    {
        return $this->roleReferences;
    }
}
