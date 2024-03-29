<?php

declare(strict_types=1);

namespace Partitura\Factory;

use Doctrine\Persistence\ManagerRegistry;
use Partitura\Dto\CreateUserDto;
use Partitura\Entity\Role;
use Partitura\Entity\User;
use Partitura\Enum\RoleEnum;
use Partitura\Exception\EntityNotFoundException;
use Partitura\Repository\RoleRepository;
use Partitura\Service\User\PasswordSettingService;

/**
 * Class UserFactory.
 */
class UserFactory
{
    protected RoleRepository $roleRepository;

    public function __construct(
        ManagerRegistry $registry,
        protected PasswordSettingService $passwordSettingService
    ) {
        $this->roleRepository = $registry->getRepository(Role::class);
    }

    /**
     *
     * @throws EntityNotFoundException
     */
    public function createUser(CreateUserDto $createUserDto): User
    {
        /*
         * У пользователя обязательно должна быть роль, поэтому если она до сих пор не была определена, то определяем её здесь.
         */
        if (empty($createUserDto->getRole())) {
            $createUserDto->setRole(RoleEnum::ROLE_USER);
        }

        $user = (new User())
            ->setUsername($createUserDto->getUsername())
            ->setRole($this->getRole($createUserDto->getRole()));

        $this->passwordSettingService->setNewPassword($user, $createUserDto->getPassword());

        return $user;
    }

    /**
     *
     * @throws EntityNotFoundException
     */
    protected function getRole(string $roleCode): Role
    {
        return $this->roleRepository->findByCode($roleCode);
    }
}
