<?php

declare(strict_types=1);

namespace Partitura\Service\User;

use Partitura\Entity\User;
use Partitura\Exception\PasswordUpgradeException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Main service for users's password setting.
 */
class PasswordSettingService
{
    public function __construct(
        protected PasswordUpgraderInterface $passwordUpgrader,
        protected UserPasswordHasherInterface $passwordHasher
    ) {
    }

    /**
     *
     * @throws PasswordUpgradeException
     */
    public function setNewPassword(User $user, string $newPassword): void
    {
        $this->passwordUpgrader->upgradePassword(
            $user,
            $this->passwordHasher->hashPassword($user, $newPassword)
        );
    }
}
