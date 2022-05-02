<?php
declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\Role;
use Partitura\Exception\EntityNotFoundException;

/**
 * Roles repository.
 * @package Partitura\Repository
 * @extends Repository<Role>
 * 
 * @method Role|null find($id, $lockMode = null, $lockVersion = null)
 * @method Role|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArrayCollection<int, Role> findAll()
 * @method ArrayCollection<Role> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }

    /**
     * @param string $code
     *
     * @throws EntityNotFoundException
     * @return Role
     */
    public function findByCode(string $code) : Role
    {
        $role = $this->findOneBy(["code" => $code]);

        if ($role === null) {
            throw new EntityNotFoundException(sprintf(
                "Role with code %s was not found.",
                $code
            ));
        }

        return $role;
    }
}
