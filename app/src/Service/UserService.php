<?php
declare(strict_types=1);

namespace Partitura\Service;

use Partitura\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * Class UserService
 * @package Partitura\Service
 */
class UserService
{
    /** @var UserPasswordHasherInterface */
    protected $passwordHasher;

    /** @var PasswordUpgraderInterface */
    protected $passwordUpgrader;

    /** @var Security */
    protected $securityHelper;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        PasswordUpgraderInterface $passwordUpgrader,
        Security $securityHelper
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->passwordUpgrader = $passwordUpgrader;
        $this->securityHelper = $securityHelper;
    }

    /**
     * @return null|User
     */
    public function getCurrentUser() : ?User
    {
        $user = $this->securityHelper->getUser();

        return $user instanceof User ? $user : null;
    }

    /**
     * @param User $user
     * @param string $newPassword
     */
    public function updatePassword(User $user, string $newPassword) : void
    {
        $this->passwordUpgrader->upgradePassword(
            $user,
            $this->passwordHasher->hashPassword($user, $newPassword)
        );
    }
}
