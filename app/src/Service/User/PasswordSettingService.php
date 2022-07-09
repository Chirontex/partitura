<?php
declare(strict_types=1);

namespace Partitura\Service\User;

use Partitura\Entity\User;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Main service for users's password setting.
 * @package Partitura\Service\User
 */
class PasswordSettingService
{
    /** @var PasswordUpgraderInterface */
    protected $passwordUpgrader;

    /** @var UserPasswordHasherInterface */
    protected $passwordHasher;

    public function __construct(
        PasswordUpgraderInterface $passwordUpgrader,
        UserPasswordHasherInterface $userPasswordHasher
    ) {
        $this->passwordHasher = $userPasswordHasher;
        $this->passwordUpgrader = $passwordUpgrader;
    }

    /**
     * @param User $user
     * @param string $newPassword
     */
    public function setNewPassword(User $user, string $newPassword) : void
    {
        $this->passwordUpgrader->upgradePassword(
            $user,
            $this->passwordHasher->hashPassword($user, $newPassword)
        );
    }
}
