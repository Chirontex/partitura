<?php

declare(strict_types=1);

namespace Partitura\Service\User;

use Partitura\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class CurrentUserService.
 */
class CurrentUserService
{
    public function __construct(protected Security $securityHelper)
    {
    }

    public function getCurrentUser(): ?User
    {
        $user = $this->securityHelper->getUser();

        return $user instanceof User ? $user : null;
    }
}
