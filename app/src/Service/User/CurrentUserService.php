<?php
declare(strict_types=1);

namespace Partitura\Service\User;

use Partitura\Entity\User;
use Symfony\Component\Security\Core\Security;

/**
 * Class CurrentUserService
 * @package Partitura\Service\User
 */
class CurrentUserService
{
    public function __construct(protected Security $securityHelper)
    {
    }

    /**
     * @return null|User
     */
    public function getCurrentUser() : ?User
    {
        $user = $this->securityHelper->getUser();

        return $user instanceof User ? $user : null;
    }
}
