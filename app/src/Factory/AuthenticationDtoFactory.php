<?php

declare(strict_types=1);

namespace Partitura\Factory;

use Partitura\Dto\AuthenticationDto;
use Partitura\Exception\AuthenticationException;
use Partitura\Exception\SkipAuthenticationException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthenticationDtoFactory.
 */
class AuthenticationDtoFactory
{
    /**
     *
     * @throws AuthenticationException
     */
    public function createAuthenticationDto(Request $request): AuthenticationDto
    {
        $username = (string)$request->get("_username");
        $password = (string)$request->get("_password");

        if (empty($username) && empty($password)) {
            throw new SkipAuthenticationException();
        }

        if (empty($username)) {
            throw new AuthenticationException("Username cannot be empty.");
        }

        $request->attributes->set(Security::LAST_USERNAME, $username);

        if (empty($password)) {
            throw new AuthenticationException("Password cannot be empty.");
        }

        return (new AuthenticationDto())
            ->setUsername($username)
            ->setPassword($password);
    }
}
