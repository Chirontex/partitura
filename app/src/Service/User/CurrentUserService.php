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
    /** @var Security */
    protected $securityHelper;

    public function __construct(Security $securityHelper)
    {
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
}
