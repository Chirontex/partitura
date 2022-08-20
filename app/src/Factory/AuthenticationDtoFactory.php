<?php
declare(strict_types=1);

namespace Partitura\Factory;

use Partitura\Dto\AuthenticationDto;
use Partitura\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

/**
 * Class AuthenticationDtoFactory
 * @package Partitura\Factory
 */
class AuthenticationDtoFactory
{
    /**
     * @param Request $request
     *
     * @throws AuthenticationException
     * @return AuthenticationDto
     */
    public function createAuthenticationDto(Request $request) : AuthenticationDto
    {
        $username = (string)$request->get("_username");

        if (empty($username)) {
            throw new AuthenticationException("Username cannot be empty.");
        }

        $request->attributes->set(Security::LAST_USERNAME, $username);

        $password = (string)$request->get("_password");

        if (empty($password)) {
            throw new AuthenticationException("Password cannot be empty.");
        }

        return (new AuthenticationDto())
            ->setUsername($username)
            ->setPassword($password)
            ->setNeedToRemember(!empty($request->get("_remember_me")));
    }
}
