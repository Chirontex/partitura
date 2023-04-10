<?php

declare(strict_types=1);

namespace Partitura\Interfaces;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

interface PasswordUpgradableUserInterface extends PasswordAuthenticatedUserInterface
{
    public function setPassword(string $password);
}
