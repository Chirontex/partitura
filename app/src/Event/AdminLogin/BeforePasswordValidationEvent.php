<?php

declare(strict_types=1);

namespace Partitura\Event\AdminLogin;

use Partitura\Entity\User;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class BeforePasswordValidationEvent
 */
class BeforePasswordValidationEvent extends Event
{
    public function __construct(
        protected User $user,
        protected PasswordCredentials $passwordCredentials
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getPasswordCredentials(): PasswordCredentials
    {
        return $this->passwordCredentials;
    }
}
