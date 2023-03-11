<?php
declare(strict_types=1);

namespace Partitura\Event\AdminLogin;

use Partitura\Entity\User;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class BeforePasswordValidationEvent
 * @package Partitura\Event\AdminLogin
 */
class BeforePasswordValidationEvent extends Event
{
    public function __construct(
        protected User $user,
        protected PasswordCredentials $passwordCredentials
    ) {
    }

    /**
     * @return User
     */
    public function getUser() : User
    {
        return $this->user;
    }

    /**
     * @return PasswordCredentials
     */
    public function getPasswordCredentials() : PasswordCredentials
    {
        return $this->passwordCredentials;
    }
}
