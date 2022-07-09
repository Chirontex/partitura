<?php
declare(strict_types=1);

namespace Partitura\Factory;

use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\Role;
use Partitura\Entity\User;
use Partitura\Enum\RoleEnum;
use Partitura\Exception\EntityNotFoundException;
use Partitura\Repository\RoleRepository;
use Partitura\Service\User\PasswordSettingService;

/**
 * Class UserFactory
 * @package Partitura\Factory
 */
class UserFactory
{
    /** @var RoleRepository */
    protected $roleRepository;

    /** @var PasswordSettingService */
    protected $passwordSettingService;

    public function __construct(
        ManagerRegistry $registry,
        PasswordSettingService $passwordSettingService
    ) {
        $this->roleRepository = $registry->getRepository(Role::class);
        $this->passwordSettingService = $passwordSettingService;
    }

    /**
     * @param string $username
     * @param string $plainPassword
     * @param string $roleCode If empty, it will be "ROLE_USER".
     *
     * @throws EntityNotFoundException
     * @return User
     */
    public function createUser(
        string $username,
        string $plainPassword,
        string $roleCode = ""
    ) : User {
        if (empty($roleCode)) {
            $roleCode = RoleEnum::ROLE_USER->value;
        }

        $user = (new User())
            ->setUsername($username)
            ->setRole($this->getRole($roleCode));

        $this->passwordSettingService->setNewPassword($user, $plainPassword);

        return $user;
    }

    /**
     * @param string $roleCode
     *
     * @throws EntityNotFoundException
     * @return Role
     */
    protected function getRole(string $roleCode) : Role
    {
        return $this->roleRepository->findByCode($roleCode);
    }
}
