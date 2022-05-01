<?php
declare(strict_types=1);

namespace Partitura\Interfaces;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @package Partitura\Interfaces
 */
interface PasswordUpgradableUserInterface extends PasswordAuthenticatedUserInterface
{
    /**
     * @param string $password
     */
    public function setPassword(string $password);
}
