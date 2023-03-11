<?php
declare(strict_types=1);

namespace Partitura\Service;

use Partitura\Event\PasswordUpgrade\AfterEvent;
use Partitura\Event\PasswordUpgrade\BeforeEvent;
use Partitura\Exception\PasswordUpgradeException;
use Partitura\Interfaces\PasswordUpgradableUserInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * Class PasswordUpgradeService
 * @package Partitura\Service
 */
class PasswordUpgradeService implements PasswordUpgraderInterface
{
    public function __construct(protected EventDispatcherInterface $eventDispatcher)
    {
    }

    /**
     * {@inheritDoc}
     *
     * @param PasswordAuthenticatedUserInterface $user
     * @param string $newHashedPassword
     * 
     * @throws PasswordUpgradeException
     */
    public function upgradePassword(
        PasswordAuthenticatedUserInterface $user,
        string $newHashedPassword
    ) : void {
        $this->eventDispatcher->dispatch(new BeforeEvent($user));

        if (!($user instanceof PasswordUpgradableUserInterface)) {
            throw new PasswordUpgradeException(sprintf(
                "Password of instance %s cannot be upgraded.",
                get_class($user)
            ));
        }

        $user->setPassword($newHashedPassword);

        $this->eventDispatcher->dispatch(new AfterEvent($user));
    }
}
